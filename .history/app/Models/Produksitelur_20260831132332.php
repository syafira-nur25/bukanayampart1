<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProduksiTelur extends Model
{
    protected $table = 'produksi_telur';

    protected $fillable = [
        'tanggal',
        'populasi_id',
        'kandang_id',
        'jumlah_produksi',
        'presentase',
        'mati',
        'afkir',
        'sisa_ayam',
        'telur_bagus',
        'telur_reject',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'presentase' => 'decimal:2',
    ];

    public function populasi(): BelongsTo
    {
        return $this->belongsTo(
            Populasi::class,
            'populasi_id'
        );
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(
            Kandang::class,
            'kandang_id'
        );
    }

    public function penjualanTelur(): HasMany
    {
        return $this->hasMany(
            PenjualanTelur::class,
            'produksi_id'
        );
    }

        public function gudang(): BelongsTo
    {
        return $this->belongsTo(GudangTelur::class, 'gudang_id');
    }

    /**
 * Hitung stok telur global (telur bagus yang belum terjual)
 * Stok = Total telur bagus diproduksi - Total telur terjual
 */
public static function stokTelur(): int
{
    $totalProduksi = (int) self::sum('telur_bagus');
    $totalTerjual = (int) PenjualanTelur::sum('jumlah');

    return max(0, $totalProduksi - $totalTerjual);
}

    /**
     * Hitung stok telur per kandang
     */
    public static function stokTelurPerKandang(int $kandangId): int
    {
        $totalProduksi = (int) self::where('kandang_id', $kandangId)->sum('telur_bagus');

        $totalTerjual = (int) PenjualanTelur::whereHas('produksiTelur', function($q) use ($kandangId) {
            $q->where('kandang_id', $kandangId);
        })->sum('jumlah');

        return max(0, $totalProduksi - $totalTerjual);
    }
}
