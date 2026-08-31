@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')
<h2 class="mb-3">Edit Gudang Telur</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('gudang-telur.update', $gudangTelur) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Gudang</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama', $gudangTelur->nama) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi (opsional)</label>
                <input type="text" name="lokasi" class="form-control"
                       value="{{ old('lokasi', $gudangTelur->lokasi) }}">
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('gudang-telur.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
