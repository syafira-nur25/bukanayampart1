@extends('layouts.app')
@section('title', 'Edit Populasi')
@section('content')
<div class="card">
<div class="card-body">
<form action="{{ route('populasi.update', $populasi) }}" method="POST">
@csrf
@method('PUT')
<div class="mb-3">
    <label>Tanggal</label>
    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $populasi->tanggal->format('Y-m-d')) }}" required>
</div>
<div class="mb-3">
    <label>Kandang</label>
    <select name="kandang_id" class="form-select" required>
        @foreach($kandangs as $kandang)
        <option value="{{ $kandang->id }}" @selected($populasi->kandang_id == $kandang->id)>{{ $kandang->nama }}</option>
        @endforeach
    </select>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label>Hidup</label>
        <input type="number" name="hidup" class="form-control" value="{{ old('hidup', $populasi->hidup) }}" min="0" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Mati</label>
        <input type="number" name="mati" class="form-control" value="{{ old('mati', $populasi->mati) }}" min="0" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Afkir</label>
        <input type="number" name="afkir" class="form-control" value="{{ old('afkir', $populasi->afkir) }}" min="0" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Sisa (otomatis)</label>
        <input type="number" id="sisa" name="sisa" class="form-control" readonly value="{{ old('sisa', $populasi->sisa) }}">
        <div class="form-text">Sisa = Hidup − Mati − Afkir (dihitung otomatis)</div>
    </div>
    <div class="col-md-6 mb-3">
        <label>Usia (hari)</label>
        <input type="number" name="usia" class="form-control" value="{{ old('usia', $populasi->usia) }}" min="0" required>
    </div>
</div>
<button class="btn btn-primary">Update</button>
<a href="{{ route('populasi.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
</div>
<script>
function hitungSisa() {
    const hidup = parseInt(document.querySelector('[name="hidup"]').value || 0, 10) || 0;
    const mati  = parseInt(document.querySelector('[name="mati"]').value || 0, 10) || 0;
    const afkir = parseInt(document.querySelector('[name="afkir"]').value || 0, 10) || 0;
    document.getElementById('sisa').value = Math.max(0, hidup - mati - afkir);
}
['hidup', 'mati', 'afkir'].forEach(n =>
    document.querySelector('[name="' + n + '"]').addEventListener('input', hitungSisa));
hitungSisa();
</script>
@endsection
