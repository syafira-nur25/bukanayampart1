@extends('layouts.app')
@section('title', 'Tambah Produksi Telur')
@section('content')
<h2>Tambah Produksi Telur</h2>
<div class="card">
<div class="card-body">
<form action="{{ route('produksi-telur.store') }}" method="POST">
@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Kandang</label>
        <select name="kandang_id" class="form-select" required>
            <option value="">-- Pilih Kandang --</option>
            @foreach($kandangs as $kandang)
            <option value="{{ $kandang->id }}" @selected(old('kandang_id') == $kandang->id)>{{ $kandang->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Populasi</label>
        <select name="populasi_id" id="populasi_id" class="form-select" required>
            <option value="">-- Pilih Populasi --</option>
            @foreach($populisis as $populasi)
            <option value="{{ $populasi->id }}" @selected(old('populasi_id') == $populasi->id)>
                {{ $populasi->tanggal->format('d-m-Y') }} - {{ $populasi->kandang->nama ?? '-' }} (sisa {{ $populasi->sisa }})
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>Sisa Ayam (otomatis dari populasi)</label>
        <input type="number" id="sisa_ayam" name="sisa_ayam" class="form-control" readonly value="{{ old('sisa_ayam', 0) }}">
    </div>
    <div class="col-md-4 mb-3">
        <label>Jumlah Produksi</label>
        <input type="number" id="jumlah_produksi" name="jumlah_produksi" class="form-control" value="{{ old('jumlah_produksi', 0) }}" min="0" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Persentase (%) (otomatis)</label>
        <input type="text" id="presentase" name="presentase" class="form-control" readonly value="{{ old('presentase', 0) }}">
    </div>
    <div class="col-md-4 mb-3">
        <label>Telur Bagus</label>
        <input type="number" name="telur_bagus" class="form-control" value="{{ old('telur_bagus', 0) }}" min="0" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Telur Reject</label>
        <input type="number" name="telur_reject" class="form-control" value="{{ old('telur_reject', 0) }}" min="0" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Mati</label>
        <input type="number" name="mati" class="form-control" value="{{ old('mati', 0) }}" min="0" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Afkir</label>
        <input type="number" name="afkir" class="form-control" value="{{ old('afkir', 0) }}" min="0" required>
    </div>
</div>
<button class="btn btn-primary">Simpan</button>
<a href="{{ route('produksi-telur.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
</div>
<script>
const SISA = @js($sisaPopulasi);
function hitung() {
    const popId = document.getElementById('populasi_id').value;
    const sisa = SISA[popId] ?? 0;
    const produksi = parseInt(document.getElementById('jumlah_produksi').value || 0, 10) || 0;
    document.getElementById('sisa_ayam').value = sisa;
    document.getElementById('presentase').value = sisa > 0 ? (produksi / sisa * 100).toFixed(2) : 0;
}
document.getElementById('populasi_id').addEventListener('change', hitung);
document.getElementById('jumlah_produksi').addEventListener('input', hitung);
hitung();
</script>
@endsection
