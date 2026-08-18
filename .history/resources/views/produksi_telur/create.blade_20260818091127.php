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
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-select" required>
                        <option value="">-- Pilih Kandang --</option>
                        @foreach ($kandangs as $kandang)
                            <option value="{{ $kandang->id }}" @selected(old('kandang_id') == $kandang->id)>
                                {{ $kandang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Populasi</label>
                    <select name="populasi_id" id="populasi_id" class="form-select" required>
                        <option value="">-- Pilih Populasi --</option>
                        @foreach ($populisis as $populasi)
                            <option value="{{ $populasi->id }}" @selected(old('populasi_id') == $populasi->id)>
                                {{ $populasi->tanggal->format('d-m-Y') }} - {{ $populasi->kandang->nama ?? '-' }} (sisa {{ $populasi->sisa }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Sisa Ayam (otomatis)</label>
                    <input type="text" id="info-sisa" class="form-control bg-light" readonly value="-">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Persentase (otomatis)</label>
                    <input type="text" id="info-persentase" class="form-control bg-light" readonly value="-">
                    <div class="form-text">= produksi ÷ populasi × 100</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Produksi (butir)</label>
                    <input type="number" name="jumlah_produksi" id="jumlah_produksi"
                        class="form-control" value="{{ old('jumlah_produksi', 0) }}" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Telur Bagus (butir)</label>
                    <input type="number" name="telur_bagus" class="form-control"
                        value="{{ old('telur_bagus', 0) }}" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Telur Reject (butir)</label>
                    <input type="number" name="telur_reject" class="form-control"
                        value="{{ old('telur_reject', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mati (ekor)</label>
                    <input type="number" name="mati" class="form-control" value="{{ old('mati', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Afkir (ekor)</label>
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
        const popId    = document.getElementById('populasi_id').value;
        const populasi = SISA[popId] ?? 0;
        const produksi = parseInt(document.getElementById('jumlah_produksi').value || 0, 10) || 0;

        document.getElementById('info-sisa').value =
            populasi > 0 ? populasi.toLocaleString('id-ID') + ' ekor' : '-';
        document.getElementById('info-persentase').value =
            populasi > 0 ? (produksi / populasi * 100).toFixed(2) + ' %' : '-';
    }

    document.getElementById('populasi_id').addEventListener('change', hitung);
    document.getElementById('jumlah_produksi').addEventListener('input', hitung);
    hitung();
</script>
@endsection
