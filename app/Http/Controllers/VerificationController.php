<?php

namespace App\Http\Controllers;

use App\Mail\VerificationPinMail;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetPin(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        [$record, $pin] = VerificationCode::generate($user->email, $user->id, VerificationCode::TYPE_PASSWORD_RESET);
        Mail::to($user->email)->send(new VerificationPinMail($pin, VerificationCode::TYPE_PASSWORD_RESET));

        session(['pin_flow' => [
            'type' => VerificationCode::TYPE_PASSWORD_RESET,
            'email' => $user->email,
        ]]);

        return redirect()->route('pin.verify.form', ['type' => VerificationCode::TYPE_PASSWORD_RESET, 'email' => $user->email])
            ->with('status', 'Kode verifikasi telah dikirim ke email Anda.');
    }

    public function showVerifyForm(Request $request)
    {
        $type = $request->query('type');
        $email = $request->query('email');
        abort_unless(in_array($type, [VerificationCode::TYPE_REGISTER, VerificationCode::TYPE_PASSWORD_RESET, 'login_mfa'], true), 404);
        abort_unless($email && filter_var($email, FILTER_VALIDATE_EMAIL), 404);
        return view('auth.verify-pin', compact('type', 'email'));
    }

    public function verifyPin(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'type' => ['required', 'in:register,password_reset,login_mfa'],
            'pin' => ['required', 'digits:4'],
        ]);

        $record = VerificationCode::where('email', $data['email'])
            ->where('type', $data['type'])
            ->whereNull('consumed_at')
            ->latest('id')
            ->first();

        if (!$record || !$record->checkAndConsume($data['pin'])) {
            return back()->withErrors(['pin' => 'Kode tidak valid atau sudah kedaluwarsa.'])->withInput();
        }

        if ($data['type'] === VerificationCode::TYPE_REGISTER) {
            // On successful registration verification, log the user in
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                return redirect()->route('register')->withErrors(['email' => 'Akun tidak ditemukan. Silakan daftar ulang.']);
            }
            Auth::login($user);
            $request->session()->forget('pin_flow');
            return redirect('/')->with('success', 'Akun berhasil diverifikasi. Selamat datang!');
        }

        // For password reset, allow reset and redirect to reset form
        session(['password_reset_allowed' => $data['email']]);
        return redirect()->route('password.reset.form', ['email' => $data['email']])
            ->with('status', 'Verifikasi berhasil. Silakan buat password baru.');
    }

    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        abort_unless($email && filter_var($email, FILTER_VALIDATE_EMAIL), 404);

        // ensure verified via session
        if (session('password_reset_allowed') !== $email) {
            return redirect()->route('forgot.password')->withErrors(['email' => 'Sesi reset password tidak valid.']);
        }

        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        ]);

        if (session('password_reset_allowed') !== $data['email']) {
            return redirect()->route('forgot.password')->withErrors(['email' => 'Sesi reset password tidak valid.']);
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        // clear session flag
        $request->session()->forget('password_reset_allowed');

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}
