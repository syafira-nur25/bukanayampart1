<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pakanandang extends Model
{
    protected $table = 'pakan_kandang';

    protected $fillable = [
        'tanggal',
        'total_masuk',
        'kandang_id',
        'keluar',
        'sisa',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_masuk' => 'decimal:2',
        'keluar' => 'decimal:2',
        'sisa' => 'decimal:2',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(
            Kandang::class,
            'kandang_id'
        );
    }

    public function totalPakan(): HasMany
    {
        return $this->hasMany(
            TotalPakan::class,
            'pakan_kandang_id'
        );
    }
}
