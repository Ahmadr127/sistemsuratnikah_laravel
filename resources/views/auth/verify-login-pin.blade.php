@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center py-8 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-white"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Verifikasi Keamanan</h2>
                <p class="text-gray-600 text-sm mt-2">Masukkan kode 4 digit yang telah dikirim ke email Anda</p>
            </div>

            <!-- Email Info -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-envelope text-blue-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Kode dikirim ke:</p>
                        <p class="font-semibold text-gray-900">{{ $email }}</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Verifikasi Gagal:</h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- PIN Input Form -->
            <form method="POST" action="{{ route('login.verify-pin') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-2">Kode Verifikasi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-key text-gray-400"></i>
                        </span>
                        <input type="text" 
                               name="pin" 
                               id="pin" 
                               inputmode="numeric" 
                               pattern="\d{4}" 
                               maxlength="4" 
                               minlength="4" 
                               required 
                               autofocus
                               class="block w-full pl-10 pr-3 py-3 text-center text-2xl tracking-[0.5em] border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                               placeholder="0000">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-clock mr-1"></i>
                        Kode berlaku selama 10 menit
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-primary to-secondary text-white font-semibold py-3 rounded-lg hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-check-circle mr-2"></i>
                    Verifikasi Sekarang
                </button>

                <!-- Help Text -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-600">
                        Tidak menerima kode? 
                        <a href="{{ route('login') }}" class="text-secondary hover:underline font-semibold">
                            Kembali ke Login
                        </a>
                    </p>
                </div>
            </form>

            <!-- Security Info -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-gray-400 mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        <p class="text-xs text-gray-600">
                            <strong>Tips Keamanan:</strong> Jangan pernah berikan kode verifikasi ini kepada siapa pun. 
                            Sistem kami tidak akan pernah meminta kode verifikasi melalui chat, telepon, atau email tambahan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    input[type="text"]:focus {
        outline: none;
    }
</style>
@endsection
