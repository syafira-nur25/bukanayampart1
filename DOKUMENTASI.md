# 📘 DOKUMENTASI PENGEMBANG — APLIKASI "BUKANAYAM"
> Sistem Manajemen Peternakan Ayam — Desa Tanjung Agung
> Dokumen ini untuk developer yang ingin memodifikasi aplikasi. Bacalah bagian
> **"PETA MODIFIKASI"** sebelum mengubah kode apa pun.

---

## 1. RINGKASAN PROYEK

| Item | Keterangan |
|---|---|
| Nama aplikasi | BukanAyam — Sistem Manajemen Peternakan Ayam |
| Framework | Laravel (struktur Laravel 11/12, auth bawaan Breeze) |
| UI | Blade + Bootstrap 5 (CDN) + Bootstrap Icons + Chart.js (CDN) |
| Database | MySQL (XAMPP) |
| Role user | `admin` (akses penuh) dan `manpower` (input laporan harian) |
| Bahasa | PHP 8+, Blade, JavaScript vanilla |

⚠️ **Catatan penting:** Tailwind HANYA dipakai komponen bawaan Breeze
(`resources/views/components/*`, halaman profile). Seluruh halaman aplikasi
pakai **Bootstrap 5 via CDN**. JANGAN mencampur keduanya di view aplikasi.

---

## 2. CARA MENJALANKAN PROYEK

```bash
composer install
cp .env.example .env
php artisan key:generate
# sesuaikan DB_DATABASE / DB_USERNAME / DB_PASSWORD di .env
php artisan migrate
php artisan serve
```

**Membuat akun admin pertama** (role default saat register = `manpower`):
```sql
UPDATE users SET role = 'admin' WHERE email = 'email_anda@domain.com';
```

Perintah perawatan setelah mengubah kode:
```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

---

## 3. STRUKTUR FOLDER & FILE PENTING

```
app/
├─ Http/
│  ├─ Controllers/
│  │  ├─ DashboardController.php        → dashboard + 3 grafik (filter per grafik)
│  │  ├─ KandangController.php          → CRUD kandang
│  │  ├─ PopulasiController.php         → CRUD populasi (grup per bulan)
│  │  ├─ ProduksiTelurController.php    → CRUD produksi + HDP
│  │  ├─ PenjualanTelurController.php   → CRUD penjualan (ikat → Rp)
│  │  ├─ PakanKandangController.php     → stok pakan + laporan pakan + export
│  │  ├─ PemberianPakanController.php   → CRUD pemberian pakan
│  │  ├─ BobotAyamController.php        → CRUD bobot (multi sampel)
│  │  ├─ ArusKasController.php          → kas manual + otomatis dari penjualan
│  │  ├─ GudangTelurController.php      → CRUD gudang telur
│  │  ├─ StokTelurController.php        → stok gudang, stok manual, return
│  │  ├─ Manpower/LaporanHarianController.php → laporan harian manpower
│  │  └─ Auth/*                         → auth bawaan Breeze
│  ├─ Middleware/RoleMiddleware.php     → alias middleware `role:admin|manpower`
│  └─ Requests/                        → form request Breeze
├─ Models/                             → lihat bagian 5
└─ Providers/AppServiceProvider.php

resources/views/
├─ layouts/
│  ├─ app.blade.php        → LAYOUT ADMIN (sidebar, topbar, drawer laporan) ⭐
│  ├─ manpower.blade.php   → layout halaman manpower
│  ├─ guest.blade.php      → layout halaman auth
│  └─ navigation.blade.php → nav Breeze (jarang dipakai)
├─ landing.blade.php       → landing page publik ⭐
├─ dashboard.blade.php     → dashboard + Chart.js ⭐
├─ partials/cursor-animation.blade.php → animasi kursor ayam (opsional)
├─ kandang/, populasi/, produksi_telur/, penjualan_telur/,
   pakan_kandang/, pemberian_pakan/, bobot/, arus_kas/,
   gudang_telur/, stok_telur/, admin/laporan/, manpower/, auth/, profile/

routes/
├─ web.php      → SEMUA route aplikasi ⭐
└─ auth.php     → route auth Breeze
```

---

## 4. ROLE & HAK AKSES

| Role | Akses |
|---|---|
| `admin` | Semua route dalam grup `role:admin` di `routes/web.php` |
| `manpower` | Hanya `manpower.laporan.create` & `manpower.laporan.store` |

- Pengecekan role: `app/Http/Middleware/RoleMiddleware.php`
  (terdaftar sebagai alias `role` di `bootstrap/app.php`).
- Redirect setelah login: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
  (admin → dashboard, manpower → form laporan).

---

## 5. DATABASE & RELASI

| Tabel | Kolom penting | Relasi |
|---|---|---|
| `users` | name, email, password, **role** | — |
| `kandang` | nama, lokasi | hasMany populasi/produksi/pakan/laporan |
| `populasi` | tanggal, hidup, mati, afkir, **sisa**, **usia(hari)**, kandang_id | belongsTo kandang |
| `produksi_telur` | tanggal, kandang_id, populasi_id, gudang_id, jumlah_produksi, telur_bagus, telur_reject, presentase, sisa_ayam | belongsTo kandang/populasi/gudang |
| `penjualan_telur` | tanggal, customer, jumlah(**ikat**), harga, total, produksi_id, gudang_id | belongsTo produksi/gudang |
| `pakan_kandang` | tanggal, total_masuk(**zak**), keluar(**kg**), kandang_id (null = masuk gudang) | belongsTo kandang |
| `pemberian_pakan` | bulan, populasi_id, gr, kg, total, jenis_pakan, harga, pengeluaran | belongsTo populasi |
| `bobot_ayam` | kandang_id, tanggal, bobot(gram) — boleh multi sampel | belongsTo kandang |
| `arus_kas` | tanggal, keterangan, nomor_bukti, penerimaan, pengeluaran | — |
| `laporan_harian` | tanggal, kandang_id, user_id, umur_minggu, hidup, mati, afkir, sisa_ayam, total_pakan, produksi_telur, telur_pecah, column_10 | belongsTo kandang/user |
| `gudang_telur` | nama, lokasi | hasMany produksi/penjualan/return/stok_masuk |
| `return_telur` | tanggal, gudang_id, jumlah, alasan, keterangan | belongsTo gudang |
| `stok_masuk_telur` | tanggal, gudang_id, jumlah, keterangan | belongsTo gudang |

---

## 6. ⚙️ KONSTANTA & ATURAN BISNIS (PALING PENTING)

> Ubah HANYA di file yang disebut. Semua perhitungan lain mengikuti.

| Aturan / Konstanta | Nilai | File lokasi |
|---|---|---|
| 1 zak pakan = … kg | `ZAK_KE_KG = 50` | `app/Models/PakanKandang.php` |
| 1 piring telur = … butir | `BUTIR_PER_PIRING = 30` | `app/Models/GudangTelur.php` |
| 1 ikat = … piring | `PIRING_PER_IKAT = 5` | `app/Models/GudangTelur.php` |
| 1 ikat = … butir (otomatis) | `BUTIR_PER_IKAT = 150` | `app/Models/GudangTelur.php` |
| **Sisa ayam = hidup − mati** (afkir TIDAK mengurangi) | — | `PopulasiController@store/@update` & `Manpower/LaporanHarianController@store` |
| Usia disimpan dalam **hari** (= minggu × 7) | — | `PopulasiController@store/@update` |
| HDP % = produksi ÷ populasi × 100 | — | `ProduksiTelurController@store/@update` |
| Stok gudang = (produksi + masuk manual) − (jual × BUTIR_PER_IKAT) − return | — | `GudangTelur@stokButir()` & `StokTelurController` |
| Stok pakan kg = (masuk zak × 50) − keluar kg | — | `PakanKandang@stokKg()` |
| Kas otomatis dari penjualan | — | `ArusKasController@buildRows()` |
| Laporan manpower TIDAK mengubah tabel populasi | — | `Manpower/LaporanHarianController@store` |

---

## 7. PETA ROUTE (ringkas)

- `GET /` → landing publik (`landing.blade.php`)
- Grup `auth + role:admin`: `/dashboard`, resource `kandang`, `populasi`,
  `bobot`, `produksi-telur`, `penjualan-telur`, `pemberian-pakan`,
  `pakan-kandang`, `arus-kas`, `gudang-telur`, plus:
  `/stok-telur`, `/stok-telur/stok`, `/stok-telur/return`,
  `/laporan-pakan`, `/laporan-pakan/export`, `/arus-kas/export`, `/admin/laporan`
- Grup `auth + role:manpower`: `/manpower/laporan` (GET/POST)
- Route auth (login/register/reset): `routes/auth.php`

⚠️ Route custom (mis. `/export`) WAJIB didefinisikan **sebelum**
`Route::resource()` agar tidak tertangkap parameter `{resource}`.

---

## 8. 🗺️ PETA MODIFIKASI — "MAU UBAH APA → BUKA FILE MANA"

| Ingin mengubah… | Buka file |
|---|---|
| Nama aplikasi / tagline | `layouts/app.blade.php` (brand-title), `layouts/manpower.blade.php`, `landing.blade.php`, tag `<title>` |
| Logo | `public/logo.png` (landing) & `.brand-icon` di layout |
| Warna tema | Variabel `:root` di `layouts/app.blade.php`, `layouts/manpower.blade.php`, `layouts/guest.blade.php`, `landing.blade.php` |
| Menu sidebar admin | `layouts/app.blade.php` blok `.sidebar-content` |
| Drawer "Laporan Harian Terbaru" | `layouts/app.blade.php` blok `#laporanDrawer` |
| Animasi kursor ayam | Hapus/baris `@include('partials.cursor-animation')` di layout |
| Grafik dashboard | `DashboardController.php` + `dashboard.blade.php` |
| Filter bulan grafik | `DashboardController` (`pilihBulan`, opsi `all`) + select di `dashboard.blade.php` |
| Aturan sisa/usia/HDP | Lihat tabel bagian 6 |
| Konversi zak/ikat | `app/Models/PakanKandang.php`, `app/Models/GudangTelur.php` |
| Halaman login | `resources/views/auth/login.blade.php` |
| Landing page | `resources/views/landing.blade.php` |
| Form input manpower | `resources/views/manpower/create.blade.php` |
| Rekap laporan admin | `resources/views/admin/laporan/index.blade.php` |
| Tambah role baru | `RoleMiddleware.php` + grup route di `web.php` + kolom `users.role` |

---

## 9. PANDUAN MENAMBAH MODUL BARU (contoh: "Penjualan Ayam")

1. **Migration**
   ```bash
   php artisan make:migration create_penjualan_ayam_table
   ```
2. **Model**
   ```bash
   php artisan make:model PenjualanAyam
   ```
   Isi `$fillable` + relasi `belongsTo(Kandang::class)` dll.
3. **Controller resource**
   ```bash
   php artisan make:controller PenjualanAyamController --resource
   ```
4. **Route** — tambahkan DI DALAM grup admin `routes/web.php`:
   ```php
   Route::resource('penjualan-ayam', PenjualanAyamController::class);
   ```
5. **Views** — buat folder `resources/views/penjualan_ayam/` berisi
   `index.blade.php`, `create.blade.php`, `edit.blade.php` dengan
   `@extends('layouts.app')`.
6. **Menu sidebar** — tambah di `layouts/app.blade.php`:
   ```blade
   <a href="{{ route('penjualan-ayam.index') }}"
      class="menu-link {{ request()->is('penjualan-ayam*') ? 'active' : '' }}">
       <i class="bi bi-cart-check-fill"></i><span class="menu-label">Penjualan Ayam</span>
   </a>
   ```
7. Jalankan `php artisan migrate` lalu `php artisan route:clear`.

---

## 10. KONVENSI KODE

- View pakai **Bootstrap 5 CDN** + `bootstrap-icons`; JS tambahan masuk
  `@push('scripts')`.
- Controller pakai pola **resource**; validasi via `$request->validate([...])`.
- Pesan sukses lewat `->with('success', ...)` — ditampilkan otomatis oleh layout.
- Format angka: `number_format()`; format rupiah: `number_format($x, 0, ',', '.')`.
- Tanggal disimpan `date`, di-cast `date` di model, tampil `format('d-m-Y')`.
- Jangan edit migration lama — buat migration baru (`php artisan make:migration`).

---

## 11. TROUBLESHOOTING CEPAT

| Gejala | Solusi |
|---|---|
| `Route [...] not defined` | Cek `routes/web.php`, lalu `php artisan route:clear` |
| `Column not found` | Ada migration belum jalan → `php artisan migrate` |
| View tidak berubah | `php artisan view:clear` |
| 403 saat akses halaman admin | Role user bukan `admin` → update kolom `users.role` |
| Grafik tidak muncul | Cek CDN Chart.js & `@push('scripts')` di view |

---

*Dokumen ini bagian dari proyek BukanAyam. Perbarui dokumen ini setiap kali
menambah/mengubah modul agar developer lain tidak bingung.*
