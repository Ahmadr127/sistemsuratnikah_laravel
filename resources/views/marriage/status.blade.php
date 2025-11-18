@extends('layouts.app')

@section('title', 'Status Pengajuan Buku Nikah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Status Pengajuan Buku Nikah</h1>

            @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 border-l-4 border-green-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($marriages->isEmpty())
            <div class="text-center py-12">
                <div class="mb-4">
                    <i class="fas fa-file-alt text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada pengajuan</h3>
                <p class="mt-2 text-gray-500">Anda belum membuat pengajuan buku nikah.</p>
                <div class="mt-6">
                    <a href="{{ route('marriage.request') }}"
                       class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/90">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Pengajuan Baru
                    </a>
                </div>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengantin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Nikah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($marriages as $index => $marriage)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $marriage->groom_name }}</div>
                                <div class="text-sm text-gray-500">{{ $marriage->bride_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($marriage->marriage_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($marriage->status === 'active') bg-green-100 text-green-800
                                    @elseif($marriage->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @elseif($marriage->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($marriage->status === 'active')
                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                    @elseif($marriage->status === 'inactive')
                                        <i class="fas fa-pause-circle mr-1"></i> Nonaktif
                                    @elseif($marriage->status === 'cancelled')
                                        <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                                    @else
                                        <i class="fas fa-info-circle mr-1"></i> Tidak Diketahui
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $marriage->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-end">
                <a href="{{ route('marriage.request') }}"
                   class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/90">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Pengajuan Baru
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection