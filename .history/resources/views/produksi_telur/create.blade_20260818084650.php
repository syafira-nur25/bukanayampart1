@extends('layouts.app')

@section('title', 'Tambah Produksi Telur')

@section('content')
<h2 class="mb-3">Tambah Produksi Telur</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('produksi-telur.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" id="kandang_id"
                        class="form-select @error('kandang_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kandang --</option>
                        @foreach ($kandangs as $kandang)
                            <option value="{{ $kandang->id }}" @selected(old('kandang_id') == $kandang->id)>
                                {{ $kandang->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kandang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Populasi (otomatis)</label>
                    <input type="text" id="info-populasi" class="form-control bg-light" readonly value="-">
                    <div class="form-text">Diambil dari sisa laporan harian / populasi terakhir.</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Produksi (butir)</label>
                    <input type="number" name="jumlah_produksi" id="jumlah_produksi"
                        class="form-control @error('jumlah_produksi') is-invalid @enderror"
                        value="{{ old('jumlah_produksi', 0) }}" min="0" required>
                    @error('jumlah_produksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Persentase (otomatis)</label>
                    <input type="text" id="info-persentase" class="form-control bg-light" readonly value="-">
                    <div class="form-text">= jumlah produksi ÷ populasi × 100</div>
                </div>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('produksi-telur.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
    const POP = @js($populasiKandang);

    function hitung() {
        const k        = document.getElementById('kandang_id').value;
        const populasi = POP[k] ?? 0;
        const produksi = parseInt(document.getElementById('jumlah_produksi').value || 0, 10) || 0;

        document.getElementById('info-populasi').value =
            populasi > 0 ? populasi.toLocaleString('id-ID') + ' ekor' : '-';
        document.getElementById('info-persentase').value =
            populasi > 0 ? (produksi / populasi * 100).toFixed(2) + ' %' : '-';
    }

    document.getElementById('kandang_id').addEventListener('change', hitung);
    document.getElementById('jumlah_produksi').addEventListener('input', hitung);
    hitung();
</script>
@endsection
