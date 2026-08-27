@extends('layouts.manpower')

@section('title', 'Input Laporan Harian')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1">Laporan Harian</h5>
        <p class="text-muted small mb-3">
            Data populasi diambil <strong>otomatis dari input admin</strong>.
            Anda cukup mengisi data harian (mati, afkir, pakan, telur).
        </p>

        <!-- PANEL INFO POPULASI ADMIN -->
        <div class="alert alert-info py-3 mb-4">
            <div class="row text-center g-2">
                <div class="col-3">
                    <div class="small text-muted">Populasi (admin)</div>
                    <div class="fs-4 fw-bold" id="info-hidup">-</div>
                    <div class="small">ekor</div>
                </div>
                <div class="col-3">
                    <div class="small text-muted">Perkiraan Sisa</div>
                    <div class="fs-4 fw-bold text-success" id="info-sisa">-</div>
                    <div class="small">ekor</div>
                </div>
                <div class="col-3">
                    <div class="small text-muted">Usia</div>
                    <div class="fs-4 fw-bold" id="info-usia">-</div>
                    <div class="small">minggu</div>
                </div>
                <div class="col-3">
                    <div class="small text-muted">Data Per Tanggal</div>
                    <div class="fw-bold" id="info-tanggal">-</div>
                    <div class="small">&nbsp;</div>
                </div>
            </div>
            <div class="small mt-2 mb-0" id="info-keterangan">
                <i class="bi bi-info-circle me-1"></i> Silakan pilih kandang terlebih dahulu.
            </div>
        </div>

        <form action="{{ route('manpower.laporan.store') }}" method="POST">
            @csrf

            {{-- ===== SECTION 1: IDENTITAS ===== --}}
            <div class="border-bottom pb-3 mb-3">
                <div class="small fw-bold text-muted mb-2">
                    <i class="bi bi-1-circle-fill me-1"></i> Identitas Laporan
                </div>
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
                </div>
            </div>

            {{-- ===== SECTION 2: POPULASI ===== --}}
            <div class="border-bottom pb-3 mb-3">
                <div class="small fw-bold text-muted mb-2">
                    <i class="bi bi-2-circle-fill me-1"></i> Data Populasi
                    <span class="badge bg-secondary ms-1">Dari data admin</span>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Populasi Awal (ekor)</label>
                        <input type="number" name="hidup" id="input-hidup" class="form-control bg-light"
                            value="{{ old('hidup', 0) }}" min="0" readonly required>
                        <div class="form-text" id="hint-hidup">
                            Diambil otomatis dari data populasi admin.
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">
                            Umur Ayam (minggu)
                            <span class="badge bg-secondary ms-1">Otomatis</span>
                        </label>
                        <input type="number" name="umur_minggu" id="input-umur" class="form-control bg-light"
                            value="{{ old('umur_minggu', 0) }}" min="0" readonly required>
                        <div class="form-text" id="hint-umur">
                            Dihitung otomatis dari usia populasi admin.
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Mati (ekor)</label>
                        <input type="number" name="mati" class="form-control"
                            value="{{ old('mati', 0) }}" min="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Afkir (ekor)</label>
                        <input type="number" name="afkir" class="form-control"
                            value="{{ old('afkir', 0) }}" min="0" required>
                        <div class="form-text text-muted">Hanya dicatat, tidak mengurangi sisa.</div>
                    </div>
                </div>
            </div>

            {{-- ===== SECTION 3: PAKAN & PRODUKSI ===== --}}
            <div class="border-bottom pb-3 mb-3">
                <div class="small fw-bold text-muted mb-2">
                    <i class="bi bi-3-circle-fill me-1"></i> Pakan & Produksi Telur
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Total Pakan (kg)</label>
                        <input type="number" step="0.01" name="total_pakan" class="form-control"
                            value="{{ old('total_pakan') }}" min="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Telur Bagus (butir)</label>
                        <input type="number" name="produksi_telur" id="telur-bagus" class="form-control"
                            value="{{ old('produksi_telur', 0) }}" min="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Telur Pecah / Reject (butir)</label>
                        <input type="number" name="telur_pecah" id="telur-pecah" class="form-control"
                            value="{{ old('telur_pecah', 0) }}" min="0" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">
                            Total Produksi (butir)
                            <span class="badge bg-secondary ms-1">Otomatis</span>
                        </label>
                        <input type="text" id="total-produksi" class="form-control bg-light fw-bold text-success"
                            readonly value="0 butir">
                        <div class="form-text">= Telur Bagus + Telur Pecah (otomatis)</div>
                    </div>
                </div>
            </div>

            {{-- ===== SECTION 4: CATATAN ===== --}}
            <div class="pb-3 mb-3">
                <div class="small fw-bold text-muted mb-2">
                    <i class="bi bi-4-circle-fill me-1"></i> Catatan Tambahan (opsional)
                </div>
                <input type="text" name="column_10" class="form-control"
                    value="{{ old('column_10') }}"
                    placeholder="Misal: cuaca mendung, ada gangguan predator, dll.">
            </div>

            <div class="d-grid mt-4">
                <button class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const POPULASI = @js($populasiTerakhir);
const TODAY    = @js($today);

function angka(el) {
    return parseInt(el.value || 0, 10) || 0;
}

function hariAntara(t1, t2) {
    if (!t1 || !t2) return 0;
    return Math.max(0, Math.round((new Date(t2) - new Date(t1)) / 86400000));
}

function updateInfo() {
    const kandangId  = document.querySelector('[name="kandang_id"]').value;
    const data       = POPULASI[kandangId] || null;
    const inputHidup = document.getElementById('input-hidup');
    const inputUmur  = document.getElementById('input-umur');
    const hintHidup  = document.getElementById('hint-hidup');
    const hintUmur   = document.getElementById('hint-umur');
    const ket        = document.getElementById('info-keterangan');

    if (data) {
        // ✅ Populasi awal = sisa dari data admin
        inputHidup.value    = data.sisa;
        inputHidup.readOnly = true;
        inputHidup.classList.add('bg-light', 'text-muted');
        hintHidup.textContent = 'Otomatis dari data populasi admin (sisa: ' + data.sisa.toLocaleString('id-ID') + ' ekor).';

        // ✅ Usia otomatis (minggu) dari data admin
        const hariLalu   = hariAntara(data.tanggal_dasar, TODAY);
        const usiaHari   = (data.usia_dasar || 0) + hariLalu;
        const usiaMinggu = Math.floor(usiaHari / 7);
        inputUmur.value  = usiaMinggu;
        inputUmur.readOnly = true;
        inputUmur.classList.add('bg-light', 'text-muted');
        hintUmur.textContent = 'Usia dasar ' + (data.usia_dasar || 0) + ' hari + ' + hariLalu + ' hari = ' + usiaHari + ' hari (' + usiaMinggu + ' minggu).';

        ket.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i>' +
            'Data populasi dari admin berhasil dimuat. Populasi & usia bersifat <strong>read-only</strong>.';

        // Info panel
        document.getElementById('info-hidup').textContent   = data.sisa.toLocaleString('id-ID');
        document.getElementById('info-usia').textContent     = usiaMinggu;
        document.getElementById('info-tanggal').textContent  = data.tanggal;

    } else {
        // Belum ada data admin → input manual
        inputHidup.readOnly = false;
        inputHidup.classList.remove('bg-light', 'text-muted');
        inputUmur.readOnly  = false;
        inputUmur.classList.remove('bg-light', 'text-muted');
        inputUmur.value = 0;

        if (kandangId) {
            hintHidup.textContent = 'Admin belum input populasi untuk kandang ini — isi manual.';
            hintUmur.textContent  = 'Admin belum input populasi — isi umur (minggu) manual.';
            ket.innerHTML = '<i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>' +
                'Belum ada data populasi dari admin untuk kandang ini. Hubungi admin atau isi manual.';
        } else {
            hintHidup.textContent = 'Diambil otomatis dari data populasi admin.';
            hintUmur.textContent  = 'Dihitung otomatis dari usia populasi admin.';
            ket.innerHTML = '<i class="bi bi-info-circle me-1"></i> Silakan pilih kandang terlebih dahulu.';
        }

        document.getElementById('info-hidup').textContent   = '-';
        document.getElementById('info-usia').textContent     = '-';
        document.getElementById('info-tanggal').textContent  = '-';
    }

    // Hitung perkiraan sisa
    const hidup = angka(inputHidup);
    const mati  = angka(document.querySelector('[name="mati"]'));
    document.getElementById('info-sisa').textContent =
        kandangId ? Math.max(0, hidup - mati).toLocaleString('id-ID') : '-';
}

function hitungTotalProduksi() {
    const bagus = angka(document.getElementById('telur-bagus'));
    const pecah = angka(document.getElementById('telur-pecah'));
    document.getElementById('total-produksi').value =
        (bagus + pecah).toLocaleString('id-ID') + ' butir';
}

// Event listeners
document.querySelector('[name="kandang_id"]').addEventListener('change', updateInfo);
document.getElementById('input-hidup').addEventListener('input', updateInfo);
document.querySelector('[name="mati"]').addEventListener('input', updateInfo);
document.querySelector('[name="afkir"]').addEventListener('input', updateInfo);
document.getElementById('telur-bagus').addEventListener('input', hitungTotalProduksi);
document.getElementById('telur-pecah').addEventListener('input', hitungTotalProduksi);

// Init
updateInfo();
hitungTotalProduksi();
</script>
@endsection
