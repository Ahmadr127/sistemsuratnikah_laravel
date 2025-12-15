@extends('layouts.admin')

@section('title', 'Buat Buku Nikah - Admin')

@section('page_title', 'Buat Buku Nikah')

@section('content')
<!-- Header Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 w-12 h-12 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
            <span>Buat Buku Nikah</span>
        </h1>
        <a href="{{ route('admin.marriages') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali ke Daftar</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-500 hover:text-green-700 transition-colors" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button type="button" class="ml-auto text-red-500 hover:text-red-700 transition-colors" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

<div class="max-w-4xl mx-auto">
    <!-- Main Form Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Card Header with Gradient -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-search mr-3 text-2xl"></i>
                Verifikasi NIK Calon Pengantin
            </h2>
            <p class="text-blue-100 text-sm mt-1">Masukkan NIK untuk memverifikasi data calon pengantin</p>
        </div>

        <!-- Card Body -->
        <div class="p-8">
            <form id="nikSearchForm" action="{{ route('admin.marriage.search-nik') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Groom NIK -->
                    <div class="space-y-2">
                        <label for="groom_nik" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-male text-blue-500 mr-2"></i>NIK Calon Pengantin Pria
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-300 @error('groom_nik') border-red-500 @enderror" 
                                   id="groom_nik" 
                                   name="groom_nik" 
                                   placeholder="Masukkan 16 digit NIK"
                                   value="{{ old('groom_nik') }}"
                                   maxlength="16"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                        </div>
                        @error('groom_nik')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500" id="groom_nik_counter">0/16 digit</p>
                    </div>

                    <!-- Bride NIK -->
                    <div class="space-y-2">
                        <label for="bride_nik" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-female text-pink-500 mr-2"></i>NIK Calon Pengantin Wanita
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 transition-all duration-300 @error('bride_nik') border-red-500 @enderror" 
                                   id="bride_nik" 
                                   name="bride_nik" 
                                   placeholder="Masukkan 16 digit NIK"
                                   value="{{ old('bride_nik') }}"
                                   maxlength="16"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                        </div>
                        @error('bride_nik')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500" id="bride_nik_counter">0/16 digit</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>
                        Cari Data
                    </button>
                    <a href="{{ route('admin.marriages') }}" 
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-500/50 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Information Card -->
    <div class="mt-6 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-lg shadow-sm border border-cyan-100">
        <div class="px-6 py-4 border-b border-cyan-200 bg-white/50">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-info-circle text-white text-sm"></i>
                </div>
                Informasi Penting
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Steps -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <span class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center mr-2 text-xs">1</span>
                        Langkah-langkah:
                    </h4>
                    <ol class="space-y-2">
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                            <span>Masukkan NIK calon pengantin pria dan wanita</span>
                        </li>
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                            <span>Klik "Cari Data" untuk verifikasi NIK</span>
                        </li>
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                            <span>Lengkapi informasi pernikahan</span>
                        </li>
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                            <span>Simpan data pernikahan</span>
                        </li>
                    </ol>
                </div>

                <!-- Notes -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <span class="w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center mr-2 text-xs">!</span>
                        Catatan Penting:
                    </h4>
                    <ul class="space-y-2">
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-exclamation-triangle text-amber-500 mr-2 mt-0.5"></i>
                            <span>NIK harus berupa 16 digit angka</span>
                        </li>
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-exclamation-triangle text-amber-500 mr-2 mt-0.5"></i>
                            <span>Data akan diverifikasi melalui API resmi</span>
                        </li>
                        <li class="flex items-start text-sm text-gray-700">
                            <i class="fas fa-exclamation-triangle text-amber-500 mr-2 mt-0.5"></i>
                            <span>Pastikan NIK valid dan terdaftar</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // NIK validation function
    function validateNIK(nik) {
        return /^\d{16}$/.test(nik);
    }

    // Update character counter
    function updateCounter(input, counterId) {
        const counter = document.getElementById(counterId);
        const length = input.value.length;
        counter.textContent = `${length}/16 digit`;
        
        if (length === 16) {
            counter.classList.remove('text-gray-500');
            counter.classList.add('text-green-500', 'font-medium');
        } else {
            counter.classList.remove('text-green-500', 'font-medium');
            counter.classList.add('text-gray-500');
        }
    }

    // Real-time validation and formatting
    document.addEventListener('DOMContentLoaded', function() {
        const groomNikInput = document.getElementById('groom_nik');
        const brideNikInput = document.getElementById('bride_nik');
        
        if (groomNikInput) {
            groomNikInput.addEventListener('input', function() {
                // Remove non-digits
                const nik = this.value.replace(/\D/g, '');
                this.value = nik;
                
                // Update counter
                updateCounter(this, 'groom_nik_counter');
                
                // Visual validation feedback
                if (nik.length > 0 && nik.length < 16) {
                    this.classList.remove('border-gray-200', 'border-green-500');
                    this.classList.add('border-yellow-400');
                } else if (nik.length === 16 && validateNIK(nik)) {
                    this.classList.remove('border-gray-200', 'border-yellow-400', 'border-red-500');
                    this.classList.add('border-green-500');
                } else if (nik.length === 0) {
                    this.classList.remove('border-yellow-400', 'border-green-500', 'border-red-500');
                    this.classList.add('border-gray-200');
                }
            });
        }
        
        if (brideNikInput) {
            brideNikInput.addEventListener('input', function() {
                // Remove non-digits
                const nik = this.value.replace(/\D/g, '');
                this.value = nik;
                
                // Update counter
                updateCounter(this, 'bride_nik_counter');
                
                // Visual validation feedback
                if (nik.length > 0 && nik.length < 16) {
                    this.classList.remove('border-gray-200', 'border-green-500');
                    this.classList.add('border-yellow-400');
                } else if (nik.length === 16 && validateNIK(nik)) {
                    this.classList.remove('border-gray-200', 'border-yellow-400', 'border-red-500');
                    this.classList.add('border-green-500');
                } else if (nik.length === 0) {
                    this.classList.remove('border-yellow-400', 'border-green-500', 'border-red-500');
                    this.classList.add('border-gray-200');
                }
            });
        }
    });
</script>
@endsection
