@extends('layouts.app')

@section('title', 'Catat Bobot')

@section('content')
<h2 class="mb-3">Catat Bobot Ayam</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('bobot.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-select" required>
                        <option value="">-- Pilih Kandang --</option>
                        @foreach ($kandangs as $k)
                            <option value="{{ $k->id }}" @selected(old('kandang_id') == $k->id)>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bobot (gram)</label>
                    <input type="number" name="bobot" class="form-control" value="{{ old('bobot') }}" min="0" required>
                    <div class="form-text">Contoh: 1500 = 1,5 kg per ekor</div>
                </div>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('bobot.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
