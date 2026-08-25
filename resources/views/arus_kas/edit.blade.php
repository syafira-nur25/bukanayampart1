@extends('layouts.app')

@section('title', 'Edit Arus Kas')

@section('content')
<h2 class="mb-3">Edit Transaksi Arus Kas</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('arus-kas.update', $arusKas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $arusKas->tanggal->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis" class="form-select" required>
                        <option value="masuk" @selected((float) $arusKas->penerimaan > 0)>Pemasukan (manual)</option>
                        <option value="keluar" @selected((float) $arusKas->pengeluaran > 0)>Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control"
                        value="{{ old('keterangan', $arusKas->keterangan) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nomor Bukti (opsional)</label>
                    <input type="text" name="nomor_bukti" class="form-control"
                        value="{{ old('nomor_bukti', $arusKas->nomor_bukti) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nominal (Rp)</label>
                    <input type="number" name="nominal" class="form-control"
                        value="{{ old('nominal', (float) $arusKas->penerimaan > 0 ? $arusKas->penerimaan : $arusKas->pengeluaran) }}"
                        min="0" required>
                </div>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('arus-kas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
