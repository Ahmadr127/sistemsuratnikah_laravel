@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center py-8 px-4">
    <div class="perspective w-full max-w-4xl mx-auto">
        <div class="card-container {{ request()->routeIs('register') ? 'flipped' : '' }}">
            <!-- Front - Login -->
            <div class="card front">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row">
                    <!-- Left Side - Info -->
                    <div class="md:w-5/12 bg-gradient-to-br from-primary to-secondary p-8 text-white flex flex-col justify-center items-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="relative z-10 text-center">
                            <div class="w-20 h-20 bg-white/10 rounded-2xl backdrop-blur-sm flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-heart text-3xl"></i>
                            </div>
                            <h2 class="text-3xl font-bold mb-4">Selamat Datang!</h2>
                            <p class="text-white/80 mb-6">Masuk ke akun Anda untuk mengakses layanan buku nikah digital</p>
                            <p class="text-sm">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-white font-semibold hover:text-white/90 underline flip-trigger">Daftar disini</a>
                            </p>
                        </div>
                    </div>
                    <!-- Right Side - Login Form -->
                    <div class="md:w-7/12 p-8">
                        <div class="max-w-md mx-auto">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8">Login</h3>
                            @if ($errors->any())
                                <div class="mb-4 p-4 rounded-xl bg-red-50 border-l-4 border-red-500">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </span>
                                        <input type="email" name="email" id="email" required 
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                               value="{{ old('email') }}" placeholder="nama@example.com">
                                    </div>
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </span>
                                        <input type="password" name="password" id="password" required 
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                               placeholder="Masukkan password">
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="remember" id="remember" 
                                               class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                                        <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                                    </div>
                                </div>
                                <button type="submit" 
                                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition duration-200">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back - Register -->
            <div class="card back">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row">
                    <!-- Left Side - Info -->
                    <div class="md:w-5/12 bg-gradient-to-br from-primary to-secondary p-8 text-white flex flex-col justify-center items-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="relative z-10 text-center">
                            <div class="w-20 h-20 bg-white/10 rounded-2xl backdrop-blur-sm flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-user-plus text-3xl"></i>
                            </div>
                            <h2 class="text-3xl font-bold mb-4">Buat Akun Baru</h2>
                            <p class="text-white/80 mb-6">Daftar sekarang untuk mengakses layanan buku nikah digital</p>
                            <p class="text-sm">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-white font-semibold hover:text-white/90 underline flip-trigger">Login disini</a>
                            </p>
                        </div>
                    </div>
                    <!-- Right Side - Register Form -->
                    <div class="md:w-7/12 p-8">
                        <div class="max-w-md mx-auto">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8">Register</h3>
                            @if ($errors->any())
                                <div class="mb-4 p-4 rounded-xl bg-red-50 border-l-4 border-red-500">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </span>
                                        <input type="text" name="name" id="name" required 
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                               value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </span>
                                        <input type="email" name="email" id="email" required 
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                               value="{{ old('email') }}" placeholder="nama@example.com">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-secondary transition-colors">
                                            <input type="radio" name="gender" value="L" class="sr-only" required>
                                            <i class="fas fa-male mr-2 text-gray-500"></i>
                                            <span class="text-sm font-medium text-gray-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:border-secondary transition-colors">
                                            <input type="radio" name="gender" value="P" class="sr-only" required>
                                            <i class="fas fa-female mr-2 text-gray-500"></i>
                                            <span class="text-sm font-medium text-gray-700">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </span>
                                        <input type="password" name="password" id="password" required 
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                               placeholder="Minimal 8 karakter">
                                    </div>
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                    <div class="mt-1 relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary"
                                               placeholder="Ulangi password">
                                    </div>
                                </div>
                                <button type="submit" 
                                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition duration-200">
                                    <i class="fas fa-user-plus mr-2"></i> Daftar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Perspective container */
.perspective {
    perspective: 2000px;
    padding: 24px;
}

/* Card container */
.card-container {
    position: relative;
    width: 100%;
    min-height: calc(100vh - 16rem); /* Adjust space for navbar and footer */
    transition: transform 0.8s;
    transform-style: preserve-3d;
    margin: 2rem 0;
}

/* Flip animation */
.card-container.flipped {
    transform: rotateY(180deg);
}

/* Cards */
.card {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    transform-style: preserve-3d;
}

.card.front {
    z-index: 2;
}

.card.back {
    transform: rotateY(180deg);
}

/* Form inputs animation */
input, button {
    transition: all 0.3s ease;
}

input:focus {
    transform: translateY(-1px);
}

/* Gender selection animation */
input[type="radio"]:checked + label {
    border-color: var(--secondary-color);
    background-color: var(--secondary-color);
    color: white;
}

/* Button hover effect */
button:hover {
    transform: translateY(-2px);
}

/* Background pattern */
.pattern-bg {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.344 0L13.858 8.485 15.272 9.9l7.9-7.9h-.828zm5.656 0L17.515 10.485 18.93 11.9l7.9-7.9h-2.83zm5.656 0L23.172 12.485 24.586 13.9l7.9-7.9h-2.83zm5.656 0L28.828 14.485 30.242 15.9l7.9-7.9h-2.83zm5.656 0L34.485 16.485 35.9 17.9l7.9-7.9h-2.83zm5.656 0L40.142 18.485 41.556 19.9l7.9-7.9h-2.83zm5.656 0L45.798 20.485 47.212 21.9l7.9-7.9h-2.83zm5.656 0L51.455 22.485 52.87 23.9l7.9-7.9h-2.83zM6.485 11.03L0 17.515l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.656L0 23.172l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 28.828l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 34.485l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 40.142l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 45.798l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 51.455l1.414 1.414 7.9-7.9-2.83-2.83zM6.485 11.03L0 17.515l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.656L0 23.172l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 28.828l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 34.485l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 40.142l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 45.798l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 51.455l1.414 1.414 7.9-7.9-2.83-2.83zM6.485 11.03L0 17.515l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.656L0 23.172l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 28.828l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 34.485l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 40.142l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 45.798l1.414 1.414 7.9-7.9-2.83-2.83zm0 5.657L0 51.455l1.414 1.414 7.9-7.9-2.83-2.83z' fill='%23000000' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle flip animation triggers
    const flipTriggers = document.querySelectorAll('.flip-trigger');
    const cardContainer = document.querySelector('.card-container');
    
    flipTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            cardContainer.classList.toggle('flipped');
            
            // Update URL without page reload
            const newUrl = this.href;
            window.history.pushState({}, '', newUrl);
        });
    });

    // Handle gender selection styling
    const genderInputs = document.querySelectorAll('input[name="gender"]');
    genderInputs.forEach(input => {
        input.addEventListener('change', function() {
            genderInputs.forEach(inp => {
                const label = inp.closest('label');
                if (inp.checked) {
                    label.classList.add('bg-secondary', 'text-white');
                    label.classList.remove('text-gray-700');
                } else {
                    label.classList.remove('bg-secondary', 'text-white');
                    label.classList.add('text-gray-700');
                }
            });
        });
    });
});
</script>
@endsection