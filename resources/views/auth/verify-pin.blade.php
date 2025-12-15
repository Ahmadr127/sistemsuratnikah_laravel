@extends('layouts.app')

@section('content')
<!-- Verification Page with Modern Design -->
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-scale-in">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-4 animate-float">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Verifikasi Kode PIN</h1>
                <p class="text-blue-100 text-sm">Masukkan kode 4 digit yang telah dikirim</p>
            </div>

            <!-- Body -->
            <div class="px-8 py-8">
                @if(session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 animate-fade-in-up">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <p class="text-green-800 font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 animate-fade-in-up">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Email Info -->
                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                    <div class="flex items-center justify-center text-center">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>
                        <p class="text-sm text-gray-700">
                            Kode dikirim ke: <span class="font-semibold text-blue-600">{{ $email }}</span>
                        </p>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('pin.verify') }}" class="space-y-6" id="pinForm">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3 text-center">
                            Masukkan Kode Verifikasi
                        </label>
                        
                        <!-- PIN Input Container -->
                        <div class="flex justify-center gap-3 mb-4">
                            <input type="text" maxlength="1" class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" data-index="0" inputmode="numeric" pattern="\d">
                            <input type="text" maxlength="1" class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" data-index="1" inputmode="numeric" pattern="\d">
                            <input type="text" maxlength="1" class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" data-index="2" inputmode="numeric" pattern="\d">
                            <input type="text" maxlength="1" class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300" data-index="3" inputmode="numeric" pattern="\d">
                        </div>
                        
                        <!-- Hidden input for actual PIN value -->
                        <input type="hidden" name="pin" id="pinValue" required>
                        
                        <p class="text-xs text-center text-gray-500 flex items-center justify-center">
                            <i class="fas fa-clock mr-1 text-amber-500"></i>
                            <span>Kode berlaku selama <strong class="text-amber-600">10 menit</strong></span>
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl px-6 py-3.5 font-semibold hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verifikasi Sekarang
                    </button>
                </form>

                <!-- Resend Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Tidak menerima kode?
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition-colors">
                            Kirim Ulang
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="text-sm font-medium">Kembali ke Login</span>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const pinValueInput = document.getElementById('pinValue');
    const form = document.getElementById('pinForm');

    // Focus first input on load
    otpInputs[0].focus();

    otpInputs.forEach((input, index) => {
        // Handle input
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            
            // Only allow numbers
            if (!/^\d*$/.test(value)) {
                e.target.value = '';
                return;
            }

            // Move to next input if value entered
            if (value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            // Update hidden PIN value
            updatePinValue();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').trim();
            
            if (/^\d{4}$/.test(pastedData)) {
                pastedData.split('').forEach((char, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = char;
                    }
                });
                otpInputs[3].focus();
                updatePinValue();
            }
        });
    });

    function updatePinValue() {
        const pin = Array.from(otpInputs).map(input => input.value).join('');
        pinValueInput.value = pin;
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const pin = pinValueInput.value;
        if (pin.length !== 4) {
            e.preventDefault();
            alert('Mohon masukkan 4 digit kode verifikasi');
            otpInputs[0].focus();
        }
    });
});
</script>
@endsection
