@extends('layouts.admin')

@section('title', 'Kelola KUA - Admin')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-mosque mr-3"></i>
                Kelola KUA
            </h1>
            <p class="text-blue-100 text-lg">Manajemen Kantor Urusan Agama</p>
        </div>
        <a href="{{ route('admin.kuas.create') }}"
            class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-300 flex items-center shadow-lg">
            <i class="fas fa-plus mr-2"></i>
            Tambah KUA Baru
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-3"></i>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6">
        @if($kuas->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b-2 border-gray-200">
                        <th class="pb-3">Urutan</th>
                        <th class="pb-3">Nama KUA</th>
                        <th class="pb-3">Alamat</th>
                        <th class="pb-3">Kontak</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($kuas as $kua)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-semibold">
                                {{ $kua->order }}
                            </span>
                        </td>
                        <td class="py-4">
                            <div class="font-medium text-gray-900">{{ $kua->name }}</div>
                        </td>
                        <td class="py-4">
                            <div class="text-gray-600 text-sm max-w-md truncate">{{ $kua->address }}</div>
                        </td>
                        <td class="py-4">
                            <div class="text-sm">
                                @if($kua->phone)
                                <div class="text-gray-600"><i class="fas fa-phone text-blue-500 mr-1"></i> {{ $kua->phone }}</div>
                                @endif
                                @if($kua->email)
                                <div class="text-gray-600"><i class="fas fa-envelope text-blue-500 mr-1"></i> {{ $kua->email }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4">
                            @if($kua->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <span class="w-2 h-2 bg-gray-500 rounded-full mr-1.5"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.kuas.edit', $kua->id) }}"
                                    class="px-3 py-1.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.kuas.destroy', $kua->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus KUA ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300 text-sm">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-mosque text-gray-300 text-6xl mb-4"></i>
            <p class="text-xl text-gray-500">Belum ada data KUA</p>
            <a href="{{ route('admin.kuas.create') }}"
                class="mt-4 inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>
                Tambah KUA Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
