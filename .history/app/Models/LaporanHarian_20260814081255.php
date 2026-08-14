<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanHarian extends Model
{
    protected $table = 'laporan_harian';

    protected $fillable = [
        'tanggal',
        'umur_minggu',
        'mati',
        'hidup',
        'afkir',
        'sisa_ayam',
        'produksi_telur',
        'telur_pecah',
        'column_10',
        'kandang_id',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class);
    }
}
