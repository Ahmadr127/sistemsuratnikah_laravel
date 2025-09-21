@extends('layouts.app')

@section('title', 'Buat Buku Nikah - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-heart me-2"></i>Buat Buku Nikah</h2>
                <a href="{{ route('admin.marriages') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pernikahan
                </a>
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

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-search me-2"></i>Verifikasi NIK Calon Pengantin
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form id="nikSearchForm" action="{{ route('admin.marriage.search-nik') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="groom_nik" class="form-label fw-bold">
                                    <i class="fas fa-male me-1"></i>NIK Calon Pengantin Pria
                                </label>
                                <input type="text" 
                                       class="form-control @error('groom_nik') is-invalid @enderror" 
                                       id="groom_nik" 
                                       name="groom_nik" 
                                       placeholder="Masukkan NIK calon pengantin pria"
                                       value="{{ old('groom_nik') }}"
                                       required>
                                @error('groom_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bride_nik" class="form-label fw-bold">
                                    <i class="fas fa-female me-1"></i>NIK Calon Pengantin Wanita
                                </label>
                                <input type="text" 
                                       class="form-control @error('bride_nik') is-invalid @enderror" 
                                       id="bride_nik" 
                                       name="bride_nik" 
                                       placeholder="Masukkan NIK calon pengantin wanita"
                                       value="{{ old('bride_nik') }}"
                                       required>
                                @error('bride_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-search me-2"></i>Cari Data
                            </button>
                            <a href="{{ route('admin.marriages') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Langkah-langkah:</h6>
                            <ol class="mb-0">
                                <li>Masukkan NIK calon pengantin pria dan wanita</li>
                                <li>Klik "Cari Data" untuk verifikasi NIK</li>
                                <li>Lengkapi informasi pernikahan</li>
                                <li>Simpan data pernikahan</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Catatan:</h6>
                            <ul class="mb-0">
                                <li>NIK harus berupa 16 digit angka</li>
                                <li>Data akan diverifikasi melalui API resmi</li>
                                <li>Pastikan NIK valid dan terdaftar</li>
                            </ul>
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
    
    .text-primary {
        color: var(--primary-color) !important;
    }
</style>
@endsection

@section('scripts')
<script>
    // NIK validation
    function validateNIK(nik) {
        // Basic NIK validation (16 digits)
        return /^\d{16}$/.test(nik);
    }

    // Add real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        const groomNikInput = document.getElementById('groom_nik');
        const brideNikInput = document.getElementById('bride_nik');
        
        if (groomNikInput) {
            groomNikInput.addEventListener('input', function() {
                const nik = this.value.replace(/\D/g, ''); // Remove non-digits
                this.value = nik;
                
                if (nik.length > 0 && !validateNIK(nik)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        }
        
        if (brideNikInput) {
            brideNikInput.addEventListener('input', function() {
                const nik = this.value.replace(/\D/g, ''); // Remove non-digits
                this.value = nik;
                
                if (nik.length > 0 && !validateNIK(nik)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });
</script>
@endsection
