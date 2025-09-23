@extends('layouts.app')

@section('title', 'Data KTP - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-id-card me-2"></i>Data KTP</h2>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search me-2"></i>Cari KTP
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $total }}</h4>
                            <p class="mb-0">Total Data KTP</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-id-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ collect($ktpData)->where('status', 'selesai')->count() }}</h4>
                            <p class="mb-0">KTP Selesai</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ collect($ktpData)->where('status', '!=', 'selesai')->count() }}</h4>
                            <p class="mb-0">Dalam Proses</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ collect($ktpData)->where('status_perkawinan', 'Belum Kawin')->count() }}</h4>
                            <p class="mb-0">Belum Menikah</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KTP Data Table -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-list me-2"></i>Daftar Data KTP
            </h4>
        </div>
        <div class="card-body p-0">
            @if(is_array($ktpData) && count($ktpData) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Status KTP</th>
                                <th>Status Perkawinan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ktpData as $index => $ktp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <code>{{ $ktp['nik'] ?? 'N/A' }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                {{ substr($ktp['nama_lengkap'] ?? 'N', 0, 1) }}
                                            </div>
                                            <div>
                                                <strong>{{ $ktp['nama_lengkap'] ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $ktp['pekerjaan'] ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $gender = $ktp['jenis_kelamin'] ?? 'L';
                                        @endphp
                                        <span class="badge bg-{{ $gender === 'L' ? 'primary' : 'pink' }}">
                                            <i class="fas fa-{{ $gender === 'L' ? 'male' : 'female' }} me-1"></i>
                                            {{ $gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $status = $ktp['status'] ?? 'unknown';
                                            $statusClass = match($status) {
                                                'selesai' => 'success',
                                                'proses_cetak' => 'warning',
                                                'verifikasi' => 'info',
                                                'pending' => 'secondary',
                                                'ditolak' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $maritalStatus = $ktp['status_perkawinan'] ?? 'Unknown';
                                        @endphp
                                        <span class="badge bg-{{ $maritalStatus === 'Belum Kawin' ? 'success' : 'info' }}">
                                            {{ $maritalStatus }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(isset($ktp['tanggal_pengajuan']))
                                            {{ \Carbon\Carbon::parse($ktp['tanggal_pengajuan'])->format('d/m/Y H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="viewKtpDetail('{{ $ktp['nik'] ?? '' }}')"
                                                    title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if(($ktp['status'] ?? '') === 'selesai' && ($ktp['status_perkawinan'] ?? '') === 'Belum Kawin')
                                                <a href="{{ route('admin.marriage.create') }}?groom_nik={{ $ktp['nik'] ?? '' }}" 
                                                   class="btn btn-sm btn-outline-success"
                                                   title="Buat Pernikahan">
                                                    <i class="fas fa-heart"></i>
                                                </a>
                                            @else
                                                <span class="btn btn-sm btn-outline-secondary disabled" title="Tidak dapat membuat pernikahan">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">
                    <i class="fas fa-search me-2"></i>Cari Data KTP
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.ktp-search') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" 
                               class="form-control @error('nik') is-invalid @enderror" 
                               id="nik" 
                               name="nik" 
                               placeholder="Masukkan 16 digit NIK"
                               value="{{ old('nik') }}"
                               required>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
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
    
    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .bg-pink {
        background-color: #e91e63 !important;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
    
    .badge {
        font-size: 0.75em;
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
