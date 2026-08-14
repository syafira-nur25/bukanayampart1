@extends('layouts.app')

@section('title', 'Tambah Kandang')

@section('content')

<h2 class="mb-3">Tambah Kandang</h2>

<div class="card">
    <div class="card-body">

        <form action="{{ route('kandang.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Kandang</label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    value="{{ old('lokasi') }}"
                    required
                >
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('kandang.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection
