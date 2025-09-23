@extends('layouts.app')

@section('title', 'Form Pernikahan - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-heart me-2"></i>Form Pernikahan</h2>
                <a href="{{ route('admin.marriage.create') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Pencarian NIK
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
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-check me-2"></i>Data Calon Pengantin
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Groom Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-male me-2"></i>Calon Pengantin Pria
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">NIK</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['nik'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['name'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($marriageData['groom']['birth_date'])->format('d F Y') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['birth_place'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['gender'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Agama</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['religion'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pekerjaan</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['occupation'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Perkawinan</label>
                                <input type="text" class="form-control" value="{{ $marriageData['groom']['marital_status'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3" readonly>{{ $marriageData['groom']['address'] }}, {{ $marriageData['groom']['village'] }}, {{ $marriageData['groom']['district'] }}, {{ $marriageData['groom']['city'] }}, {{ $marriageData['groom']['province'] }} {{ $marriageData['groom']['postal_code'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bride Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-female me-2"></i>Calon Pengantin Wanita
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">NIK</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['nik'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['name'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($marriageData['bride']['birth_date'])->format('d F Y') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['birth_place'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['gender'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Agama</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['religion'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pekerjaan</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['occupation'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Perkawinan</label>
                                <input type="text" class="form-control" value="{{ $marriageData['bride']['marital_status'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3" readonly>{{ $marriageData['bride']['address'] }}, {{ $marriageData['bride']['village'] }}, {{ $marriageData['bride']['district'] }}, {{ $marriageData['bride']['city'] }}, {{ $marriageData['bride']['province'] }} {{ $marriageData['bride']['postal_code'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Marriage Information Form -->
                    <form id="marriageForm" action="{{ route('admin.marriage.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Informasi Pernikahan
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="marriage_date" class="form-label fw-bold">Tanggal Pernikahan</label>
                                    <input type="date" class="form-control @error('marriage_date') is-invalid @enderror" 
                                           id="marriage_date" name="marriage_date" 
                                           value="{{ old('marriage_date') }}" required>
                                    @error('marriage_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="marriage_place" class="form-label fw-bold">Tempat Pernikahan</label>
                                    <input type="text" class="form-control @error('marriage_place') is-invalid @enderror" 
                                           id="marriage_place" name="marriage_place" 
                                           placeholder="Masukkan tempat pernikahan"
                                           value="{{ old('marriage_place') }}" required>
                                    @error('marriage_place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="witness1_name" class="form-label fw-bold">Nama Saksi 1</label>
                                    <input type="text" class="form-control @error('witness1_name') is-invalid @enderror" 
                                           id="witness1_name" name="witness1_name" 
                                           placeholder="Masukkan nama saksi 1"
                                           value="{{ old('witness1_name') }}" required>
                                    @error('witness1_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="witness2_name" class="form-label fw-bold">Nama Saksi 2</label>
                                    <input type="text" class="form-control @error('witness2_name') is-invalid @enderror" 
                                           id="witness2_name" name="witness2_name" 
                                           placeholder="Masukkan nama saksi 2"
                                           value="{{ old('witness2_name') }}" required>
                                    @error('witness2_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg me-3">
                                <i class="fas fa-save me-2"></i>Simpan Data Pernikahan
                            </button>
                            <a href="{{ route('admin.marriage.create') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
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
    
    .form-control:read-only {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }
    
    .text-primary {
        color: var(--primary-color) !important;
    }
</style>
@endsection

@section('scripts')
<script>
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
