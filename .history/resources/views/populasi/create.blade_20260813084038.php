@extends('layouts.app')

@section('title', 'Tambah Populasi')

@section('content')

<h2>Tambah Populasi</h2>

<div class="card">
    <div class="card-body">

        <form action="{{ route('populasi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ old('tanggal') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Kandang</label>

                <select name="kandang_id" class="form-select" required>
                    <option value="">-- Pilih Kandang --</option>

                    @foreach($kandangs as $kandang)
                        <option
                            value="{{ $kandang->id }}"
                            @selected(old('kandang_id') == $kandang->id)
                        >
                            {{ $kandang->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Hidup</label>
                    <input
                        type="number"
                        name="hidup"
                        class="form-control"
                        value="{{ old('hidup', 0) }}"
                        min="0"
                        required
                    >
                </div>

                <div class="col-md-4 mb-3">
                    <label>Mati</label>
                    <input
                        type="number"
                        name="mati"
                        class="form-control"
                        value="{{ old('mati', 0) }}"
                        min="0"
                        required
                    >
                </div>

                <div class="col-md-4 mb-3">
                    <label>Afkir</label>
                    <input
                        type="number"
                        name="afkir"
                        class="form-control"
                        value="{{ old('afkir', 0) }}"
                        min="0"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label>Sisa</label>
                    <input
                        type="number"
                        name="sisa"
                        class="form-control"
                        value="{{ old('sisa', 0) }}"
                        min="0"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label>Usia (hari)</label>
                    <input
                        type="number"
                        name="usia"
                        class="form-control"
                        value="{{ old('usia', 0) }}"
                        min="0"
                        required
                    >
                </div>

            </div>

            <button class="btn btn-primary">Simpan</button>

            <a
                href="{{ route('populasi.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
