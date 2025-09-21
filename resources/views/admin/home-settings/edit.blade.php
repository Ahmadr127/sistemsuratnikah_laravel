@extends('layouts.app')

@section('title', 'Pengaturan Home')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Pengaturan Halaman Home</h5>
                </div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.home-settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $setting->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subjudul</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{ old('subtitle', $setting->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fitur (JSON)</label>
                            <textarea rows="8" class="form-control @error('features') is-invalid @enderror" name="features">{{ old('features', json_encode($setting->features, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea>
                            <div class="form-text">Format: array of objects [{"icon":"fas fa-...","title":"..","description":".."}]</div>
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statistik (JSON)</label>
                            <textarea rows="6" class="form-control @error('stats') is-invalid @enderror" name="stats">{{ old('stats', json_encode($setting->stats, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) }}</textarea>
                            <div class="form-text">Format: object {"total_marriages":1234,"happy_couples":...,"years_experience":...,"satisfaction_rate":...}</div>
                            @error('stats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


