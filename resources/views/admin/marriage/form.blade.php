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

                    <!-- Marriage Place (KUA Dropdown) -->
                    <div class="relative" x-data="kuaDropdown()">
                        <label for="marriage_place_search" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-violet-500 mr-2"></i>Tempat Pernikahan (KUA)
                        </label>
                        
                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="marriage_place" id="marriage_place" x-model="selectedValue" required>
                        
                        <!-- Custom Searchable Dropdown -->
                        <div class="relative">
                            <!-- Search Input / Display -->
                            <div class="relative">
                                <input type="text"
                                       id="marriage_place_search"
                                       x-model="searchQuery"
                                       @focus="isOpen = true"
                                       @click="isOpen = true"
                                       @input="filterOptions()"
                                       :placeholder="selectedText || '-- Pilih Tempat Pernikahan (KUA) --'"
                                       :class="{'text-gray-900': selectedValue, 'text-gray-500': !selectedValue}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 transition-all duration-300 pr-10 @error('marriage_place') border-red-500 @enderror"
                                       autocomplete="off">
                                
                                <!-- Dropdown Arrow / Clear Button -->
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-1">
                                    <button type="button" 
                                            x-show="selectedValue"
                                            @click.stop="clearSelection()"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                    <button type="button" 
                                            @click="isOpen = !isOpen"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fas fa-chevron-down text-sm transition-transform duration-200" :class="{'rotate-180': isOpen}"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Dropdown Options -->
                            <div x-show="isOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.outside="isOpen = false"
                                 class="absolute z-50 w-full mt-2 bg-white border-2 border-gray-200 rounded-xl shadow-xl max-h-64 overflow-y-auto">
                                
                                <!-- No Results -->
                                <div x-show="filteredOptions.length === 0" 
                                     class="px-4 py-3 text-gray-500 text-sm text-center">
                                    <i class="fas fa-search mr-2"></i>Tidak ada KUA ditemukan
                                </div>
                                
                                <!-- Options List -->
                                <template x-for="(kua, index) in filteredOptions" :key="kua.id">
                                    <div @click="selectOption(kua)"
                                         class="px-4 py-3 cursor-pointer hover:bg-violet-50 transition-colors duration-150 border-b border-gray-100 last:border-b-0"
                                         :class="{'bg-violet-100': selectedValue === kua.name}">
                                        <div class="font-medium text-gray-800 text-sm" x-text="kua.name"></div>
                                        <div class="text-xs text-gray-500 mt-1 truncate" x-text="kua.address"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        
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
    // KUA Dropdown Component
    function kuaDropdown() {
        return {
            isOpen: false,
            searchQuery: '',
            selectedValue: '{{ old('marriage_place', '') }}',
            selectedText: '',
            options: @json($kuas->map(fn($kua) => ['id' => $kua->id, 'name' => $kua->name, 'address' => $kua->address])),
            filteredOptions: [],
            
            init() {
                this.filteredOptions = this.options;
                // Set initial selected text if value exists
                if (this.selectedValue) {
                    const found = this.options.find(o => o.name === this.selectedValue);
                    if (found) {
                        this.selectedText = found.name;
                        this.searchQuery = found.name;
                    }
                }
            },
            
            filterOptions() {
                const query = this.searchQuery.toLowerCase().trim();
                if (!query) {
                    this.filteredOptions = this.options;
                } else {
                    this.filteredOptions = this.options.filter(option => 
                        option.name.toLowerCase().includes(query) || 
                        option.address.toLowerCase().includes(query)
                    );
                }
                this.isOpen = true;
            },
            
            selectOption(kua) {
                this.selectedValue = kua.name;
                this.selectedText = kua.name;
                this.searchQuery = kua.name;
                this.isOpen = false;
            },
            
            clearSelection() {
                this.selectedValue = '';
                this.selectedText = '';
                this.searchQuery = '';
                this.filteredOptions = this.options;
                this.isOpen = false;
            }
        }
    }

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
