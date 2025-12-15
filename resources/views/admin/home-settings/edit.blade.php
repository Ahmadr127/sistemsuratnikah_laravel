@extends('layouts.admin')

@section('title', 'Pengaturan Home')

@section('page_title', 'Pengaturan Halaman Home')

@section('content')
<!-- Header Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
            <div class="bg-gradient-to-br from-violet-500 to-purple-600 w-12 h-12 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-cog text-white text-xl"></i>
            </div>
            <span>Pengaturan Halaman Home</span>
        </h1>
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali ke Dashboard</span>
        </a>
    </div>
</div>

@if(session('status'))
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-800 font-medium">{{ session('status') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-500 hover:text-green-700 transition-colors" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

<div class="max-w-4xl mx-auto">
    <!-- Main Form Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Card Header with Gradient -->
        <div class="bg-gradient-to-r from-violet-600 to-purple-700 px-6 py-5">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-edit mr-3 text-2xl"></i>
                Edit Konten Halaman Home
            </h2>
            <p class="text-violet-100 text-sm mt-1">Kelola judul, subjudul, fitur, dan statistik yang ditampilkan</p>
        </div>

        <!-- Card Body -->
        <div class="p-8">
            <form method="POST" action="{{ route('admin.home-settings.update') }}">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-violet-500 mr-2"></i>Judul Utama
                    </label>
                    <input type="text" 
                           id="title"
                           name="title" 
                           value="{{ old('title', $setting->title) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 @error('title') border-red-500 @enderror"
                           placeholder="Masukkan judul halaman home">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div class="mb-6">
                    <label for="subtitle" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-text-height text-violet-500 mr-2"></i>Subjudul
                    </label>
                    <input type="text" 
                           id="subtitle"
                           name="subtitle" 
                           value="{{ old('subtitle', $setting->subtitle) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 @error('subtitle') border-red-500 @enderror"
                           placeholder="Masukkan subjudul halaman home">
                    @error('subtitle')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Features JSON -->
                <div class="mb-6">
                    <label for="features" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-star text-violet-500 mr-2"></i>Fitur (Format JSON)
                    </label>
                    <div class="relative">
                        <textarea 
                            id="features"
                            name="features" 
                            rows="10"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 font-mono text-sm @error('features') border-red-500 @enderror"
                            placeholder='[{"icon":"fas fa-heart","title":"Fitur 1","description":"Deskripsi"}]'>{{ old('features', json_encode($setting->features, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea>
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-violet-100 text-violet-800">
                                <i class="fas fa-code mr-1"></i>JSON
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800 flex items-start">
                            <i class="fas fa-info-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span><strong>Format:</strong> Array of objects dengan struktur: <code class="bg-white px-1 py-0.5 rounded">{"icon":"fas fa-...","title":"...","description":"..."}</code></span>
                        </p>
                    </div>
                    @error('features')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Stats JSON -->
                <div class="mb-8">
                    <label for="stats" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-chart-line text-violet-500 mr-2"></i>Statistik (Format JSON)
                    </label>
                    <div class="relative">
                        <textarea 
                            id="stats"
                            name="stats" 
                            rows="8"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 font-mono text-sm @error('stats') border-red-500 @enderror"
                            placeholder='{"total_marriages":1234,"happy_couples":5678}'>{{ old('stats', json_encode($setting->stats, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea>
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-violet-100 text-violet-800">
                                <i class="fas fa-code mr-1"></i>JSON
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800 flex items-start">
                            <i class="fas fa-info-circle mt-0.5 mr-2 flex-shrink-0"></i>
                            <span><strong>Format:</strong> Object dengan key: <code class="bg-white px-1 py-0.5 rounded">total_marriages</code>, <code class="bg-white px-1 py-0.5 rounded">happy_couples</code>, <code class="bg-white px-1 py-0.5 rounded">years_experience</code>, <code class="bg-white px-1 py-0.5 rounded">satisfaction_rate</code></span>
                        </p>
                    </div>
                    @error('stats')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end border-t border-gray-200 pt-6">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-500/50 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-violet-600 to-purple-700 text-white font-medium rounded-xl hover:from-violet-700 hover:to-purple-800 focus:outline-none focus:ring-4 focus:ring-violet-500/50 transition-all duration-300 shadow-lg shadow-violet-500/30 hover:shadow-xl hover:shadow-violet-500/40 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Information Card -->
    <div class="mt-6 bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg shadow-sm border border-amber-100">
        <div class="px-6 py-4 border-b border-amber-200 bg-white/50">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-lightbulb text-white text-sm"></i>
                </div>
                Tips Penggunaan
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-0.5"></i>
                    <p class="text-sm text-gray-700">Pastikan format JSON valid sebelum menyimpan</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-0.5"></i>
                    <p class="text-sm text-gray-700">Gunakan icon dari <a href="https://fontawesome.com/icons" target="_blank" class="text-violet-600 hover:text-violet-700 underline">Font Awesome</a> untuk fitur</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-0.5"></i>
                    <p class="text-sm text-gray-700">Perubahan akan langsung terlihat di halaman home setelah disimpan</p>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-0.5"></i>
                    <p class="text-sm text-gray-700">Klik tombol "Simpan Perubahan" untuk menyimpan semua perubahan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // JSON Validation and Formatting
    document.addEventListener('DOMContentLoaded', function() {
        const featuresTextarea = document.getElementById('features');
        const statsTextarea = document.getElementById('stats');
        
        function validateJSON(textarea) {
            try {
                const value = textarea.value.trim();
                if (value) {
                    JSON.parse(value);
                    textarea.classList.remove('border-red-500');
                    textarea.classList.add('border-green-500');
                    return true;
                }
            } catch (e) {
                textarea.classList.remove('border-green-500');
                textarea.classList.add('border-red-500');
                return false;
            }
        }
        
        if (featuresTextarea) {
            featuresTextarea.addEventListener('blur', function() {
                validateJSON(this);
            });
        }
        
        if (statsTextarea) {
            statsTextarea.addEventListener('blur', function() {
                validateJSON(this);
            });
        }
    });
</script>
@endsection
