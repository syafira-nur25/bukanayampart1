<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TotalPakan extends Model
{
    protected $table = 'total_pakan';

    protected $fillable = [
        'pakan_kandang_id',
        'total',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function pakanKandang(): BelongsTo
    {
        return $this->belongsTo(
            PakanKandang::class,
            'pakan_kandang_id'
        );
    }
}
