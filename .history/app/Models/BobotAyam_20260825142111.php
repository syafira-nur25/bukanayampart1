<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BobotAyam extends Model
{
    protected $table = 'bobot_ayam';

    protected $fillable = [
        'kandang_id',
        'tanggal',
        'bobot',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'bobot'   => 'integer',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }
}
