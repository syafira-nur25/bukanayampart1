<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PakanKandang extends Model
{
    const ZAK_KE_KG = 50; // 1 zak = 50 kg

    protected $table = 'pakan_kandang';

    protected $fillable = ['tanggal', 'id_kandang', 'total_masuk', 'keluar'];

    protected $casts = [
        'tanggal'     => 'date',
        'total_masuk' => 'decimal:2',
        'keluar'      => 'decimal:2',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'id_kandang');
    }

    public function scopeMasuk($q)  { return $q->whereNull('id_kandang'); }
    public function scopeKeluar($q) { return $q->whereNotNull('id_kandang'); }

    /** Stok gudang saat ini (kg) = semua masuk − semua keluar */
    public static function stokKg(): float
    {
        $masuk  = (float) static::masuk()->sum('total_masuk') * self::ZAK_KE_KG;
        $keluar = (float) static::keluar()->sum('keluar');
        return $masuk - $keluar;
    }
}
