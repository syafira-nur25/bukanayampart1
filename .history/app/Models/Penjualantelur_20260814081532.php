<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanTelur extends Model
{
    protected $table = 'penjualan_telur';

    protected $fillable = [
        'tanggal',
        'jumlah',
        'customer',
        'total',
        'produksi_id',
        'harga',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga' => 'decimal:2',
        'total' => 'integer',
    ];

    public function produksiTelur(): BelongsTo
    {
        return $this->belongsTo(
            ProduksiTelur::class,
            'produksi_id'
        );
    }
}
