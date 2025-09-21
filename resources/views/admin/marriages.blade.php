@extends('layouts.app')

@section('title', 'Daftar Pernikahan - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-heart me-2"></i>Daftar Pernikahan</h2>
                <a href="{{ route('admin.marriage.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Buat Buku Nikah Baru
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Data Pernikahan
                    </h5>
                </div>
                <div class="card-body">
                    @if($marriages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Calon Pengantin Pria</th>
                                        <th>Calon Pengantin Wanita</th>
                                        <th>Tanggal Pernikahan</th>
                                        <th>Tempat Pernikahan</th>
                                        <th>Status</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($marriages as $index => $marriage)
                                    <tr>
                                        <td>{{ $marriages->firstItem() + $index }}</td>
                                        <td>
                                            <div>
                                                <strong>{{ $marriage->groom_name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">NIK: {{ $marriage->groom_nik ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $marriage->bride_name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">NIK: {{ $marriage->bride_nik ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($marriage->marriage_date)
                                                {{ \Carbon\Carbon::parse($marriage->marriage_date)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $marriage->marriage_place ?? 'N/A' }}</td>
                                        <td>
                                            @if($marriage->status === 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($marriage->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($marriage->createdBy)
                                                {{ $marriage->createdBy->name }}
                                            @else
                                                <span class="text-muted">System</span>
                                            @endif
                                        </td>
                                        <td>{{ $marriage->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data pernikahan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $marriages->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada data pernikahan</h5>
                            <p class="text-muted">Klik tombol "Buat Buku Nikah Baru" untuk menambahkan data pernikahan pertama.</p>
                            <a href="{{ route('admin.marriage.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Buku Nikah Pertama
                            </a>
                        </div>
                    @endif
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
        background: var(--light-bg);
        border-bottom: 1px solid #dee2e6;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection
