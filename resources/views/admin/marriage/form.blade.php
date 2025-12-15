@extends('layouts.admin')

@section('title', 'Form Pernikahan - Admin')

@section('page_title', 'Form Pernikahan')

@section('content')
<!-- Header Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 w-12 h-12 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
            <span>Form Pernikahan</span>
        </h1>
        <a href="{{ route('admin.marriage.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali ke Pencarian NIK</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
            <button type="button" class="ml-auto text-green-500 hover:text-green-700" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
            <button type="button" class="ml-auto text-red-500 hover:text-red-700" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

<div class="max-w-6xl mx-auto">
    <!-- Groom Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-male text-white"></i>
                </div>
                Data Calon Pengantin Pria
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" value="{{ $marriageData['groom']['nik'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" value="{{ $marriageData['groom']['name'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" value="{{ $marriageData['groom']['birth_place'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($marriageData['groom']['birth_date'])->format('d F Y') }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <input type="text" value="{{ $marriageData['groom']['gender'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                    <input type="text" value="{{ $marriageData['groom']['religion'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                    <input type="text" value="{{ $marriageData['groom']['occupation'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan</label>
                    <input type="text" value="{{ $marriageData['groom']['marital_status'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>{{ $marriageData['groom']['address'] }}, {{ $marriageData['groom']['village'] }}, {{ $marriageData['groom']['district'] }}, {{ $marriageData['groom']['city'] }}, {{ $marriageData['groom']['province'] }} {{ $marriageData['groom']['postal_code'] }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Bride Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-pink-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-female text-white"></i>
                </div>
                Data Calon Pengantin Wanita
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" value="{{ $marriageData['bride']['nik'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" value="{{ $marriageData['bride']['name'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" value="{{ $marriageData['bride']['birth_place'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($marriageData['bride']['birth_date'])->format('d F Y') }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <input type="text" value="{{ $marriageData['bride']['gender'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                    <input type="text" value="{{ $marriageData['bride']['religion'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                    <input type="text" value="{{ $marriageData['bride']['occupation'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan</label>
                    <input type="text" value="{{ $marriageData['bride']['marital_status'] }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>{{ $marriageData['bride']['address'] }}, {{ $marriageData['bride']['village'] }}, {{ $marriageData['bride']['district'] }}, {{ $marriageData['bride']['city'] }}, {{ $marriageData['bride']['province'] }} {{ $marriageData['bride']['postal_code'] }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Marriage Information Form Card -->
    <form id="marriageForm" action="{{ route('admin.marriage.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-violet-600 to-purple-700 px-6 py-5">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-calendar-alt mr-3 text-2xl"></i>
                    Informasi Pernikahan
                </h2>
                <p class="text-violet-100 text-sm mt-1">Lengkapi informasi pernikahan di bawah ini</p>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Marriage Date -->
                    <div>
                        <label for="marriage_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar text-violet-500 mr-2"></i>Tanggal Pernikahan
                        </label>
                        <input type="date" 
                               id="marriage_date" 
                               name="marriage_date" 
                               value="{{ old('marriage_date') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 @error('marriage_date') border-red-500 @enderror"
                               required>
                        @error('marriage_date')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Marriage Place -->
                    <div>
                        <label for="marriage_place" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-violet-500 mr-2"></i>Tempat Pernikahan
                        </label>
                        <input type="text" 
                               id="marriage_place" 
                               name="marriage_place" 
                               value="{{ old('marriage_place') }}"
                               placeholder="Masukkan tempat pernikahan"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 @error('marriage_place') border-red-500 @enderror"
                               required>
                        @error('marriage_place')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Witness 1 -->
                    <div>
                        <label for="witness1_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-check text-violet-500 mr-2"></i>Nama Saksi 1
                        </label>
                        <input type="text" 
                               id="witness1_name" 
                               name="witness1_name" 
                               value="{{ old('witness1_name') }}"
                               placeholder="Masukkan nama saksi 1"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 @error('witness1_name') border-red-500 @enderror"
                               required>
                        @error('witness1_name')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Witness 2 -->
                    <div>
                        <label for="witness2_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-check text-violet-500 mr-2"></i>Nama Saksi 2
                        </label>
                        <input type="text" 
                               id="witness2_name" 
                               name="witness2_name" 
                               value="{{ old('witness2_name') }}"
                               placeholder="Masukkan nama saksi 2"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 @error('witness2_name') border-red-500 @enderror"
                               required>
                        @error('witness2_name')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center border-t border-gray-200 pt-6">
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-green-600 to-emerald-700 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-800 focus:outline-none focus:ring-4 focus:ring-green-500/50 transition-all duration-300 shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Pernikahan
                    </button>
                    <a href="{{ route('admin.marriage.create') }}" 
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-500/50 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Set minimum date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const marriageDateInput = document.getElementById('marriage_date');
        if (marriageDateInput) {
            marriageDateInput.min = today;
        }
    });
</script>
@endsection
