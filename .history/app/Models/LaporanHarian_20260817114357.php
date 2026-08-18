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

/** Baseline: sisa ayam sebelum tanggal tertentu (dari laporan sebelumnya / populasi) */
public static function baselineSebelum(int $kandangId, string $tanggal): ?int
{
    $prev = static::where('kandang_id', $kandangId)
        ->whereDate('tanggal', '<', $tanggal)
        ->orderByDesc('tanggal')
        ->orderByDesc('id')
        ->first();

    if ($prev) {
        return (int) $prev->sisa_ayam;
    }

    $populasi = Populasi::where('kandang_id', $kandangId)
        ->latest('tanggal')
        ->first();

    return $populasi ? (int) $populasi->sisa : null;
}

/** Hitung ulang rantai hidup & sisa mulai tanggal tertentu */
public static function hitungUlangRantai(int $kandangId, string $mulaiTanggal): void
{
    $rows = static::where('kandang_id', $kandangId)
        ->whereDate('tanggal', '>=', $mulaiTanggal)
        ->orderBy('tanggal')
        ->orderBy('id')
        ->get();

    $sisaSebelum = static::baselineSebelum($kandangId, $mulaiTanggal);

    foreach ($rows as $row) {
        // kalau tidak ada baseline sama sekali, pakai nilai hidup lama sebagai titik awal
        $hidup = $sisaSebelum ?? (int) $row->hidup;

        $row->hidup       = $hidup;
        $row->sisa_ayam   = max(0, $hidup - (int) $row->mati - (int) $row->afkir);
        $row->save();

        $sisaSebelum = $row->sisa_ayam;
    }
}
