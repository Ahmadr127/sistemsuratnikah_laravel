@extends('layouts.app')

@section('title', 'Pengajuan Buku Nikah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Formulir Pengajuan Buku Nikah</h1>

            @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 border-l-4 border-green-500">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

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
            <!-- Step 1: Verifikasi NIK melalui API KTP -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Verifikasi NIK</h2>
                <form action="{{ route('marriage.search-nik') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label for="groom_nik" class="block text-sm font-medium text-gray-700">NIK Calon Pengantin Pria</label>
                        <input type="text" name="groom_nik" id="groom_nik" pattern="[0-9]{16}" title="NIK harus 16 digit angka"
                               class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                               value="{{ old('groom_nik', $prefill['groom']['nik'] ?? '') }}">
                        @error('groom_nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="bride_nik" class="block text-sm font-medium text-gray-700">NIK Calon Pengantin Wanita</label>
                        <input type="text" name="bride_nik" id="bride_nik" pattern="[0-9]{16}" title="NIK harus 16 digit angka"
                               class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                               value="{{ old('bride_nik', $prefill['bride']['nik'] ?? '') }}">
                        @error('bride_nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">Verifikasi NIK</button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Lengkapi dan submit pengajuan -->
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
                                value="{{ old('groom_name', $prefill['groom']['name'] ?? '') }}">
                        </div>
                        <div>
                            <label for="groom_nik_submit" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" name="groom_nik" id="groom_nik_submit" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('groom_nik', $prefill['groom']['nik'] ?? '') }}" pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                        </div>
                        <div>
                            <label for="groom_birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                            <input type="text" name="groom_birth_place" id="groom_birth_place" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('groom_birth_place', $prefill['groom']['birth_place'] ?? '') }}">
                        </div>
                        <div>
                            <label for="groom_birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="groom_birth_date" id="groom_birth_date" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('groom_birth_date', isset($prefill['groom']['birth_date']) ? \Illuminate\Support\Carbon::parse($prefill['groom']['birth_date'])->format('Y-m-d') : '') }}">
                        </div>
                        <div class="md:col-span-2">
                            <label for="groom_address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="groom_address" id="groom_address" required rows="3"
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50">{{ old('groom_address', $prefill['groom']['address'] ?? '') }}</textarea>
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
                                value="{{ old('bride_name', $prefill['bride']['name'] ?? '') }}">
                        </div>
                        <div>
                            <label for="bride_nik_submit" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" name="bride_nik" id="bride_nik_submit" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('bride_nik', $prefill['bride']['nik'] ?? '') }}" pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                        </div>
                        <div>
                            <label for="bride_birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                            <input type="text" name="bride_birth_place" id="bride_birth_place" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('bride_birth_place', $prefill['bride']['birth_place'] ?? '') }}">
                        </div>
                        <div>
                            <label for="bride_birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="bride_birth_date" id="bride_birth_date" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('bride_birth_date', isset($prefill['bride']['birth_date']) ? \Illuminate\Support\Carbon::parse($prefill['bride']['birth_date'])->format('Y-m-d') : '') }}">
                        </div>
                        <div class="md:col-span-2">
                            <label for="bride_address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="bride_address" id="bride_address" required rows="3"
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50">{{ old('bride_address', $prefill['bride']['address'] ?? '') }}</textarea>
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
                            <label for="marriage_place" class="block text-sm font-medium text-gray-700">Tempat
                                Pernikahan</label>
                            <input type="text" name="marriage_place" id="marriage_place" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('marriage_place') }}">
                        </div>
                        <div>
                            <label for="witness1_name" class="block text-sm font-medium text-gray-700">Nama Saksi 1</label>
                            <input type="text" name="witness1_name" id="witness1_name" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('witness1_name') }}">
                        </div>
                        <div>
                            <label for="witness2_name" class="block text-sm font-medium text-gray-700">Nama Saksi 2</label>
                            <input type="text" name="witness2_name" id="witness2_name" required
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-secondary focus:ring focus:ring-secondary focus:ring-opacity-50"
                                value="{{ old('witness2_name') }}">
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

@push('scripts')
<script>
    const nikRegex = /^[0-9]{16}$/;
    const nikInput = document.getElementById('groom_nik');
    const nikSubmitInput = document.getElementById('groom_nik_submit');
    const brideNikInput = document.getElementById('bride_nik');
    const brideNikSubmitInput = document.getElementById('bride_nik_submit');

    nikInput.addEventListener('input', (e) => {
        const nik = e.target.value;
        if (nikRegex.test(nik)) {
            nikSubmitInput.disabled = false;
        } else {
            nikSubmitInput.disabled = true;
        }
    });

    brideNikInput.addEventListener('input', (e) => {
        const nik = e.target.value;
        if (nikRegex.test(nik)) {
            brideNikSubmitInput.disabled = false;
        } else {
            brideNikSubmitInput.disabled = true;
        }
    });
</script>
@endpush