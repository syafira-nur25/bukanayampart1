@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')
<h2 class="mb-3">Tambah Gudang Telur</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('gudang-telur.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Gudang</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama') }}" placeholder="Contoh: Gudang A" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi (opsional)</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('gudang-telur.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
