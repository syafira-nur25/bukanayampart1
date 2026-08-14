<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kandang extends Model
{
    protected $table = 'kandang';

    protected $fillable = [
        'nama',
        'lokasi',
    ];

    public function populasi(): HasMany
    {
        return $this->hasMany(Populasi::class, 'kandang_id');
    }

    public function produksiTelur(): HasMany
    {
        return $this->hasMany(ProduksiTelur::class, 'kandang_id');
    }

    public function pakanKandang(): HasMany
    {
        return $this->hasMany(PakanKandang::class, 'kandang_id');
    }

    public function laporanHarian(): HasMany
    {
    return $this->hasMany(
        LaporanHarian::class,
        'kandang_id');
    }
}
