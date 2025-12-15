<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\VerificationCode;
use App\Mail\VerificationPinMail;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'alpha_num', 'ascii', 'min:3', 'max:30', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'gender' => ['required', 'in:L,P'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'gender' => $request->gender,
        ]);

        event(new Registered($user));

        // Generate and email 4-digit PIN for registration verification
        [$record, $pin] = VerificationCode::generate($user->email, $user->id, VerificationCode::TYPE_REGISTER);
        Mail::to($user->email)->send(new VerificationPinMail($pin, VerificationCode::TYPE_REGISTER));

        session(['pin_flow' => [
            'type' => VerificationCode::TYPE_REGISTER,
            'email' => $user->email,
        ]]);

        return redirect()->route('pin.verify.form', ['type' => VerificationCode::TYPE_REGISTER, 'email' => $user->email])
            ->with('success', 'Akun berhasil dibuat! Kami telah mengirimkan kode verifikasi ke email Anda.');
    }
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $loginField = $request->input('email');
        $password = $request->input('password');

        // Determine if login field is email or username
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Try to find user by detected field
        $user = User::where($fieldType, $loginField)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Generate and email PIN for login verification (MFA)
            [$record, $pin] = VerificationCode::generate($user->email, $user->id, 'login_mfa');
            Mail::to($user->email)->send(new VerificationPinMail($pin, 'login_mfa'));

            // Store user info in session for PIN verification
            session(['login_attempt' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'remember' => $request->boolean('remember'),
            ]]);
            
            return redirect()->route('login.verify-pin.form')
                ->with('success', 'Kode verifikasi telah dikirimkan ke email Anda.');
        }

        return back()->withErrors([
            'email' => 'Username/Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show login PIN verification form
     */
    public function showLoginVerifyPin()
    {
        if (!session('login_attempt')) {
            return redirect()->route('login');
        }

        return view('auth.verify-login-pin', [
            'email' => session('login_attempt.email'),
        ]);
    }

    /**
     * Verify login PIN
     */
    public function verifyLoginPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4',
        ]);

        if (!session('login_attempt')) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $email = session('login_attempt.email');
        $userId = session('login_attempt.user_id');
        $pin = $request->input('pin');

        // Find the verification code
        $verification = VerificationCode::where('email', $email)
            ->where('type', 'login_mfa')
            ->whereNull('consumed_at')
            ->latest()
            ->first();

        if (!$verification || !$verification->checkAndConsume($pin)) {
            $verification?->save();
            return back()->withErrors([
                'pin' => 'Kode verifikasi salah atau sudah kadaluarsa.',
            ]);
        }

        // Save and clear session
        $verification->save();
        $remember = session('login_attempt.remember');
        session()->forget('login_attempt');

        // Login the user
        $user = User::find($userId);
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Login berhasil!');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
