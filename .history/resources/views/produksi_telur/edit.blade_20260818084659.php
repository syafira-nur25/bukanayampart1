@extends('layouts.app')

@section('title', 'Edit Produksi Telur')

@section('content')
<h2 class="mb-3">Edit Produksi Telur</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('produksi-telur.update', $produksiTelur) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $produksiTelur->tanggal->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" id="kandang_id" class="form-select" required>
                        <option value="">-- Pilih Kandang --</option>
                        @foreach ($kandangs as $kandang)
                            <option value="{{ $kandang->id }}"
                                @selected(old('kandang_id', $produksiTelur->kandang_id) == $kandang->id)>
                                {{ $kandang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Populasi (otomatis)</label>
                    <input type="text" id="info-populasi" class="form-control bg-light" readonly value="-">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Produksi (butir)</label>
                    <input type="number" name="jumlah_produksi" id="jumlah_produksi" class="form-control"
                        value="{{ old('jumlah_produksi', $produksiTelur->jumlah_produksi) }}" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Persentase (otomatis)</label>
                    <input type="text" id="info-persentase" class="form-control bg-light" readonly value="-">
                </div>
            </div>
            <button class="btn btn-primary">Update</button>
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
