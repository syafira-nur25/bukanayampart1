<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GudangTelur extends Model
{
    const BUTIR_PER_IKAT = 30; // 1 ikat = 30 butir (ubah di sini jika beda)

    protected $table = 'gudang_telur';
    protected $fillable = ['nama', 'lokasi'];

    public function produksiTelur(): HasMany  { return $this->hasMany(ProduksiTelur::class, 'gudang_id'); }
    public function penjualanTelur(): HasMany { return $this->hasMany(PenjualanTelur::class, 'gudang_id'); }
    public function returnTelur(): HasMany    { return $this->hasMany(ReturnTelur::class, 'gudang_id'); }

    public function totalMasuk(): int     { return (int) $this->produksiTelur()->sum('jumlah_produksi'); }
    public function totalKeluarButir(): int { return (int) $this->penjualanTelur()->sum('jumlah') * self::BUTIR_PER_IKAT; }
    public function totalReturn(): int    { return (int) $this->returnTelur()->sum('jumlah'); }
    public function stokButir(): int      { return $this->totalMasuk() - $this->totalKeluarButir() - $this->totalReturn(); }
}
