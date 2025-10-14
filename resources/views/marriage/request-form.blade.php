@extends('layouts.app')

@section('title', 'Pengajuan Buku Nikah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Formulir Pengajuan Buku Nikah</h1>

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

            <form action="{{ route('marriage.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Groom Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Data Calon Pengantin Pria</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="groom_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="groom_name" id="groom_name" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('groom_name') }}">
                        </div>
                        <div>
                            <label for="groom_nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" name="groom_nik" id="groom_nik" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('groom_nik') }}" pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                        </div>
                    </div>
                </div>

                <!-- Bride Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Data Calon Pengantin Wanita</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="bride_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="bride_name" id="bride_name" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('bride_name') }}">
                        </div>
                        <div>
                            <label for="bride_nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" name="bride_nik" id="bride_nik" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('bride_nik') }}" pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                        </div>
                    </div>
                </div>

                <!-- Marriage Details -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pernikahan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="marriage_date" class="block text-sm font-medium text-gray-700">Tanggal
                                Pernikahan</label>
                            <input type="date" name="marriage_date" id="marriage_date" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('marriage_date') }}">
                        </div>
                        <div>
                            <label for="marriage_location" class="block text-sm font-medium text-gray-700">Lokasi
                                Pernikahan</label>
                            <input type="text" name="marriage_location" id="marriage_location" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('marriage_location') }}">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="window.history.back()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        Submit Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection