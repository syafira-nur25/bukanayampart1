<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemberianpakan extends Model
{
    protected $table = 'pemberian_pakan';

    protected $fillable = [
        'bulan',
        'populasi_id',
        'gr',
        'kg',
        'total',
        'jenis_pakan',
        'harga',
        'pengeluaran',
    ];

    protected $casts = [
        'gr' => 'integer',
        'kg' => 'integer',
        'total' => 'integer',
        'harga' => 'integer',
        'pengeluaran' => 'integer',
    ];

    public function populasi(): BelongsTo
    {
        return $this->belongsTo(
            Populasi::class,
            'populasi_id'
        );
    }
}
