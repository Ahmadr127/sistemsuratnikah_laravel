@extends('layouts.admin')

@section('title', 'Detail Data KTP - Admin')

@section('page_title', 'Detail Data KTP')

@section('content')
<!-- Header Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
            <div class="bg-gradient-to-br from-blue-500 to-cyan-600 w-12 h-12 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-id-card text-white text-xl"></i>
            </div>
            <span>Detail Data KTP</span>
        </h1>
        <div class="flex gap-3">
            @if(($ktpData['status'] ?? '') === 'selesai' && ($ktpData['status_perkawinan'] ?? '') === 'Belum Kawin')
                <a href="{{ route('admin.marriage.create') }}?groom_nik={{ $ktpData['nik'] }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-pink-600 to-rose-700 text-white rounded-xl hover:from-pink-700 hover:to-rose-800 transition-all duration-300 shadow-lg shadow-pink-500/30">
                    <i class="fas fa-heart mr-2"></i>
                    <span class="font-medium">Buat Pernikahan</span>
                </a>
            @endif
            <a href="{{ route('admin.ktp-data') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali ke Data KTP</span>
            </a>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto">
    <!-- Personal Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-user text-white"></i>
                </div>
                Informasi Pribadi
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                    <p class="text-gray-900 font-mono text-lg font-medium bg-gray-50 px-3 py-2 rounded-lg">{{ $ktpData['nik'] ?? '-' }}</p>
                </div>
                @if(!empty($ktpData['no_pengajuan']))
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">No. Pengajuan</label>
                    <p class="text-gray-900">{{ $ktpData['no_pengajuan'] }}</p>
                </div>
                @endif
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 text-lg font-semibold">{{ $ktpData['nama_lengkap'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat, Tanggal Lahir</label>
                    <p class="text-gray-900">
                        {{ $ktpData['tempat_lahir'] ?? '-' }}, {{ isset($ktpData['tanggal_lahir']) ? \Carbon\Carbon::parse($ktpData['tanggal_lahir'])->format('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                    <p>
                        @if(($ktpData['jenis_kelamin'] ?? '') === 'L')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-male mr-2"></i>Laki-laki
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                                <i class="fas fa-female mr-2"></i>Perempuan
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Golongan Darah</label>
                    <p class="text-gray-900">{{ $ktpData['golongan_darah'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Agama</label>
                    <p class="text-gray-900">{{ $ktpData['agama'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status Perkawinan</label>
                    <p>
                        @php
                            $statusPerkawinan = $ktpData['status_perkawinan'] ?? '-';
                            $statusClass = match($statusPerkawinan) {
                                'Belum Kawin' => 'bg-green-100 text-green-800',
                                'Kawin' => 'bg-blue-100 text-blue-800',
                                'Cerai Hidup' => 'bg-orange-100 text-orange-800',
                                'Cerai Mati' => 'bg-gray-100 text-gray-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ $statusPerkawinan }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                    <p class="text-gray-900">{{ $ktpData['pekerjaan'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kewarganegaraan</label>
                    <p class="text-gray-900">{{ $ktpData['kewarganegaraan'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">No. Telepon</label>
                    <p class="text-gray-900">{{ $ktpData['no_telepon'] ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-emerald-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-map-marker-alt text-white"></i>
                </div>
                Informasi Alamat
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Lengkap</label>
                    <p class="text-gray-900">
                        {{ $ktpData['alamat'] ?? '-' }}, RT {{ $ktpData['rt'] ?? '-' }}/RW {{ $ktpData['rw'] ?? '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kelurahan/Desa</label>
                    <p class="text-gray-900">{{ $ktpData['kelurahan'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kecamatan</label>
                    <p class="text-gray-900">{{ $ktpData['kecamatan'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kabupaten/Kota</label>
                    <p class="text-gray-900">{{ $ktpData['kabupaten'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Provinsi</label>
                    <p class="text-gray-900">{{ $ktpData['provinsi'] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Kode Pos</label>
                    <p class="text-gray-900">{{ $ktpData['kode_pos'] ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
            <h3 class="font-semibold text-white flex items-center">
                <i class="fas fa-info-circle mr-3 text-xl"></i>
                Status dan Informasi Lainnya
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status KTP</label>
                    <p>
                        @php
                            $status = $ktpData['status'] ?? 'unknown';
                            $statusConfig = match($status) {
                                'selesai' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'check-circle', 'label' => 'Selesai'],
                                'proses_cetak' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'print', 'label' => 'Proses Cetak'],
                                'verifikasi' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'search', 'label' => 'Verifikasi'],
                                'pending' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'clock', 'label' => 'Pending'],
                                'ditolak' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'times-circle', 'label' => 'Ditolak'],
                                default => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'question-circle', 'label' => ucfirst($status)]
                            };
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusConfig['class'] }}">
                            <i class="fas fa-{{ $statusConfig['icon'] }} mr-2"></i>
                            {{ $statusConfig['label'] }}
                        </span>
                    </p>
                </div>
                @if(!empty($ktpData['tanggal_pengajuan']))
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pengajuan</label>
                    <p class="text-gray-900 flex items-center">
                        <i class="fas fa-calendar text-amber-500 mr-2"></i>
                        {{ \Carbon\Carbon::parse($ktpData['tanggal_pengajuan'])->format('d F Y, H:i') }} WIB
                    </p>
                </div>
                @endif
                @if(!empty($ktpData['tanggal_selesai']))
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Selesai</label>
                    <p class="text-gray-900 flex items-center">
                        <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                        {{ \Carbon\Carbon::parse($ktpData['tanggal_selesai'])->format('d F Y, H:i') }} WIB
                    </p>
                </div>
                @endif
                @if(!empty($ktpData['catatan']))
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Catatan</label>
                    <p class="text-gray-900 bg-gray-50 px-4 py-3 rounded-lg">{{ $ktpData['catatan'] }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- User Information Card (only show if user data exists) -->
    @if(!empty($ktpData['user_name']) || !empty($ktpData['user_email']))
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-100 to-slate-100 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-gray-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-user-circle text-white"></i>
                </div>
                Informasi User
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(!empty($ktpData['user_name']))
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama User</label>
                    <p class="text-gray-900">{{ $ktpData['user_name'] }}</p>
                </div>
                @endif
                @if(!empty($ktpData['user_email']))
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email User</label>
                    <p class="text-gray-900">{{ $ktpData['user_email'] }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
