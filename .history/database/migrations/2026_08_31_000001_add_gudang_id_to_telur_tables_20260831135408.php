<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->foreignId('gudang_id')->nullable()->after('kandang_id')->constrained('gudang_telur')->nullOnDelete();
        });

        Schema::table('penjualan_telur', function (Blueprint $table) {
            $table->foreignId('gudang_id')->nullable()->after('produksi_id')->constrained('gudang_telur')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->dropForeign(['gudang_id']);
            $table->dropColumn('gudang_id');
        });

        Schema::table('penjualan_telur', function (Blueprint $table) {
            $table->dropForeign(['gudang_id']);
            $table->dropColumn('gudang_id');
        });
    }
};
