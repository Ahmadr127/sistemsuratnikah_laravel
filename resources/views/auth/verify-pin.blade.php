@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Verifikasi Kode</h1>

    @if(session('status'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4 text-sm text-gray-600">Kode verifikasi telah dikirim ke: <strong>{{ $email }}</strong></div>

    <form method="POST" action="{{ route('pin.verify') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div>
            <label class="block text-sm text-gray-700 mb-1">Masukkan Kode 4 Digit</label>
            <input type="text" name="pin" inputmode="numeric" pattern="\\d{4}" maxlength="4" minlength="4" required class="w-full border rounded px-3 py-2 tracking-widest text-center text-lg">
            <p class="text-xs text-gray-500 mt-1">Masa berlaku 10 menit.</p>
        </div>
        <button type="submit" class="w-full bg-secondary text-white rounded px-4 py-2">Verifikasi</button>
    </form>
</div>
@endsection
