@extends('layouts.manpower')

@section('title', 'Input Laporan Harian')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1">Laporan Harian</h5>
        <p class="text-muted small mb-3">
            <strong>Jumlah ayam dihitung otomatis</strong> oleh sistem.
        </p>

        <div class="alert alert-info py-3 mb-4">
            <div class="row text-center">
                <div class="col-4">
                    <div class="small text-muted">Populasi Terakhir</div>
                    <div class="fs-4 fw-bold" id="info-hidup">-</div>
                    <div class="small">ekor</div>
                </div>
                <div class="col-4">
                    <div class="small text-muted">Perkiraan Sisa Setelah Laporan</div>
                    <div class="fs-4 fw-bold text-success" id="info-sisa">-</div>
                    <div class="small">ekor</div>
                </div>
                <div class="col-4">
                    <div class="small text-muted">Data Per Tanggal</div>
                    <div class="fw-bold" id="info-tanggal">-</div>
                    <div class="small">&nbsp;</div>
                </div>
            </div>

        </div>

        <form action="{{ route('manpower.laporan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-6">
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

                <div class="col-6">
                    <label class="form-label">Umur Ayam (minggu)</label>
                    <input type="number" name="umur_minggu" class="form-control"
                        value="{{ old('umur_minggu') }}" min="0" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Total Pakan (kg)</label>
                    <input type="number" step="0.01" name="total_pakan" class="form-control"
                        value="{{ old('total_pakan') }}" min="0" required>
                </div>

                <div class="col-6">
                    <label class="form-label">Mati (ekor)</label>
                    <input type="number" name="mati" class="form-control" value="{{ old('mati', 0) }}" min="0" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Afkir (ekor)</label>
                    <input type="number" name="afkir" class="form-control" value="{{ old('afkir', 0) }}" min="0" required>
                </div>

                <div class="col-6">
                    <label class="form-label">Telur Bagus (butir)</label>
                    <input type="number" name="produksi_telur" class="form-control"
                        value="{{ old('produksi_telur', 0) }}" min="0" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Telur Pecah/Reject (butir)</label>
                    <input type="number" name="telur_pecah" class="form-control"
                        value="{{ old('telur_pecah', 0) }}" min="0" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Catatan (opsional)</label>
                    <input type="text" name="column_10" class="form-control" value="{{ old('column_10') }}">
                </div>
            </div>

            <div class="d-grid mt-4">
                <button class="btn btn-success"><i class="bi bi-save me-1"></i>Simpan Laporan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const POPULASI = @js($populasiTerakhir);

    function angka(el) {
        return parseInt(el.value || 0, 10) || 0;
    }

    function updateInfo() {
        const kandangId = document.querySelector('[name="kandang_id"]').value;
        const data = POPULASI[kandangId] || null;

        const hidup = data ? data.sisa : 0;
        const mati  = angka(document.querySelector('[name="mati"]'));
        const afkir = angka(document.querySelector('[name="afkir"]'));

        document.getElementById('info-hidup').textContent =
            data ? hidup.toLocaleString('id-ID') : '-';
        document.getElementById('info-tanggal').textContent =
            data && data.tanggal ? data.tanggal : '-';
        document.getElementById('info-sisa').textContent =
            data ? Math.max(0, hidup - mati - afkir).toLocaleString('id-ID') : '-';
    }

    document.querySelector('[name="kandang_id"]').addEventListener('change', updateInfo);
    document.querySelector('[name="mati"]').addEventListener('input', updateInfo);
    document.querySelector('[name="afkir"]').addEventListener('input', updateInfo);
    updateInfo();
</script>
@endsection
