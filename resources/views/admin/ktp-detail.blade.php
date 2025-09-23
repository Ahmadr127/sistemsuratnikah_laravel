@extends('layouts.app')

@section('title', 'Detail KTP - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-id-card me-2"></i>Detail Data KTP</h2>
                <div>
                    <a href="{{ route('admin.ktp-data') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Data KTP
                    </a>
                    @if($ktpData['status'] === 'selesai' && $ktpData['status_perkawinan'] === 'Belum Kawin')
                        <a href="{{ route('admin.marriage.create') }}?groom_nik={{ $ktpData['nik'] }}" 
                           class="btn btn-success">
                            <i class="fas fa-heart me-2"></i>Buat Pernikahan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Personal Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Pribadi
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">NIK</label>
                                <p class="form-control-plaintext">
                                    <code class="fs-5">{{ $ktpData['nik'] }}</code>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">No. Pengajuan</label>
                                <p class="form-control-plaintext">{{ $ktpData['no_pengajuan'] }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Nama Lengkap</label>
                                <p class="form-control-plaintext fs-5">
                                    <strong>{{ $ktpData['nama_lengkap'] }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Tempat, Tanggal Lahir</label>
                                <p class="form-control-plaintext">
                                    {{ $ktpData['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($ktpData['tanggal_lahir'])->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Jenis Kelamin</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $ktpData['jenis_kelamin'] === 'L' ? 'primary' : 'pink' }}">
                                        <i class="fas fa-{{ $ktpData['jenis_kelamin'] === 'L' ? 'male' : 'female' }} me-1"></i>
                                        {{ $ktpData['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Golongan Darah</label>
                                <p class="form-control-plaintext">{{ $ktpData['golongan_darah'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Agama</label>
                                <p class="form-control-plaintext">{{ $ktpData['agama'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Status Perkawinan</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $ktpData['status_perkawinan'] === 'Belum Kawin' ? 'success' : 'info' }}">
                                        {{ $ktpData['status_perkawinan'] }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Pekerjaan</label>
                                <p class="form-control-plaintext">{{ $ktpData['pekerjaan'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Kewarganegaraan</label>
                                <p class="form-control-plaintext">{{ $ktpData['kewarganegaraan'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">No. Telepon</label>
                                <p class="form-control-plaintext">{{ $ktpData['no_telepon'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Informasi Alamat
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Alamat Lengkap</label>
                                <p class="form-control-plaintext">
                                    {{ $ktpData['alamat'] }}, RT {{ $ktpData['rt'] }}/RW {{ $ktpData['rw'] }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Kelurahan/Desa</label>
                                <p class="form-control-plaintext">{{ $ktpData['kelurahan'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Kecamatan</label>
                                <p class="form-control-plaintext">{{ $ktpData['kecamatan'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Kabupaten/Kota</label>
                                <p class="form-control-plaintext">{{ $ktpData['kabupaten'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Provinsi</label>
                                <p class="form-control-plaintext">{{ $ktpData['provinsi'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Kode Pos</label>
                                <p class="form-control-plaintext">{{ $ktpData['kode_pos'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Status dan Informasi Lainnya
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Status KTP</label>
                                <p class="form-control-plaintext">
                                    @php
                                        $statusClass = match($ktpData['status']) {
                                            'selesai' => 'success',
                                            'proses_cetak' => 'warning',
                                            'verifikasi' => 'info',
                                            'pending' => 'secondary',
                                            'ditolak' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $ktpData['status'])) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Tanggal Pengajuan</label>
                                <p class="form-control-plaintext">
                                    {{ \Carbon\Carbon::parse($ktpData['tanggal_pengajuan'])->format('d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @if($ktpData['tanggal_selesai'])
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Tanggal Selesai</label>
                                    <p class="form-control-plaintext">
                                        {{ \Carbon\Carbon::parse($ktpData['tanggal_selesai'])->format('d F Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if($ktpData['catatan'])
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Catatan</label>
                                    <p class="form-control-plaintext">{{ $ktpData['catatan'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Information Card -->
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Informasi User
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Nama User</label>
                                <p class="form-control-plaintext">{{ $ktpData['user_name'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Email User</label>
                                <p class="form-control-plaintext">{{ $ktpData['user_email'] }}</p>
                            </div>
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
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background: var(--primary-color) !important;
    }
    
    .bg-pink {
        background-color: #e91e63 !important;
    }
    
    .form-control-plaintext {
        font-size: 1rem;
        line-height: 1.5;
    }
    
    .badge {
        font-size: 0.875em;
    }
    
    .badge.fs-6 {
        font-size: 1rem !important;
    }
</style>
@endsection
