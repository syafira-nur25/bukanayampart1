@extends('layouts.app')

@section('title', 'Catat Transaksi Arus Kas')

@section('content')
<h2 class="mb-3">Catat Transaksi Arus Kas</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('arus-kas.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis" class="form-select" required>
                        <option value="keluar" @selected(old('jenis', 'keluar') === 'keluar')>Pengeluaran (manual)</option>
                        <option value="masuk" @selected(old('jenis') === 'masuk')>Pemasukan (manual)</option>
                    </select>
                    <div class="form-text">Pemasukan dari penjualan telur tercatat otomatis, tidak perlu diinput di sini.</div>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control"
                           value="{{ old('keterangan') }}"
                           placeholder="Contoh: Pakan jadi, Listrik, Bantuan modal dari PKN" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nomor Bukti (opsional)</label>
                    <input type="text" name="nomor_bukti" class="form-control" value="{{ old('nomor_bukti') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nominal (Rp)</label>
                    <input type="number" name="nominal" class="form-control"
                           value="{{ old('nominal', 0) }}" min="0" required>
                </div>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('arus-kas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
