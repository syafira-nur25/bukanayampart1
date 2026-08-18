<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanHarian extends Model
{
    protected $table = 'laporan_harian';

    protected $fillable = [
        'tanggal', 'kandang_id', 'user_id', 'umur_minggu',
        'hidup', 'mati', 'afkir', 'sisa_ayam',
        'total_pakan', 'produksi_telur', 'telur_pecah', 'column_10',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_pakan' => 'decimal:2',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Feed intake (g/ekor) = total pakan (kg) × 1000 ÷ populasi */
    public function feedIntake(): float
    {
        return $this->sisa_ayam > 0
            ? ((float) $this->total_pakan * 1000) / $this->sisa_ayam
            : 0;
    }

    /** HDP / presentase produksi = telur ÷ populasi × 100 */
    public function presentaseProduksi(): float
    {
        return $this->sisa_ayam > 0
            ? ((float) $this->produksi_telur / $this->sisa_ayam) * 100
            : 0;
    }
}
