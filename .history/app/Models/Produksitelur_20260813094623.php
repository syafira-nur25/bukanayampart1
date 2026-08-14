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
        return $this->belongsTo(Populasi::class, 'populasi_id');
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }
public function kandang()
{
    return $this->belongsTo(Kandang::class);public function kandang()
{
    return $this->belongsTo(Kandang::class);
}
}
    public function penjualanTelur(): HasMany
    {
        return $this->hasMany(PenjualanTelur::class, 'produksi_id');
    }
}
