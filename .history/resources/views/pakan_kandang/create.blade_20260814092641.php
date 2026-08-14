@extends('layouts.app')

@section('title', 'Tambah Pakan Kandang')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Tambah Data Pakan</h2>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('pakan-kandang.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- Tanggal --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', date('Y-m-d')) }}"
                        required
                    >
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kandang --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-select @error('kandang_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kandang --</option>
                        @foreach($kandangs as $kandang)
                            <option value="{{ $kandang->id }}" @selected(old('kandang_id') == $kandang->id)>
                                {{ $kandang->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kandang_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Total Masuk --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Masuk (Kg)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="total_masuk"
                        class="form-control @error('total_masuk') is-invalid @enderror"
                        value="{{ old('total_masuk', 0) }}"
                        min="0"
                        required
                    >
                    @error('total_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keluar --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Keluar (Kg)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="keluar"
                        class="form-control @error('keluar') is-invalid @enderror"
                        value="{{ old('keluar', 0) }}"
                        min="0"
                        required
                    >
                    @error('keluar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Sisa --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Sisa (Kg)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="sisa"
                        class="form-control @error('sisa') is-invalid @enderror"
                        value="{{ old('sisa', 0) }}"
                        min="0"
                        required
                    >
                    @error('sisa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pakan-kandang.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection
