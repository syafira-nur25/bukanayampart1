@extends('layouts.app')

@section('title', 'Tambah Penjualan Telur')

@section('content')

<h2>Tambah Penjualan Telur</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('penjualan-telur.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Customer</label>
                    <input type="text" name="customer" class="form-control"
                        value="{{ old('customer') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Produksi Telur</label>
                    <select name="produksi_id" class="form-select" required>
                        <option value="">-- Pilih Produksi --</option>
                        @foreach($produksis as $produksi)
                            <option value="{{ $produksi->id }}"
                                @selected(old('produksi_id') == $produksi->id)>
                                {{ $produksi->tanggal->format('d-m-Y') }} - {{ $produksi->kandang->nama ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Jumlah (ikat)</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                        value="{{ old('jumlah', 0) }}" min="1" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Harga per ikat (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control"
                        value="{{ old('harga', 0) }}" min="0" step="1" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Total (Rp)</label>
                    <input type="text" id="total-display" class="form-control bg-light fw-bold" readonly value="Rp 0">
                    <input type="hidden" name="total" id="total-input" value="0">
                    <div class="form-text">= Jumlah ikat × Harga per ikat (otomatis)</div>
                </div>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('penjualan-telur.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function formatRp(n) { return 'Rp ' + Number(n || 0).toLocaleString('id-ID'); }
function hitungTotal() {
    const j = parseInt(document.getElementById('jumlah').value || 0, 10) || 0;
    const h = parseInt(document.getElementById('harga').value  || 0, 10) || 0;
    const t = j * h;
    document.getElementById('total-display').value = formatRp(t);
    document.getElementById('total-input').value   = t;
}
document.getElementById('jumlah').addEventListener('input', hitungTotal);
document.getElementById('harga').addEventListener('input', hitungTotal);
hitungTotal();
</script>
@endpush
