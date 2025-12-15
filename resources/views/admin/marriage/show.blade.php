@extends('layouts.admin')

@section('title', 'Detail Pernikahan - Admin')

@section('page_title', 'Detail Pernikahan')

@section('content')
<!-- Header Section -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 w-12 h-12 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
            <span>Detail Pernikahan</span>
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.marriage.print', $marriage->id) }}" 
               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl hover:from-green-700 hover:to-emerald-800 transition-all duration-300 shadow-lg shadow-green-500/30"
               target="_blank">
                <i class="fas fa-print mr-2"></i>
                <span class="font-medium">Print PDF</span>
            </a>
            <a href="{{ route('admin.marriages') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali</span>
            </a>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto">
    <!-- Groom Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-male text-white"></i>
                </div>
                Data Pengantin Pria
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                    <p class="text-gray-900 font-medium">{{ $marriage->groom_nik }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-medium">{{ $marriage->groom_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Lahir</label>
                    <p class="text-gray-900">{{ $marriage->groom_birth_place }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($marriage->groom_birth_date)->format('d F Y') }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                    <p class="text-gray-900">{{ $marriage->groom_address }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bride Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <div class="bg-pink-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-female text-white"></i>
                </div>
                Data Pengantin Wanita
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                    <p class="text-gray-900 font-medium">{{ $marriage->bride_nik }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-medium">{{ $marriage->bride_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Lahir</label>
                    <p class="text-gray-900">{{ $marriage->bride_birth_place }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($marriage->bride_birth_date)->format('d F Y') }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                    <p class="text-gray-900">{{ $marriage->bride_address }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Marriage Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-violet-600 to-purple-700 px-6 py-4">
            <h3 class="font-semibold text-white flex items-center">
                <i class="fas fa-calendar-alt mr-3 text-xl"></i>
                Informasi Pernikahan
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pernikahan</label>
                    <p class="text-gray-900 font-medium flex items-center">
                        <i class="fas fa-calendar text-violet-500 mr-2"></i>
                        {{ \Carbon\Carbon::parse($marriage->marriage_date)->format('d F Y') }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Pernikahan</label>
                    <p class="text-gray-900 flex items-center">
                        <i class="fas fa-map-marker-alt text-violet-500 mr-2"></i>
                        {{ $marriage->marriage_place }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Saksi 1</label>
                    <p class="text-gray-900 flex items-center">
                        <i class="fas fa-user-check text-violet-500 mr-2"></i>
                        {{ $marriage->witness1_name }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Saksi 2</label>
                    <p class="text-gray-900 flex items-center">
                        <i class="fas fa-user-check text-violet-500 mr-2"></i>
                        {{ $marriage->witness2_name }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                    <p>
                        @if($marriage->status === 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($marriage->status) }}
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat Oleh</label>
                    <p class="text-gray-900">
                        @if($marriage->createdBy)
                            {{ $marriage->createdBy->name }}
                        @else
                            System
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Dibuat</label>
                    <p class="text-gray-900">{{ $marriage->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diupdate</label>
                    <p class="text-gray-900">{{ $marriage->updated_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 justify-center mb-6">
        <a href="{{ route('admin.marriage.edit', $marriage->id) }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-700 text-white rounded-xl hover:from-amber-700 hover:to-orange-800 transition-all duration-300 shadow-lg shadow-amber-500/30">
            <i class="fas fa-edit mr-2"></i>
            <span class="font-medium">Edit Data</span>
        </a>
        <form action="{{ route('admin.marriage.delete', $marriage->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pernikahan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-700 text-white rounded-xl hover:from-red-700 hover:to-rose-800 transition-all duration-300 shadow-lg shadow-red-500/30">
                <i class="fas fa-trash mr-2"></i>
                <span class="font-medium">Hapus Data</span>
            </button>
        </form>
    </div>
</div>
@endsection
