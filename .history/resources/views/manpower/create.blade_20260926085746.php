@extends('layouts.manpower')

@section('title', 'Input Laporan Harian')

@section('content')
<style>
.form-card {
background: #fff; border: 1px solid var(--border, #e6dacc); border-radius: 20px;
box-shadow: 0 12px 40px rgba(93,64,55,.12); overflow: hidden;
}
.stepper-panel {
background: var(--primary-soft, #f4ede6); padding: 28px 24px;
border-right: 1px solid var(--border, #e6dacc);
}
.stepper-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 22px; }
.stepper-brand .logo {
width: 38px; height: 38px; border-radius: 10px; background: #fff;
color: #6d4c41; display: flex; align-items: center; justify-content: center;
font-size: 18px; box-shadow: 0 2px 8px rgba(93,64,55,.15);
}
.stepper-title { font-size: 17px; font-weight: 800; }
.stepper { list-style: none; margin: 0; padding: 0; }
.step {
display: flex; align-items: center; gap: 12px; padding: 9px 0;
color: var(--muted, #8a7a6e); font-size: 13.5px; font-weight: 600;
position: relative; cursor: pointer; transition: .2s;
}
.step .dot {
width: 27px; height: 27px; border-radius: 50%;
border: 2px solid #d8c9b8; background: #fff; color: var(--muted, #8a7a6e);
display: flex; align-items: center; justify-content: center;
font-size: 12px; font-weight: 700; flex-shrink: 0; transition: .2s;
}
.step:not(:last-child)::before {
content: ''; position: absolute; left: 13px; top: 40px; bottom: -4px;
width: 2px; background: #e0d2c0;
}
.step.active { color: var(--text, #33261f); }
.step.active .dot, .step.done .dot { border-color: #6d4c41; background: #6d4c41; color: #fff; }
.pop-info { background: #fff; border: 1px solid var(--border, #e6dacc); border-radius: 14px; padding: 14px; margin-top: 22px; }
.pop-info .sec-title { margin-bottom: 10px; }
.form-panel { padding: 28px 26px; }
.sec-title {
font-size: 11px; font-weight: 700; letter-spacing: .8px;
text-transform: uppercase; color: var(--muted, #8a7a6e); margin-bottom: 14px;
}
.form-section { padding-bottom: 22px; margin-bottom: 22px; border-bottom: 1px dashed var(--border, #e6dacc); }
.form-section:last-of-type { border-bottom: 0; margin-bottom: 0; padding-bottom: 0; }
.form-panel .form-control, .form-panel .form-select {
background: #faf7f2; border: 1px solid var(--border, #e6dacc); border-radius: 10px;
}
.form-panel .form-control:focus, .form-panel .form-select:focus {
background: #fff; border-color: #6d4c41;
box-shadow: 0 0 0 3px rgba(109,76,65,.12);
}
/* ✅ TOMBOL SIMPAN — warna dikunci eksplisit, tidak mungkin putih kosong lagi */
.btn-pill {
border: none; border-radius: 999px; padding: 11px 28px;
background: #6d4c41; color: #fff; font-weight: 700; font-size: 14px;
box-shadow: 0 6px 16px rgba(93,64,55,.3); transition: .2s;
display: inline-flex; align-items: center; gap: 6px;
}
.btn-pill:hover { background: #5d4037; color: #fff; transform: translateY(-1px); }
@media (max-width: 767px) {
.stepper-panel { border-right: 0; border-bottom: 1px solid var(--border, #e6dacc); padding: 20px; }
.stepper { display: flex; gap: 4px; justify-content: space-between; }
.step { flex-direction: column; gap: 6px; font-size: 10.5px; text-align: center; padding: 0; }
.step:not(:last-child)::before { display: none; }
.pop-info { margin-top: 16px; }
.form-panel { padding: 20px; }
}
</style>

<div class="form-card">
<div class="row g-0">

{{-- ===== PANEL KIRI: STEPPER ===== --}}
<aside class="col-md-4 stepper-panel">
<div class="stepper-brand">
<div class="logo"><i class="bi bi-egg-fried"></i></div>
<div class="stepper-title">Laporan Harian</div>
</div>

<ol class="stepper" id="stepper">
<li class="step active" data-target="sec-1"><span class="dot">1</span> Identitas</li>
<li class="step" data-target="sec-2"><span class="dot">2</span> Populasi</li>
<li class="step" data-target="sec-3"><span class="dot">3</span> Pakan & Produksi</li>
<li class="step" data-target="sec-4"><span class="dot">4</span> Catatan</li>
</ol>

<div class="pop-info">
<div class="sec-title">Info Populasi (Admin)</div>
<div class="row text-center g-2">
<div class="col-3"><div class="fw-bold" id="info-hidup">-</div><div class="small text-muted">Hidup</div></div>
<div class="col-3"><div class="fw-bold text-success" id="info-sisa">-</div><div class="small text-muted">Sisa</div></div>
<div class="col-3"><div class="fw-bold" id="info-usia">-</div><div class="small text-muted">Minggu</div></div>
<div class="col-3"><div class="fw-bold small" id="info-tanggal">-</div><div class="small text-muted">Tgl Data</div></div>
</div>
<div class="small mt-2 mb-0" id="info-keterangan">
<i class="bi bi-info-circle me-1"></i> Silakan pilih kandang terlebih dahulu.
</div>
</div>
</aside>

{{-- ===== PANEL KANAN: FORM ===== --}}
<div class="col-md-8 form-panel">
<form action="{{ route('manpower.laporan.store') }}" method="POST">
@csrf

{{-- SECTION 1 --}}
<div class="form-section" id="sec-1">
<div class="sec-title">Identitas Laporan</div>
<div class="row g-3">
<div class="col-6">
<label class="form-label small">Tanggal</label>
<input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
</div>
<div class="col-6">
<label class="form-label small">Kandang</label>
<select name="kandang_id" class="form-select" required>
<option value="">-- Pilih Kandang --</option>
@foreach ($kandangs as $kandang)
<option value="{{ $kandang->id }}" @selected(old('kandang_id') == $kandang->id)>{{ $kandang->nama }}</option>
@endforeach
</select>
</div>
</div>
</div>

{{-- SECTION 2 --}}
<div class="form-section" id="sec-2">
<div class="sec-title">Data Populasi <span class="badge bg-secondary ms-1">Otomatis</span></div>
<div class="row g-3">
<div class="col-6">
<label class="form-label small">Populasi Awal (ekor)</label>
<input type="number" name="hidup" id="input-hidup" class="form-control" value="{{ old('hidup', 0) }}" min="0" readonly required>
<div class="form-text" id="hint-hidup">Diambil otomatis dari data populasi admin.</div>
</div>
<div class="col-6">
<label class="form-label small">Umur Ayam (minggu)</label>
<input type="number" name="umur_minggu" id="input-umur" class="form-control" value="{{ old('umur_minggu', 0) }}" min="0" readonly required>
<div class="form-text" id="hint-umur">Dihitung otomatis dari usia populasi admin.</div>
</div>
<div class="col-6">
<label class="form-label small">Mati (ekor)</label>
<input type="number" name="mati" class="form-control" value="{{ old('mati', 0) }}" min="0" required>
</div>
<div class="col-6">
<label class="form-label small">Afkir (ekor)</label>
<input type="number" name="afkir" class="form-control" value="{{ old('afkir', 0) }}" min="0" required>
<div class="form-text text-muted">Hanya dicatat, tidak mengurangi sisa.</div>
</div>
</div>
</div>

{{-- SECTION 3 --}}
<div class="form-section" id="sec-3">
<div class="sec-title">Pakan & Produksi Telur</div>
<div class="row g-3">
<div class="col-12">
<label class="form-label small">Total Pakan (kg)</label>
<input type="number" step="0.01" name="total_pakan" class="form-control" value="{{ old('total_pakan') }}" min="0" required>
</div>
<div class="col-6">
<label class="form-label small">Telur Bagus (butir)</label>
<input type="number" name="produksi_telur" id="telur-bagus" class="form-control" value="{{ old('produksi_telur', 0) }}" min="0" required>
</div>
<div class="col-6">
<label class="form-label small">Telur Pecah / Reject (butir)</label>
<input type="number" name="telur_pecah" id="telur-pecah" class="form-control" value="{{ old('telur_pecah', 0) }}" min="0" required>
</div>
<div class="col-12">
<label class="form-label small">Total Produksi (butir) — otomatis</label>
<input type="text" id="total-produksi" class="form-control fw-bold text-success" readonly value="0 butir">
</div>
</div>
</div>

{{-- SECTION 4 --}}
<div class="form-section" id="sec-4">
<div class="sec-title">Catatan Tambahan (opsional)</div>
<input type="text" name="column_10" class="form-control" value="{{ old('column_10') }}" placeholder="Misal: cuaca mendung, ada gangguan predator, dll.">
</div>

<div class="d-flex justify-content-end mt-4">
<button type="submit" class="btn-pill">
Simpan Laporan <i class="bi bi-arrow-right"></i>
</button>
</div>
</form>
</div>

</div>
</div>

<script>
const POPULASI = @js($populasiTerakhir);
const TODAY    = @js($today);

function angka(el) { return parseInt(el.value || 0, 10) || 0; }
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
inputHidup.value = data.sisa; inputHidup.readOnly = true;
hintHidup.textContent = 'Otomatis dari data populasi admin (sisa: ' + data.sisa.toLocaleString('id-ID') + ' ekor).';
const hariLalu   = hariAntara(data.tanggal_dasar, TODAY);
const usiaHari   = (data.usia_dasar || 0) + hariLalu;
const usiaMinggu = Math.floor(usiaHari / 7);
inputUmur.value = usiaMinggu; inputUmur.readOnly = true;
hintUmur.textContent = 'Usia dasar ' + (data.usia_dasar || 0) + ' hari + ' + hariLalu + ' hari = ' + usiaHari + ' hari.';
ket.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i>Data populasi dimuat. Populasi & usia read-only.';
document.getElementById('info-hidup').textContent  = data.sisa.toLocaleString('id-ID');
document.getElementById('info-sisa').textContent   = data.sisa.toLocaleString('id-ID');
document.getElementById('info-usia').textContent   = usiaMinggu;
document.getElementById('info-tanggal').textContent = data.tanggal;
} else {
inputHidup.readOnly = false; inputUmur.readOnly = false; inputUmur.value = 0;
if (kandangId) {
hintHidup.textContent = 'Admin belum input populasi untuk kandang ini — isi manual.';
hintUmur.textContent  = 'Admin belum input populasi — isi umur (minggu) manual.';
ket.innerHTML = '<i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>Belum ada data populasi dari admin.';
} else {
hintHidup.textContent = 'Diambil otomatis dari data populasi admin.';
hintUmur.textContent  = 'Dihitung otomatis dari usia populasi admin.';
ket.innerHTML = '<i class="bi bi-info-circle me-1"></i> Silakan pilih kandang terlebih dahulu.';
}
document.getElementById('info-hidup').textContent  = '-';
document.getElementById('info-sisa').textContent   = '-';
document.getElementById('info-usia').textContent   = '-';
document.getElementById('info-tanggal').textContent = '-';
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

/* Stepper: klik = scroll, aktif mengikuti scroll */
(function () {
const steps = document.querySelectorAll('#stepper .step');
const secs  = Array.from(steps).map(s => document.getElementById(s.dataset.target));
steps.forEach((s, i) => {
s.addEventListener('click', () => {
if (secs[i]) secs[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
});
});
function onScroll() {
let current = 0;
secs.forEach((sec, i) => {
if (sec && sec.getBoundingClientRect().top < window.innerHeight * 0.45) current = i;
});
steps.forEach((s, i) => {
s.classList.toggle('active', i === current);
s.classList.toggle('done', i < current);
s.querySelector('.dot').textContent = i < current ? '✓' : (i + 1);
});
}
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();
})();
</script>
@endsection
