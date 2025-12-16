@extends('layouts.admin')

@section('title', 'Tambah KUA - Admin')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 mb-6">
    <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
        <i class="fas fa-plus-circle mr-3"></i>
        Tambah KUA Baru
    </h1>
    <p class="text-blue-100 text-lg">Tambahkan Kantor Urusan Agama baru</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.kuas.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama KUA -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama KUA <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" id="address" rows="3" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('phone') border-red-500 @enderror">
                    @error('phone')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Operasional -->
                <div class="md:col-span-2">
                    <label for="operating_hours" class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Operasional
                    </label>
                    <input type="text" name="operating_hours" id="operating_hours" value="{{ old('operating_hours') }}"
                        placeholder="Contoh: Senin - Jumat: 08:00 - 16:00 WIB"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('operating_hours') border-red-500 @enderror">
                    @error('operating_hours')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link Google Maps -->
                <div class="md:col-span-2">
                    <label for="google_maps_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Link Google Maps (untuk petunjuk arah)
                    </label>
                    <input type="url" name="google_maps_link" id="google_maps_link" value="{{ old('google_maps_link') }}"
                        placeholder="https://www.google.com/maps/dir//..."
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('google_maps_link') border-red-500 @enderror">
                    @error('google_maps_link')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Embed Google Maps -->
                <div class="md:col-span-2">
                    <label for="google_maps_embed" class="block text-sm font-medium text-gray-700 mb-2">
                        Google Maps Embed URL (untuk iframe)
                    </label>
                    <input type="url" name="google_maps_embed" id="google_maps_embed" value="{{ old('google_maps_embed') }}"
                        placeholder="https://www.google.com/maps/embed?pb=..."
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('google_maps_embed') border-red-500 @enderror">
                    @error('google_maps_embed')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i> Dapatkan dari Google Maps &gt; Share &gt; Embed a map
                    </p>
                </div>

                <!-- Urutan -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampilan
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('order') border-red-500 @enderror">
                    @error('order')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center">
                    <label for="is_active" class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan KUA ini</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kuas.index') }}"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-2"></i> Simpan KUA
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
