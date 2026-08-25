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
                            <option value="{{ $k->id }}" @selected(old('kandang_id') == $k->id)>
                                {{ $k->nama }}
                            </option>
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
                    <input type="number" name="bobot" class="form-control"
                        value="{{ old('bobot') }}" min="0" required>
                    <div class="form-text">Contoh: 1500 = 1,5 kg. Input ulang untuk menambah sampel lain.</div>
                </div>
            </div>
            <button class="btn btn-primary">Simpan Sampel</button>
            <a href="{{ route('bobot.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

        <div class="alert alert-info mt-3 mb-0 small">
            <i class="bi bi-info-circle me-1"></i>
            Untuk satu kandang & tanggal yang sama, kamu bisa input <b>berkali-kali</b> —
            tiap input akan menjadi sampel terpisah (#1, #2, #3, ...) di tabel.
        </div>
    </div>
</div>
@endsection
