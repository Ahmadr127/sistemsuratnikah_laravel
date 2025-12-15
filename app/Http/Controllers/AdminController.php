<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marriage;
use App\Models\KtpData;
use App\Services\KtpApiService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    protected $ktpApiService;

    public function __construct(KtpApiService $ktpApiService)
    {
        $this->middleware('admin');
        $this->ktpApiService = $ktpApiService;
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_regular_users' => User::where('role', 'user')->count(),
            'total_marriages' => Marriage::count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_marriages = Marriage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_marriages'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    public function marriages()
    {
        $marriages = Marriage::with('createdBy')->paginate(10);
        return view('admin.marriages', compact('marriages'));
    }

    /**
     * Show the form for creating a new marriage
     */
    public function createMarriage()
    {
        return view('admin.marriage.create');
    }

    /**
     * Search NIK for marriage verification using KTP API
     */
    public function searchNik(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'groom_nik' => 'required|string|size:16|regex:/^\d{16}$/',
            'bride_nik' => 'required|string|size:16|regex:/^\d{16}$/',
        ], [
            'groom_nik.required' => 'NIK calon pengantin pria wajib diisi.',
            'groom_nik.size' => 'NIK calon pengantin pria harus 16 digit.',
            'groom_nik.regex' => 'NIK calon pengantin pria harus berupa angka.',
            'bride_nik.required' => 'NIK calon pengantin wanita wajib diisi.',
            'bride_nik.size' => 'NIK calon pengantin wanita harus 16 digit.',
            'bride_nik.regex' => 'NIK calon pengantin wanita harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $groomNik = $request->input('groom_nik');
        $brideNik = $request->input('bride_nik');

        try {
            // Get KTP data from API
            $groomApiResponse = $this->ktpApiService->getKtpByNik($groomNik);
            $brideApiResponse = $this->ktpApiService->getKtpByNik($brideNik);

            // Check if both API calls were successful
            if (!$groomApiResponse['success'] || !$brideApiResponse['success']) {
                $errors = [];
                if (!$groomApiResponse['success']) {
                    $errors['groom_nik'] = $groomApiResponse['message'];
                }
                if (!$brideApiResponse['success']) {
                    $errors['bride_nik'] = $brideApiResponse['message'];
                }

                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput();
            }

            // Validate KTP data for marriage eligibility
            $groomValidation = $this->ktpApiService->validateKtpForMarriage($groomApiResponse['data']);
            $brideValidation = $this->ktpApiService->validateKtpForMarriage($brideApiResponse['data']);

            if (!$groomValidation['valid'] || !$brideValidation['valid']) {
                $errors = [];
                if (!$groomValidation['valid']) {
                    $errors['groom_nik'] = $groomValidation['message'];
                }
                if (!$brideValidation['valid']) {
                    $errors['bride_nik'] = $brideValidation['message'];
                }

                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput();
            }

            // Format data for marriage form
            $groomData = $this->ktpApiService->formatKtpForMarriage($groomApiResponse['data']);
            $brideData = $this->ktpApiService->formatKtpForMarriage($brideApiResponse['data']);

            // Store the data in session for the next step
            session([
                'marriage_data' => [
                    'groom' => $groomData,
                    'bride' => $brideData,
                    'groom_nik' => $groomNik,
                    'bride_nik' => $brideNik,
                    'groom_ktp_data' => $groomApiResponse['data'],
                    'bride_ktp_data' => $brideApiResponse['data'],
                ]
            ]);

            return redirect()->route('admin.marriage.create-form')
                ->with('success', 'Data NIK berhasil diverifikasi melalui API KTP. Silakan lengkapi informasi pernikahan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memverifikasi NIK. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Show the marriage form after NIK verification
     */
    public function createMarriageForm()
    {
        // Check if marriage data exists in session
        $marriageData = session('marriage_data');
        
        if (!$marriageData) {
            return redirect()->route('admin.marriage.create')
                ->with('error', 'Silakan verifikasi NIK terlebih dahulu.');
        }

        return view('admin.marriage.form', compact('marriageData'));
    }

    /**
     * Store the marriage data
     */
    public function storeMarriage(Request $request)
    {
        // Check if marriage data exists in session
        $marriageData = session('marriage_data');
        
        if (!$marriageData) {
            return redirect()->route('admin.marriage.create')
                ->with('error', 'Silakan verifikasi NIK terlebih dahulu.');
        }

        // Validate marriage form data
        $validator = Validator::make($request->all(), [
            'marriage_date' => 'required|date|after_or_equal:today',
            'marriage_place' => 'required|string|max:255',
            'witness1_name' => 'required|string|max:255',
            'witness2_name' => 'required|string|max:255',
        ], [
            'marriage_date.required' => 'Tanggal pernikahan wajib diisi.',
            'marriage_date.date' => 'Format tanggal pernikahan tidak valid.',
            'marriage_date.after_or_equal' => 'Tanggal pernikahan tidak boleh lebih dari hari ini.',
            'marriage_place.required' => 'Tempat pernikahan wajib diisi.',
            'witness1_name.required' => 'Nama saksi 1 wajib diisi.',
            'witness2_name.required' => 'Nama saksi 2 wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create marriage record
            $marriage = Marriage::create([
                'groom_nik' => $marriageData['groom_nik'],
                'groom_name' => $marriageData['groom']['name'],
                'groom_birth_date' => $marriageData['groom']['birth_date'],
                'groom_birth_place' => $marriageData['groom']['birth_place'],
                'groom_address' => $marriageData['groom']['address'],
                'bride_nik' => $marriageData['bride_nik'],
                'bride_name' => $marriageData['bride']['name'],
                'bride_birth_date' => $marriageData['bride']['birth_date'],
                'bride_birth_place' => $marriageData['bride']['birth_place'],
                'bride_address' => $marriageData['bride']['address'],
                'marriage_date' => $request->input('marriage_date'),
                'marriage_place' => $request->input('marriage_place'),
                'witness1_name' => $request->input('witness1_name'),
                'witness2_name' => $request->input('witness2_name'),
                'status' => 'active',
                'created_by' => auth()->id(),
            ]);

            // Clear session data
            session()->forget('marriage_data');

            return redirect()->route('admin.marriages')
                ->with('success', 'Buku nikah berhasil dibuat untuk ' . $marriage->groom_name . ' dan ' . $marriage->bride_name . '. Data pernikahan tersimpan di database.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data pernikahan. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Show all KTP data from API
     */
    public function ktpData()
    {
        try {
            $apiResponse = $this->ktpApiService->getAllKtp();
            
            if ($apiResponse['success']) {
                $ktpData = $apiResponse['data'] ?? [];
                $total = $apiResponse['total'] ?? 0;
                
                // Ensure ktpData is an array
                if (!is_array($ktpData)) {
                    $ktpData = [];
                }
            } else {
                $ktpData = [];
                $total = 0;
                session()->flash('error', $apiResponse['message'] ?? 'Gagal mengambil data KTP');
            }
        } catch (\Exception $e) {
            $ktpData = [];
            $total = 0;
            session()->flash('error', 'Terjadi kesalahan saat mengambil data KTP: ' . $e->getMessage());
        }

        return view('admin.ktp-data', compact('ktpData', 'total'));
    }

    /**
     * Search KTP by NIK
     */
    public function searchKtp(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|regex:/^\d{16}$/',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.regex' => 'NIK harus berupa angka.',
        ]);

        $nik = $request->input('nik');
        $apiResponse = $this->ktpApiService->getKtpByNik($nik);

        if ($apiResponse['success']) {
            $ktpData = $apiResponse['data'];
            return view('admin.ktp-detail', compact('ktpData'));
        } else {
            return redirect()->back()
                ->withErrors(['nik' => $apiResponse['message']])
                ->withInput();
        }
    }

    /**
     * Show marriage detail
     */
    public function showMarriage($id)
    {
        $marriage = Marriage::with('createdBy')->findOrFail($id);
        return view('admin.marriage.show', compact('marriage'));
    }

    /**
     * Show edit form for marriage
     */
    public function editMarriage($id)
    {
        $marriage = Marriage::findOrFail($id);
        return view('admin.marriage.edit', compact('marriage'));
    }

    /**
     * Update marriage data
     */
    public function updateMarriage(Request $request, $id)
    {
        $marriage = Marriage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'marriage_date' => 'required|date',
            'marriage_place' => 'required|string|max:255',
            'witness1_name' => 'required|string|max:255',
            'witness2_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $marriage->update([
                'marriage_date' => $request->input('marriage_date'),
                'marriage_place' => $request->input('marriage_place'),
                'witness1_name' => $request->input('witness1_name'),
                'witness2_name' => $request->input('witness2_name'),
            ]);

            return redirect()->route('admin.marriages')
                ->with('success', 'Data pernikahan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data pernikahan.'])
                ->withInput();
        }
    }

    /**
     * Delete marriage record
     */
    public function deleteMarriage($id)
    {
        try {
            $marriage = Marriage::findOrFail($id);
            $groomName = $marriage->groom_name;
            $brideName = $marriage->bride_name;
            
            $marriage->delete();

            return redirect()->route('admin.marriages')
                ->with('success', "Data pernikahan {$groomName} dan {$brideName} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus data pernikahan.']);
        }
    }

    /**
     * Print marriage certificate as PDF
     */
    public function printMarriage($id)
    {
        $marriage = Marriage::findOrFail($id);
        
        // Generate PDF using the same view as user print
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('marriage.print-pdf', compact('marriage'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'Buku_Nikah_' . $marriage->groom_name . '_' . $marriage->bride_name . '_' . now()->format('Ymd') . '.pdf';
        
        // Stream PDF
        return $pdf->stream($filename);
    }
}
