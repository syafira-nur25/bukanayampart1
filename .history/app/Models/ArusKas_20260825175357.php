<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArusKas extends Model
{
    protected $table = 'arus_kas';

    protected $fillable = [
        'tanggal',
        'keterangan',
        'nomor_bukti',
        'penerimaan',
        'pengeluaran',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'penerimaan'  => 'decimal:2',
        'pengeluaran' => 'decimal:2',
    ];
}
