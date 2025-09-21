<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Marriage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
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
     * Search NIK for marriage verification
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
            // TODO: Implement actual API call to NIK verification endpoint
            // For now, we'll simulate the API response structure
            
            // Simulate API call (replace with actual endpoint when ready)
            $groomData = $this->simulateNikApiCall($groomNik);
            $brideData = $this->simulateNikApiCall($brideNik);

            // Check if both NIKs are valid
            if ($groomData['valid'] && $brideData['valid']) {
                // Store the data in session for the next step
                session([
                    'marriage_data' => [
                        'groom' => $groomData['data'],
                        'bride' => $brideData['data'],
                        'groom_nik' => $groomNik,
                        'bride_nik' => $brideNik,
                    ]
                ]);

                return redirect()->route('admin.marriage.create-form')
                    ->with('success', 'Data NIK berhasil diverifikasi. Silakan lengkapi informasi pernikahan.');
            } else {
                $errors = [];
                if (!$groomData['valid']) {
                    $errors['groom_nik'] = $groomData['message'] ?? 'NIK calon pengantin pria tidak valid.';
                }
                if (!$brideData['valid']) {
                    $errors['bride_nik'] = $brideData['message'] ?? 'NIK calon pengantin wanita tidak valid.';
                }

                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput();
            }

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
                ->with('success', 'Buku nikah berhasil dibuat untuk ' . $marriage->groom_name . ' dan ' . $marriage->bride_name . '.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data pernikahan. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Simulate NIK API call (replace with actual implementation)
     */
    private function simulateNikApiCall($nik)
    {
        // TODO: Replace this with actual API call to NIK verification endpoint
        // Example structure for when the API is ready:
        /*
        try {
            $response = Http::timeout(30)->post('your-nik-api-endpoint', [
                'nik' => $nik
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'valid' => $data['status'] === 'success',
                    'data' => $data['data'] ?? null,
                    'message' => $data['message'] ?? null
                ];
            } else {
                return [
                    'valid' => false,
                    'data' => null,
                    'message' => 'Gagal memverifikasi NIK'
                ];
            }
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'data' => null,
                'message' => 'Terjadi kesalahan saat memverifikasi NIK'
            ];
        }
        */

        // Temporary simulation for development
        return [
            'valid' => true,
            'data' => [
                'nik' => $nik,
                'name' => 'Data Simulasi - ' . substr($nik, -4),
                'birth_date' => '1990-01-01',
                'birth_place' => 'Jakarta',
                'address' => 'Alamat Simulasi',
                'gender' => $nik[6] % 2 == 0 ? 'Perempuan' : 'Laki-laki',
            ],
            'message' => 'Data berhasil diverifikasi (simulasi)'
        ];
    }
}
