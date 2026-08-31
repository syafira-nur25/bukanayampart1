<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GudangTelur extends Model
{
    /** 1 piring = 30 butir */
    const BUTIR_PER_PIRING = 30;

    /** 1 ikat = 5 piring */
    const PIRING_PER_IKAT = 5;

    /** 1 ikat = 150 butir (30 × 5) */
    const BUTIR_PER_IKAT = self::BUTIR_PER_PIRING * self::PIRING_PER_IKAT;

    protected $table = 'gudang_telur';
    protected $fillable = ['nama', 'lokasi'];

    public function produksiTelur(): HasMany
    {
        return $this->hasMany(ProduksiTelur::class, 'gudang_id');
    }

    public function penjualanTelur(): HasMany
    {
        return $this->hasMany(PenjualanTelur::class, 'gudang_id');
    }

    public function returnTelur(): HasMany
    {
        return $this->hasMany(ReturnTelur::class, 'gudang_id');
    }

    /** Total telur masuk dari produksi (butir) */
    public function totalMasuk(): int
    {
        return (int) $this->produksiTelur()->sum('jumlah_produksi');
    }

    /** Total telur keluar karena penjualan (ikat → butir) */
    public function totalKeluarButir(): int
    {
        return (int) $this->penjualanTelur()->sum('jumlah') * self::BUTIR_PER_IKAT;
    }

    /** Total telur yang di-return (butir) */
    public function totalReturn(): int
    {
        return (int) $this->returnTelur()->sum('jumlah');
    }

    /** Stok akhir gudang (butir) = masuk − keluar − return */
    public function stokButir(): int
    {
        return $this->totalMasuk() - $this->totalKeluarButir() - $this->totalReturn();
    }
}
