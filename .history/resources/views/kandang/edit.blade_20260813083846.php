@extends('layouts.app')

@section('title', 'Edit Kandang')

@section('content')

<h2 class="mb-3">Edit Kandang</h2>

<div class="card">
    <div class="card-body">

        <form action="{{ route('kandang.update', $kandang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Kandang</label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama', $kandang->nama) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    value="{{ old('lokasi', $kandang->lokasi) }}"
                    required
                >
            </div>

            <button class="btn btn-primary">
                Update
            </button>

            <a href="{{ route('kandang.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection
