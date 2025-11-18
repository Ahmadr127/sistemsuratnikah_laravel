<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marriage;
use Illuminate\Support\Facades\Auth;
use App\Services\KtpApiService;
use Illuminate\Support\Facades\Validator;

class MarriageController extends Controller
{
    protected KtpApiService $ktpApiService;

    public function __construct(KtpApiService $ktpApiService)
    {
        $this->ktpApiService = $ktpApiService;
    }

    public function showRequestForm()
    {
        $prefill = session('marriage_prefill');
        return view('marriage.request-form', compact('prefill'));
    }

    public function searchNik(Request $request)
    {
        $request->validate([
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

        $groomNik = $request->input('groom_nik');
        $brideNik = $request->input('bride_nik');

        $groomRes = $this->ktpApiService->getKtpByNik($groomNik);
        $brideRes = $this->ktpApiService->getKtpByNik($brideNik);

        $errors = [];
        if (!$groomRes['success']) { $errors['groom_nik'] = $groomRes['message'] ?? 'Gagal mengambil data KTP.'; }
        if (!$brideRes['success']) { $errors['bride_nik'] = $brideRes['message'] ?? 'Gagal mengambil data KTP.'; }
        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        $groomValid = $this->ktpApiService->validateKtpForMarriage($groomRes['data']);
        $brideValid = $this->ktpApiService->validateKtpForMarriage($brideRes['data']);
        if (!$groomValid['valid'] || !$brideValid['valid']) {
            if (!$groomValid['valid']) { $errors['groom_nik'] = $groomValid['message']; }
            if (!$brideValid['valid']) { $errors['bride_nik'] = $brideValid['message']; }
            return back()->withErrors($errors)->withInput();
        }
        $groom = $this->ktpApiService->formatKtpForMarriage($groomRes['data']);
        $bride = $this->ktpApiService->formatKtpForMarriage($brideRes['data']);

        session(['marriage_prefill' => [
            'groom' => $groom,
            'bride' => $bride,
        ]]);

        return redirect()->route('marriage.request')->with('success', 'Data NIK berhasil diverifikasi. Silakan lengkapi formulir.');
    }

    public function submitRequest(Request $request)
    {
        // Validate request aligned to migration fields
        $request->validate([
            'groom_name' => 'required|string|max:255',
            'groom_nik' => 'required|string|size:16|regex:/^\d{16}$/',
            'groom_birth_date' => 'required|date',
            'groom_birth_place' => 'required|string|max:255',
            'groom_address' => 'required|string',
            'bride_name' => 'required|string|max:255',
            'bride_nik' => 'required|string|size:16|regex:/^\d{16}$/',
            'bride_birth_date' => 'required|date',
            'bride_birth_place' => 'required|string|max:255',
            'bride_address' => 'required|string',
            'marriage_date' => 'required|date|after_or_equal:today',
            'marriage_place' => 'required|string|max:255',
            'witness1_name' => 'required|string|max:255',
            'witness2_name' => 'required|string|max:255',
        ]);

        // Create new marriage with default status 'active' per migration
        Marriage::create([
            'groom_nik' => $request->groom_nik,
            'groom_name' => $request->groom_name,
            'groom_birth_date' => $request->groom_birth_date,
            'groom_birth_place' => $request->groom_birth_place,
            'groom_address' => $request->groom_address,
            'bride_nik' => $request->bride_nik,
            'bride_name' => $request->bride_name,
            'bride_birth_date' => $request->bride_birth_date,
            'bride_birth_place' => $request->bride_birth_place,
            'bride_address' => $request->bride_address,
            'marriage_date' => $request->marriage_date,
            'marriage_place' => $request->marriage_place,
            'witness1_name' => $request->witness1_name,
            'witness2_name' => $request->witness2_name,
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);

        // Clear prefill after submission
        session()->forget('marriage_prefill');

        return redirect()->route('marriage.status')->with('success', 'Pengajuan buku nikah berhasil disubmit.');
    }

    public function status()
    {
        $marriages = Marriage::where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marriage.status', compact('marriages'));
    }
}