<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnTelur extends Model
{
    protected $table = 'return_telur';
    protected $fillable = ['tanggal', 'gudang_id', 'jumlah', 'alasan', 'keterangan'];
    protected $casts = ['tanggal' => 'date', 'jumlah' => 'integer'];

    public function gudang(): BelongsTo { return $this->belongsTo(GudangTelur::class, 'gudang_id'); }
}
