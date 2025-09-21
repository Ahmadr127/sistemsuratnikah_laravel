@extends('layouts.app')

@section('title', 'Dashboard Admin - Buku Nikah Digital')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
                <div class="text-muted">
                    Selamat datang, <strong>{{ Auth::user()->name }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_users']) }}</h4>
                            <p class="mb-0">Total Users</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_admins']) }}</h4>
                            <p class="mb-0">Admin</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_regular_users']) }}</h4>
                            <p class="mb-0">Regular Users</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_marriages']) }}</h4>
                            <p class="mb-0">Total Marriages</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Recent Users</h5>
                </div>
                <div class="card-body">
                    @if($recent_users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->isAdmin())
                                                <span class="badge bg-warning text-dark">Admin</span>
                                            @else
                                                <span class="badge bg-info">User</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm">View All Users</a>
                        </div>
                    @else
                        <p class="text-muted text-center">No users found.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Marriages -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Recent Marriages</h5>
                </div>
                <div class="card-body">
                    @if($recent_marriages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Groom</th>
                                        <th>Bride</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_marriages as $marriage)
                                    <tr>
                                        <td>{{ $marriage->groom_name ?? 'N/A' }}</td>
                                        <td>{{ $marriage->bride_name ?? 'N/A' }}</td>
                                        <td>{{ $marriage->marriage_date ? \Carbon\Carbon::parse($marriage->marriage_date)->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.marriages') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Pernikahan</a>
                        </div>
                    @else
                        <p class="text-muted text-center">No marriages found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.marriage.create') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-heart me-2"></i>Buat Buku Nikah
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.marriages') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-list me-2"></i>Daftar Pernikahan
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.home-settings.edit') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-cog me-2"></i>Home Settings
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-warning w-100">
                                <i class="fas fa-chart-bar me-2"></i>Reports
                            </a>
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
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
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
</style>
@endsection
