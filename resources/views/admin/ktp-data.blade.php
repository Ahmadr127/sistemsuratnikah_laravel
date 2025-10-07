@extends('layouts.admin')

@section('title', 'Data KTP - Admin')

@section('page_title', 'Data KTP')

@section('content')
<div class="p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center">
            <div class="bg-blue-500/10 p-3 rounded-xl">
                <i class="fas fa-id-card text-xl text-blue-500"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 ml-3">Data KTP</h2>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center justify-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali</span>
            </a>
            <button
                class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-300"
                data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="fas fa-search mr-2"></i>
                <span>Cari KTP</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-500 hover:text-green-600" data-bs-dismiss="alert">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
            <button type="button" class="ml-auto text-red-500 hover:text-red-600" data-bs-dismiss="alert">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total KTP Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">Total Data KTP</p>
                    <h3 class="text-2xl font-bold">{{ $total }}</h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl">
                    <i class="fas fa-id-card text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- KTP Selesai Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">KTP Selesai</p>
                    <h3 class="text-2xl font-bold">{{ collect($ktpData)->where('status', 'selesai')->count() }}</h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Dalam Proses Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">Dalam Proses</p>
                    <h3 class="text-2xl font-bold">{{ collect($ktpData)->where('status', '!=', 'selesai')->count() }}
                    </h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Belum Menikah Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1">Belum Menikah</p>
                    <h3 class="text-2xl font-bold">
                        {{ collect($ktpData)->where('status_perkawinan', 'Belum Kawin')->count() }}</h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- KTP Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h4 class="text-white font-semibold flex items-center text-lg">
                <i class="fas fa-list mr-2"></i>Daftar Data KTP
            </h4>
        </div>
        <div class="p-0">
            @if(is_array($ktpData) && count($ktpData) > 0)
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="px-6 py-3 text-left font-semibold">No</th>
                            <th class="px-6 py-3 text-left font-semibold">NIK</th>
                            <th class="px-6 py-3 text-left font-semibold">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left font-semibold">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left font-semibold">Status KTP</th>
                            <th class="px-6 py-3 text-left font-semibold">Status Perkawinan</th>
                            <th class="px-6 py-3 text-left font-semibold">Tanggal Pengajuan</th>
                            <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ktpData as $index => $ktp)
                        <tr class="hover:bg-gray-50 transition-colors border-t border-gray-100">
                            <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <code
                                    class="px-2 py-1 bg-gray-100 rounded text-gray-800 text-sm">{{ $ktp['nik'] ?? 'N/A' }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 font-semibold mr-3">
                                        {{ substr($ktp['nama_lengkap'] ?? 'N', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $ktp['nama_lengkap'] ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $ktp['pekerjaan'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                $gender = $ktp['jenis_kelamin'] ?? 'L';
                                $genderColor = $gender === 'L' ? 'blue' : 'pink';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-{{ $genderColor }}-100 text-{{ $genderColor }}-800">
                                    <i class="fas fa-{{ $gender === 'L' ? 'male' : 'female' }} mr-1"></i>
                                    {{ $gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                $status = $ktp['status'] ?? 'unknown';
                                $statusColors = [
                                'selesai' => 'green',
                                'proses_cetak' => 'yellow',
                                'verifikasi' => 'blue',
                                'pending' => 'gray',
                                'ditolak' => 'red',
                                'unknown' => 'gray'
                                ];
                                $statusColor = $statusColors[$status] ?? 'gray';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                $maritalStatus = $ktp['status_perkawinan'] ?? 'Unknown';
                                $maritalColor = $maritalStatus === 'Belum Kawin' ? 'green' : 'blue';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-{{ $maritalColor }}-100 text-{{ $maritalColor }}-800">
                                    {{ $maritalStatus }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if(isset($ktp['tanggal_pengajuan']))
                                {{ \Carbon\Carbon::parse($ktp['tanggal_pengajuan'])->format('d/m/Y H:i') }}
                                @else
                                N/A
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick="viewKtpDetail('{{ $ktp['nik'] ?? '' }}')"
                                        class="inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-colors"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if(($ktp['status'] ?? '') === 'selesai' && ($ktp['status_perkawinan'] ?? '') ===
                                    'Belum Kawin')
                                    <a href="{{ route('admin.marriage.create') }}?groom_nik={{ $ktp['nik'] ?? '' }}"
                                        class="inline-flex items-center justify-center p-2 rounded-lg text-green-600 hover:text-green-700 hover:bg-green-50 transition-colors"
                                        title="Buat Pernikahan">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                    @else
                                    <span
                                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 cursor-not-allowed"
                                        title="Tidak dapat membuat pernikahan">
                                        <i class="fas fa-ban"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-id-card fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data KTP</h5>
                <p class="text-muted">
                    @if(session('error'))
                    {{ session('error') }}
                    @else
                    Data KTP akan muncul setelah terintegrasi dengan API
                    @endif
                </p>
                <button class="btn btn-primary" onclick="location.reload()">
                    <i class="fas fa-refresh me-2"></i>Refresh Data
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-2xl border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-t-2xl">
                <h5 class="modal-title text-lg font-semibold" id="searchModalLabel">
                    <i class="fas fa-search mr-2"></i>Cari Data KTP
                </h5>
                <button type="button" class="text-white/80 hover:text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.ktp-search') }}" method="POST">
                @csrf
                <div class="modal-body p-6">
                    <div class="mb-4">
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                        <div class="relative rounded-xl">
                            <input type="text"
                                class="w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror"
                                id="nik" name="nik" placeholder="Masukkan 16 digit NIK" value="{{ old('nik') }}"
                                required>
                        </div>
                        @error('nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0 px-6 pb-6 flex gap-2">
                    <button type="button"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Hover effects */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Custom animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out forwards;
}

/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}
</style>
@endsection

@section('scripts')
<script>
function viewKtpDetail(nik) {
    if (!nik || nik === '') {
        console.error('NIK tidak valid');
        return;
    }

    // Create a form to search for specific NIK
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.ktp-search") }}';
    form.style.display = 'none';

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';

    const nikInput = document.createElement('input');
    nikInput.type = 'hidden';
    nikInput.name = 'nik';
    nikInput.value = nik;

    form.appendChild(csrfToken);
    form.appendChild(nikInput);
    document.body.appendChild(form);
    form.submit();
}

// NIK validation
document.addEventListener('DOMContentLoaded', function() {
    const nikInput = document.getElementById('nik');

    if (nikInput) {
        nikInput.addEventListener('input', function() {
            const nik = this.value.replace(/\D/g, ''); // Remove non-digits
            this.value = nik;

            if (nik.length > 0 && nik.length !== 16) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
});
</script>
@endsection