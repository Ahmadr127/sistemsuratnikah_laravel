@extends('layouts.admin')

@section('title', 'Dashboard Admin - Buku Nikah Digital')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">
            <i class="fas fa-tachometer-alt mr-2 text-primary"></i>Dashboard Admin
        </h1>
        <div class="text-gray-600">
            Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Users -->
    <div
        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-2xl font-bold">{{ number_format($stats['total_users']) }}</h4>
                <p class="text-blue-100">Total Users</p>
            </div>
            <div class="text-white/80">
                <i class="fas fa-users text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Admin Users -->
    <div
        class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-2xl font-bold">{{ number_format($stats['total_admins']) }}</h4>
                <p class="text-emerald-100">Admin</p>
            </div>
            <div class="text-white/80">
                <i class="fas fa-user-shield text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Regular Users -->
    <div
        class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-2xl font-bold">{{ number_format($stats['total_regular_users']) }}</h4>
                <p class="text-violet-100">Regular Users</p>
            </div>
            <div class="text-white/80">
                <i class="fas fa-user text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Marriages -->
    <div
        class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-2xl font-bold">{{ number_format($stats['total_marriages']) }}</h4>
                <p class="text-amber-100">Total Marriages</p>
            </div>
            <div class="text-white/80">
                <i class="fas fa-heart text-4xl"></i>
            </div>
        </div>
    </div> <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">
                    <i class="fas fa-users mr-2 text-primary"></i>Recent Users
                </h3>
            </div>
            <div class="p-6">
                @if($recent_users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recent_users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    @if($user->isAdmin())
                                    <span
                                        class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Admin</span>
                                    @else
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">User</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.users') }}"
                        class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all duration-300">
                        <span>View All Users</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                @else
                <p class="text-gray-500 text-center py-4">No users found.</p>
                @endif
            </div>
        </div>

        <!-- Recent Marriages -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">
                    <i class="fas fa-heart mr-2 text-primary"></i>Recent Marriages
                </h3>
            </div>
            <div class="p-6">
                @if($recent_marriages->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="px-4 py-3">Groom</th>
                                <th class="px-4 py-3">Bride</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recent_marriages as $marriage)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $marriage->groom_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $marriage->bride_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $marriage->marriage_date ? \Carbon\Carbon::parse($marriage->marriage_date)->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Active</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.marriages') }}"
                        class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all duration-300">
                        <span>View All Marriages</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                @else
                <p class="text-gray-500 text-center py-4">No marriages found.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">
                <i class="fas fa-bolt mr-2 text-primary"></i>Quick Actions
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.users') }}"
                    class="flex items-center justify-center px-4 py-3 bg-white border-2 border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition-colors duration-300">
                    <i class="fas fa-users mr-2"></i>
                    <span>Manage Users</span>
                </a>
                <a href="{{ route('admin.marriage.create') }}"
                    class="flex items-center justify-center px-4 py-3 bg-white border-2 border-green-500 text-green-500 rounded-lg hover:bg-green-500 hover:text-white transition-colors duration-300">
                    <i class="fas fa-heart mr-2"></i>
                    <span>Buat Buku Nikah</span>
                </a>
                <a href="{{ route('admin.marriages') }}"
                    class="flex items-center justify-center px-4 py-3 bg-white border-2 border-blue-500 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-colors duration-300">
                    <i class="fas fa-list mr-2"></i>
                    <span>Daftar Pernikahan</span>
                </a>
                <a href="{{ route('admin.ktp-data') }}"
                    class="flex items-center justify-center px-4 py-3 bg-white border-2 border-amber-500 text-amber-500 rounded-lg hover:bg-amber-500 hover:text-white transition-colors duration-300">
                    <i class="fas fa-id-card mr-2"></i>
                    <span>Data KTP</span>
                </a>
                <a href="{{ route('admin.home-settings.edit') }}"
                    class="flex items-center justify-center px-4 py-3 bg-white border-2 border-violet-500 text-violet-500 rounded-lg hover:bg-violet-500 hover:text-white transition-colors duration-300">
                    <i class="fas fa-cog mr-2"></i>
                    <span>Home Settings</span>
                </a>
                <a href="#"
                    class="flex items-center justify-center px-4 py-3 bg-white border-2 border-gray-500 text-gray-500 rounded-lg hover:bg-gray-500 hover:text-white transition-colors duration-300">
                    <i class="fas fa-chart-bar mr-2"></i>
                    <span>Reports</span>
                </a>
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