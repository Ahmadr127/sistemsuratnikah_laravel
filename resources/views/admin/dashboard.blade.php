@extends('layouts.admin')

@section('title', 'Dashboard Admin - Buku Nikah Digital')

@section('content')
<!-- Welcome Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 mb-6 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard Admin
            </h1>
            <p class="text-blue-100 text-lg">
                Selamat datang kembali, <span class="font-semibold text-white">{{ Auth::user()->name }}</span>
            </p>
        </div>
        <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2">
            <i class="fas fa-calendar-alt text-white"></i>
            <span class="text-white font-medium">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
        <!-- Animated background decoration -->
        <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Users</p>
                    <h4 class="text-4xl font-bold mt-2">{{ number_format($stats['total_users']) }}</h4>
                </div>
                <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors duration-300">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-blue-100 text-sm">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Semua pengguna terdaftar</span>
            </div>
        </div>
    </div>

    <!-- Admin Users -->
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-emerald-100 text-sm font-medium uppercase tracking-wide">Admin</p>
                    <h4 class="text-4xl font-bold mt-2">{{ number_format($stats['total_admins']) }}</h4>
                </div>
                <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors duration-300">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-emerald-100 text-sm">
                <i class="fas fa-shield-alt mr-1"></i>
                <span>Administrator aktif</span>
            </div>
        </div>
    </div>

    <!-- Regular Users -->
    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-violet-100 text-sm font-medium uppercase tracking-wide">Regular Users</p>
                    <h4 class="text-4xl font-bold mt-2">{{ number_format($stats['total_regular_users']) }}</h4>
                </div>
                <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors duration-300">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-violet-100 text-sm">
                <i class="fas fa-users mr-1"></i>
                <span>Pengguna biasa</span>
            </div>
        </div>
    </div>

    <!-- Total Marriages -->
    <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-pink-100 text-sm font-medium uppercase tracking-wide">Total Marriages</p>
                    <h4 class="text-4xl font-bold mt-2">{{ number_format($stats['total_marriages']) }}</h4>
                </div>
                <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors duration-300">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-pink-100 text-sm">
                <i class="fas fa-ring mr-1"></i>
                <span>Pernikahan terdaftar</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-users text-white"></i>
                </div>
                Pengguna Terbaru
            </h3>
        </div>
        <div class="p-6">
            @if($recent_users->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recent_users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full mr-2" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" 
                                         alt="{{ $user->name }}">
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-gray-600 text-sm">{{ $user->email }}</td>
                            <td class="py-3">
                                @if($user->isAdmin())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-100 to-amber-100 text-amber-800">
                                    <i class="fas fa-shield-alt mr-1"></i>Admin
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800">
                                    <i class="fas fa-user mr-1"></i>User
                                </span>
                                @endif
                            </td>
                            <td class="py-3 text-gray-600 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.users') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                    <span class="font-medium">Lihat Semua</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">Belum ada pengguna terbaru</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Marriages -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
        <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-pink-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-heart text-white"></i>
                </div>
                Pernikahan Terbaru
            </h3>
        </div>
        <div class="p-6">
            @if($recent_marriages->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                            <th class="pb-3">Pengantin Pria</th>
                            <th class="pb-3">Pengantin Wanita</th>
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recent_marriages as $marriage)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 font-medium text-gray-900">{{ $marriage->groom_name ?? 'N/A' }}</td>
                            <td class="py-3 font-medium text-gray-900">{{ $marriage->bride_name ?? 'N/A' }}</td>
                            <td class="py-3 text-gray-600 text-sm">
                                {{ $marriage->marriage_date ? \Carbon\Carbon::parse($marriage->marriage_date)->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                    Aktif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.marriages') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-600 to-rose-700 text-white rounded-lg hover:from-pink-700 hover:to-rose-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                    <span class="font-medium">Lihat Semua</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-heart text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">Belum ada pernikahan terbaru</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-violet-50 to-purple-50 px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <div class="bg-violet-500 p-2 rounded-lg mr-3">
                <i class="fas fa-bolt text-white"></i>
            </div>
            Aksi Cepat
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.users') }}"
                class="group relative overflow-hidden flex items-center justify-center px-6 py-4 bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-200 text-blue-700 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-users text-xl mr-3"></i>
                    <span class="font-semibold">Kelola Pengguna</span>
                </div>
            </a>

            <a href="{{ route('admin.marriage.create') }}"
                class="group relative overflow-hidden flex items-center justify-center px-6 py-4 bg-gradient-to-br from-pink-50 to-rose-50 border-2 border-pink-200 text-pink-700 rounded-xl hover:border-pink-500 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-rose-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-heart text-xl mr-3"></i>
                    <span class="font-semibold">Buat Buku Nikah</span>
                </div>
            </a>

            <a href="{{ route('admin.marriages') }}"
                class="group relative overflow-hidden flex items-center justify-center px-6 py-4 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 text-blue-700 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-list text-xl mr-3"></i>
                    <span class="font-semibold">Daftar Pernikahan</span>
                </div>
            </a>

            <a href="{{ route('admin.ktp-data') }}"
                class="group relative overflow-hidden flex items-center justify-center px-6 py-4 bg-gradient-to-br from-amber-50 to-orange-50 border-2 border-amber-200 text-amber-700 rounded-xl hover:border-amber-500 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-id-card text-xl mr-3"></i>
                    <span class="font-semibold">Data KTP</span>
                </div>
            </a>

            <a href="{{ route('admin.home-settings.edit') }}"
                class="group relative overflow-hidden flex items-center justify-center px-6 py-4 bg-gradient-to-br from-violet-50 to-purple-50 border-2 border-violet-200 text-violet-700 rounded-xl hover:border-violet-500 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-cog text-xl mr-3"></i>
                    <span class="font-semibold">Pengaturan Home</span>
                </div>
            </a>

            <a href="#"
                class="group relative overflow-hidden flex items-center justify-center px-6 py-4 bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-500 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-500 to-slate-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-chart-bar text-xl mr-3"></i>
                    <span class="font-semibold">Laporan</span>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection