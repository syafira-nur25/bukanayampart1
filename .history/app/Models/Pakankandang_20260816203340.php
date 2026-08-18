<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PakanKandang extends Model
{
    const ZAK_KE_KG = 50; // 1 zak = 50 kg

    protected $table = 'pakan_kandang';

    protected $fillable = [
        'tanggal',
        'total_masuk', // dalam ZAK
        'kandang_id',  // NULL = pakan masuk gudang
        'keluar',      // dalam KG
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'total_masuk' => 'decimal:2',
        'keluar'      => 'decimal:2',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function scopeMasuk($query)
    {
        return $query->whereNull('kandang_id');
    }

    public function scopeKeluar($query)
    {
        return $query->whereNotNull('kandang_id');
    }

    /** Kontribusi baris ini terhadap stok gudang (kg) */
    public function kontribusiKg(): float
    {
        return ((float) $this->total_masuk * self::ZAK_KE_KG) - (float) $this->keluar;
    }

    /** Stok gudang saat ini (kg) */
    public static function stokKg(): float
    {
        $masuk  = (float) static::masuk()->sum('total_masuk') * self::ZAK_KE_KG;
        $keluar = (float) static::keluar()->sum('keluar');

        return $masuk - $keluar;
    }
}
