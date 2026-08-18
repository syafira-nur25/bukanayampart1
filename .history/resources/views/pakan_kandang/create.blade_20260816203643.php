@extends('layouts.app')

@section('title', 'Catat Pakan')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Catat Pakan</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('pakan-kandang.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Catatan</label>
                    <select name="jenis" id="jenis" class="form-select" onchange="toggleJenis(this.value)">
                        <option value="masuk" @selected(old('jenis') == 'masuk')">Pakan masuk gudang</option>
                        <option value="keluar" @selected(old('jenis', 'keluar') == 'keluar')">Kandang ambil pakan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3" id="wrap-kandang">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-select @error('kandang_id') is-invalid @enderror">
                        <option value="">-- Pilih Kandang --</option>
                        @foreach ($kandangs as $kandang)
                            <option value="{{ $kandang->id }}" @selected(old('kandang_id') == $kandang->id)>
                                {{ $kandang->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kandang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3" id="wrap-masuk">
                    <label class="form-label">Total Masuk (zak)</label>
                    <input type="number" step="0.01" min="0" name="total_masuk"
                        class="form-control @error('total_masuk') is-invalid @enderror"
                        value="{{ old('total_masuk') }}">
                    @error('total_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">1 zak = 50 Kg</div>
                </div>

                <div class="col-md-6 mb-3" id="wrap-keluar">
                    <label class="form-label">Keluar (Kg)</label>
                    <input type="number" step="0.01" min="0" name="keluar"
                        class="form-control @error('keluar') is-invalid @enderror"
                        value="{{ old('keluar') }}">
                    @error('keluar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
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
