<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GudangTelur extends Model
{
    const BUTIR_PER_PIRING = 30;
    const PIRING_PER_IKAT  = 5;
    const BUTIR_PER_IKAT   = self::BUTIR_PER_PIRING * self::PIRING_PER_IKAT;

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

    public function stokMasukManual(): HasMany
    {
        return $this->hasMany(StokMasukTelur::class, 'gudang_id');
    }

    /** Masuk = dari PRODUKSI + dari STOK MANUAL */
    public function totalMasuk(): int
    {
        return (int) $this->produksiTelur()->sum('jumlah_produksi')
             + (int) $this->stokMasukManual()->sum('jumlah');
    }

    public function totalKeluarButir(): int
    {
        return (int) $this->penjualanTelur()->sum('jumlah') * self::BUTIR_PER_IKAT;
    }

    public function totalReturn(): int
    {
        return (int) $this->returnTelur()->sum('jumlah');
    }

    public function stokButir(): int
    {
        return $this->totalMasuk() - $this->totalKeluarButir() - $this->totalReturn();
    }
}
