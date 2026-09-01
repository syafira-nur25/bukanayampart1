@extends('layouts.manpower')

@section('title', 'Input Laporan Harian')

@section('content')
<style>
html { scroll-behavior: smooth; }
main.container { max-width: 1140px !important; }

/* ===== STEPPER ===== */
.mp-stepper { background:#fff; border:1px solid #e6dacc; border-radius:14px; padding:8px 14px; display:flex; align-items:center; gap:6px; overflow-x:auto; margin-bottom:18px; }
.mp-step { display:flex; align-items:center; gap:8px; color:#8a7a6e; font-size:12.5px; font-weight:600; white-space:nowrap; text-decoration:none; padding:8px 12px; border-radius:999px; transition:.2s; }
.mp-step .dot { width:22px; height:22px; border-radius:50%; border:2px solid #d8c9b8; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; }
.mp-step:hover { color:#5d4037; }
.mp-step.active { color:#5d4037; background:#f3ede4; }
.mp-step.active .dot { background:#6d4c41; border-color:#6d4c41; color:#fff; }
.mp-step.done .dot { background:#e8d5bd; border-color:#e8d5bd; color:#5d4037; }
.mp-line { flex:0 0 22px; height:2px; background:#e6dacc; border-radius:2px; }

/* ===== CARD & INPUT ===== */
.mp-card { background:#fff; border:1px solid #e6dacc; border-radius:14px; padding:20px; margin-bottom:16px; scroll-margin-top:90px; }
.mp-card h6 { font-size:13px; font-weight:700; color:#5d4037; margin-bottom:14px; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.mp-card h6 .num { width:20px; height:20px; border-radius:6px; background:#f3ede4; display:flex; align-items:center; justify-content:center; font-size:11px; }
.mp-label { display:block; font-size:12px; font-weight:600; color:#6b5b4e; margin-bottom:6px; }
.mp-input, .mp-select { width:100%; background:#f6f3ec; border:1px solid #e6dacc; border-radius:10px; padding:10px 12px; font-size:13.5px; color:#33261f; transition:.15s; }
.mp-input:focus, .mp-select:focus { outline:none; border-color:#6d4c41; background:#fff; box-shadow:0 0 0 3px rgba(109,76,65,.12); }
.mp-input[readonly] { background:#efe9df; color:#6b5b4e; }
.mp-hint { font-size:11px; color:#8a7a6e; margin-top:5px; }

/* ===== PANEL KANAN ===== */
.mp-side { background:#fff; border:1px solid #e6dacc; border-radius:14px; padding:18px; position:sticky; top:84px; }
.mp-side .grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px; }
.mp-stat { background:#f6f3ec; border-radius:10px; padding:10px 6px; text-align:center; }
.mp-stat .v { font-size:16px; font-weight:800; color:#5d4037; }
.mp-stat .l { font-size:10.5px; color:#8a7a6e; margin-top:2px; }
.mp-ket { font-size:12px; color:#6b5b4e; background:#f6f3ec; border-radius:10px; padding:10px; margin-bottom:14px; }
.btn-mp-submit { width:100%; border:none; border-radius:12px; padding:12px; background:linear-gradient(135deg,#6d4c41,#8d6e63); color:#fff; font-weight:700; font-size:14px; }
.btn-mp-submit:hover { filter:brightness(1.08); }
</style>

{{-- ===== STEPPER (visual saja, klik = scroll ke seksi) ===== --}}
<div class="mp-stepper">
    <a href="#sec-1" class="mp-step active" data-sec="1"><span class="dot">1</span> Identitas</a>
    <span class="mp-line"></span>
    <a href="#sec-2" class="mp-step" data-sec="2"><span class="dot">2</span> Populasi</a>
    <span class="mp-line"></span>
    <a href="#sec-3" class="mp-step" data-sec="3"><span class="dot">3</span> Pakan & Produksi</a>
    <span class="mp-line"></span>
    <a href="#sec-4" class="mp-step" data-sec="4"><span class="dot">4</span> Catatan</a>
</div>

<h5 class="mb-3" style="font-weight:800;">Isi Laporan Harian</h5>

<form action="{{ route('manpower.laporan.store') }}" method="POST">
@csrf
<div class="row g-4">
    {{-- ===== KOLOM KIRI: FORM ===== --}}
    <div class="col-lg-8">

        {{-- SECTION 1: IDENTITAS --}}
        <div class="mp-card" id="sec-1" data-sec="1">
            <h6><span class="num">1</span> Identitas Laporan</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="mp-label">Tanggal</label>
                    <input type="date" name="tanggal" class="mp-input"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="mp-label">Kandang</label>
                    <select name="kandang_id" class="mp-select" required>
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

        {{-- SECTION 2: POPULASI --}}
        <div class="mp-card" id="sec-2" data-sec="2">
            <h6><span class="num">2</span> Data Populasi
                <span class="badge" style="background:#f3ede4;color:#5d4037;">Dari data admin</span>
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="mp-label">Populasi Awal (ekor)</label>
                    <input type="number" name="hidup" id="input-hidup" class="mp-input"
                        value="{{ old('hidup', 0) }}" min="0" readonly required>
                    <div class="mp-hint" id="hint-hidup">Diambil otomatis dari data populasi admin.</div>
                </div>
                <div class="col-md-6">
                    <label class="mp-label">Umur Ayam (minggu) — otomatis</label>
                    <input type="number" name="umur_minggu" id="input-umur" class="mp-input"
                        value="{{ old('umur_minggu', 0) }}" min="0" readonly required>
                    <div class="mp-hint" id="hint-umur">Dihitung otomatis dari usia populasi admin.</div>
                </div>
                <div class="col-md-6">
                    <label class="mp-label">Mati (ekor)</label>
                    <input type="number" name="mati" class="mp-input"
                        value="{{ old('mati', 0) }}" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="mp-label">Afkir (ekor)</label>
                    <input type="number" name="afkir" class="mp-input"
                        value="{{ old('afkir', 0) }}" min="0" required>
                    <div class="mp-hint">Hanya dicatat, tidak mengurangi sisa.</div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: PAKAN & PRODUKSI --}}
        <div class="mp-card" id="sec-3" data-sec="3">
            <h6><span class="num">3</span> Pakan & Produksi Telur</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="mp-label">Total Pakan (kg)</label>
                    <input type="number" step="0.01" name="total_pakan" class="mp-input"
                        value="{{ old('total_pakan') }}" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="mp-label">Telur Bagus (butir)</label>
                    <input type="number" name="produksi_telur" id="telur-bagus" class="mp-input"
                        value="{{ old('produksi_telur', 0) }}" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="mp-label">Telur Pecah / Reject (butir)</label>
                    <input type="number" name="telur_pecah" id="telur-pecah" class="mp-input"
                        value="{{ old('telur_pecah', 0) }}" min="0" required>
                </div>
                <div class="col-12">
                    <label class="mp-label">Total Produksi (butir) — otomatis</label>
                    <input type="text" id="total-produksi" class="mp-input fw-bold"
                        readonly value="0 butir" style="color:#5d4037;">
                    <div class="mp-hint">= Telur Bagus + Telur Pecah (otomatis)</div>
                </div>
            </div>
        </div>

        {{-- SECTION 4: CATATAN --}}
        <div class="mp-card" id="sec-4" data-sec="4">
            <h6><span class="num">4</span> Catatan Tambahan (opsional)</h6>
            <input type="text" name="column_10" class="mp-input"
                value="{{ old('column_10') }}"
                placeholder="Misal: cuaca mendung, ada gangguan predator, dll.">
        </div>
    </div>

    {{-- ===== KOLOM KANAN: RINGKASAN + TOMBOL SIMPAN ===== --}}
    <div class="col-lg-4">
        <div class="mp-side">
            <div class="mp-label mb-2" style="font-size:12.5px;font-weight:700;">Ringkasan Populasi (admin)</div>
            <div class="grid">
                <div class="mp-stat"><div class="v" id="info-hidup">-</div><div class="l">Hidup (ekor)</div></div>
                <div class="mp-stat"><div class="v" id="info-sisa" style="color:#2e7d32;">-</div><div class="l">Perkiraan Sisa</div></div>
                <div class="mp-stat"><div class="v" id="info-usia">-</div><div class="l">Usia (minggu)</div></div>
                <div class="mp-stat"><div class="v" id="info-tanggal" style="font-size:12px;">-</div><div class="l">Data Per Tanggal</div></div>
            </div>
            <div class="mp-ket" id="info-keterangan">
                <i class="bi bi-info-circle me-1"></i> Silakan pilih kandang terlebih dahulu.
            </div>
            <button class="btn-mp-submit">
                <i class="bi bi-save me-1"></i> Simpan Laporan
            </button>
        </div>
    </div>
</div>
</form>

{{-- ===== SCRIPT LOGIKA (TIDAK DIUBAH) ===== --}}
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
        inputHidup.value    = data.sisa;
        inputHidup.readOnly = true;
        hintHidup.textContent = 'Otomatis dari data populasi admin (sisa: ' + data.sisa.toLocaleString('id-ID') + ' ekor).';
        const hariLalu   = hariAntara(data.tanggal_dasar, TODAY);
        const usiaHari   = (data.usia_dasar || 0) + hariLalu;
        const usiaMinggu = Math.floor(usiaHari / 7);
        inputUmur.value  = usiaMinggu;
        inputUmur.readOnly = true;
        hintUmur.textContent = 'Usia dasar ' + (data.usia_dasar || 0) + ' hari + ' + hariLalu + ' hari = ' + usiaHari + ' hari (' + usiaMinggu + ' minggu).';
        ket.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i>' +
            'Data populasi dari admin berhasil dimuat. Populasi & usia bersifat <strong>read-only</strong>.';
        document.getElementById('info-hidup').textContent   = data.sisa.toLocaleString('id-ID');
        document.getElementById('info-usia').textContent     = usiaMinggu;
        document.getElementById('info-tanggal').textContent  = data.tanggal;
    } else {
        inputHidup.readOnly = false;
        inputUmur.readOnly  = false;
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
document.querySelector('[name="kandang_id"]').addEventListener('change', updateInfo);
document.getElementById('input-hidup').addEventListener('input', updateInfo);
document.querySelector('[name="mati"]').addEventListener('input', updateInfo);
document.querySelector('[name="afkir"]').addEventListener('input', updateInfo);
document.getElementById('telur-bagus').addEventListener('input', hitungTotalProduksi);
document.getElementById('telur-pecah').addEventListener('input', hitungTotalProduksi);
updateInfo();
hitungTotalProduksi();

/* ===== Scrollspy stepper (visual saja) ===== */
(function () {
    const steps = document.querySelectorAll('.mp-step[data-sec]');
    const secs  = document.querySelectorAll('.mp-card[data-sec]');
    function onScroll() {
        let current = '1';
        secs.forEach(s => { if (s.getBoundingClientRect().top < 150) current = s.getAttribute('data-sec'); });
        steps.forEach(st => {
            const n = parseInt(st.getAttribute('data-sec'));
            st.classList.toggle('active', st.getAttribute('data-sec') === current);
            st.classList.toggle('done', n < parseInt(current));
        });
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
@endsection
