@extends('layouts.admin')

@section('title', 'Daftar Pernikahan - Admin')

@section('page_title', 'Daftar Pernikahan')

@section('content')
<!-- Header Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 w-12 h-12 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
            <span>Daftar Pernikahan</span>
        </h1>
        <a href="{{ route('admin.marriage.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span class="font-medium">Buat Buku Nikah Baru</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-4 mb-6 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-500 hover:text-green-700 transition-colors" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

<!-- Main Content Card -->
<div class="bg-white rounded-lg shadow-sm">
    <!-- Card Header -->
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-list mr-2 text-primary"></i>
            Data Pernikahan
        </h3>
    </div>

    <!-- Card Body -->
    <div class="p-6">
        @if($marriages->count() > 0)
            <!-- Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 bg-gray-50">No</th>
                            <th class="px-4 py-3 bg-gray-50">Calon Pengantin Pria</th>
                            <th class="px-4 py-3 bg-gray-50">Calon Pengantin Wanita</th>
                            <th class="px-4 py-3 bg-gray-50">Tanggal Pernikahan</th>
                            <th class="px-4 py-3 bg-gray-50">Tempat Pernikahan</th>
                            <th class="px-4 py-3 bg-gray-50">Status</th>
                            <th class="px-4 py-3 bg-gray-50">Dibuat Oleh</th>
                            <th class="px-4 py-3 bg-gray-50">Tanggal Dibuat</th>
                            <th class="px-4 py-3 bg-gray-50 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($marriages as $index => $marriage)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $marriages->firstItem() + $index }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-male text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $marriage->groom_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">NIK: {{ $marriage->groom_nik ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-female text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $marriage->bride_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">NIK: {{ $marriage->bride_nik ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center text-sm text-gray-900">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                    @if($marriage->marriage_date)
                                        {{ \Carbon\Carbon::parse($marriage->marriage_date)->format('d M Y') }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center text-sm text-gray-900">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                    <span class="truncate max-w-xs" title="{{ $marriage->marriage_place ?? 'N/A' }}">
                                        {{ $marriage->marriage_place ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                @if($marriage->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <span class="w-2 h-2 bg-gray-500 rounded-full mr-1.5"></span>
                                        {{ ucfirst($marriage->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center text-sm">
                                    @if($marriage->createdBy)
                                        <img class="h-8 w-8 rounded-full mr-2" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($marriage->createdBy->name) }}&color=7F9CF5&background=EBF4FF" 
                                             alt="{{ $marriage->createdBy->name }}">
                                        <span class="text-gray-900">{{ $marriage->createdBy->name }}</span>
                                    @else
                                        <i class="fas fa-robot text-gray-400 mr-2"></i>
                                        <span class="text-gray-400">System</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-400 mr-2"></i>
                                    {{ $marriage->created_at->format('d M Y H:i') }}
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="#" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-110" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="#" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-amber-100 text-amber-600 rounded-lg hover:bg-amber-600 hover:text-white transition-all duration-300 transform hover:scale-110" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <a href="#" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 transform hover:scale-110" 
                                       title="Hapus"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data pernikahan ini?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-center">
                <div class="pagination-wrapper">
                    {{ $marriages->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full mb-4">
                    <i class="fas fa-heart text-4xl text-pink-500"></i>
                </div>
                <h5 class="text-xl font-semibold text-gray-800 mb-2">Belum ada data pernikahan</h5>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Klik tombol "Buat Buku Nikah Baru" untuk menambahkan data pernikahan pertama.
                </p>
                <a href="{{ route('admin.marriage.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    <span class="font-medium">Buat Buku Nikah Pertama</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom pagination styling to match Tailwind theme */
    .pagination-wrapper nav {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.25rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-wrapper .page-item {
        display: inline-block;
    }

    .pagination-wrapper .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem 0.75rem;
        background-color: white;
        border: 1px solid #e5e7eb;
        color: #374151;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .pagination-wrapper .page-link:hover {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(to right, #2563eb, #1d4ed8);
        color: white;
        border-color: #2563eb;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.4);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
        border-color: #e5e7eb;
    }

    .pagination-wrapper .page-item.disabled .page-link:hover {
        background-color: #f3f4f6;
        color: #9ca3af;
        transform: none;
        box-shadow: none;
    }
</style>
@endsection
