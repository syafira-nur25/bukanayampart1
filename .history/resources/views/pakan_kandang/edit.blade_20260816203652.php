@extends('layouts.app')

@section('title', 'Edit Pakan')

@section('content')
@php
    $jenis = old('jenis', $pakanKandang->kandang_id === null ? 'masuk' : 'keluar');
@endphp

<h2>Edit Pakan</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('pakan-kandang.update', $pakanKandang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Catatan</label>
                    <select name="jenis" id="jenis" class="form-select" onchange="toggleJenis(this.value)">
                        <option value="masuk" @selected($jenis == 'masuk')">Pakan masuk gudang</option>
                        <option value="keluar" @selected($jenis == 'keluar')">Kandang ambil pakan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $pakanKandang->tanggal->format('Y-m-d')) }}" required>
                </div>

                <div class="col-md-6 mb-3" id="wrap-kandang">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-select">
                        <option value="">-- Pilih Kandang --</option>
                        @foreach ($kandangs as $kandang)
                            <option value="{{ $kandang->id }}" @selected(old('kandang_id', $pakanKandang->kandang_id) == $kandang->id)>
                                {{ $kandang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3" id="wrap-masuk">
                    <label class="form-label">Total Masuk (zak)</label>
                    <input type="number" step="0.01" min="0" name="total_masuk" class="form-control"
                        value="{{ old('total_masuk', $pakanKandang->total_masuk) }}">
                </div>

                <div class="col-md-6 mb-3" id="wrap-keluar">
                    <label class="form-label">Keluar (Kg)</label>
                    <input type="number" step="0.01" min="0" name="keluar" class="form-control"
                        value="{{ old('keluar', $pakanKandang->keluar) }}">
                </div>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('pakan-kandang.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    function toggleJenis(v) {
        document.getElementById('wrap-masuk').style.display   = (v === 'masuk')  ? '' : 'none';
        document.getElementById('wrap-kandang').style.display = (v === 'keluar') ? '' : 'none';
        document.getElementById('wrap-keluar').style.display  = (v === 'keluar') ? '' : 'none';
    }
    toggleJenis(document.getElementById('jenis').value);
</script>
@endsection
