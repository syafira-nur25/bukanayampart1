<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Populasi extends Model
{
    protected $table = 'populasi';

    protected $fillable = [
        'tanggal',
        'hidup',
        'mati',
        'afkir',
        'sisa',
        'usia',
        'kandang_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function produksiTelur(): HasMany
    {
        return $this->hasMany(ProduksiTelur::class, 'populasi_id');
    }

    public function pemberianPakan(): HasMany
    {
        return $this->hasMany(PemberianPakan::class, 'populasi_id');
    }
}
