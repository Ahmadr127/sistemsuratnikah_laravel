@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Lupa Password</h1>

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

    <form method="POST" action="{{ url('/forgot-password') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="w-full bg-secondary text-white rounded px-4 py-2">Kirim Kode Verifikasi</button>
    </form>
</div>
@endsection
