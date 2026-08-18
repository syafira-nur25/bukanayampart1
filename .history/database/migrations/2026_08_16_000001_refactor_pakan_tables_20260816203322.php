<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Hapus tabel total_pakan
        Schema::dropIfExists('total_pakan');

        // 2) kandang_id boleh NULL (baris "pakan masuk gudang")
        Schema::table('pakan_kandang', function (Blueprint $table) {
            $table->dropForeign(['kandang_id']);
        });

        Schema::table('pakan_kandang', function (Blueprint $table) {
            $table->foreignId('kandang_id')->nullable()->change();
            $table->foreign('kandang_id')->references('id')->on('kandang')->nullOnDelete();
        });

        // 3) Kolom sisa dihapus — sisa dihitung otomatis di laporan
        Schema::table('pakan_kandang', function (Blueprint $table) {
            $table->dropColumn('sisa');
        });
    }

    public function down(): void
    {
        Schema::table('pakan_kandang', function (Blueprint $table) {
            $table->decimal('sisa', 10, 2)->default(0);
        });
    }
};
