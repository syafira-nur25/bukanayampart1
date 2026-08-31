<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel produksi_telur
        if (!Schema::hasColumn('produksi_telur', 'gudang_id')) {
            Schema::table('produksi_telur', function (Blueprint $table) {
                $table->unsignedBigInteger('gudang_id')->nullable()->after('kandang_id');
                $table->foreign('gudang_id')->references('id')->on('gudang_telur')->nullOnDelete();
            });
        }

        // 2. Tabel penjualan_telur
        if (!Schema::hasColumn('penjualan_telur', 'gudang_id')) {
            Schema::table('penjualan_telur', function (Blueprint $table) {
                $table->unsignedBigInteger('gudang_id')->nullable()->after('produksi_id');
                $table->foreign('gudang_id')->references('id')->on('gudang_telur')->nullOnDelete();
            });
        }

        // 3. Tabel return_telur (jika tabelnya ada)
        if (Schema::hasTable('return_telur') && !Schema::hasColumn('return_telur', 'gudang_id')) {
            Schema::table('return_telur', function (Blueprint $table) {
                $table->unsignedBigInteger('gudang_id')->nullable();
                $table->foreign('gudang_id')->references('id')->on('gudang_telur')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('produksi_telur', 'gudang_id')) {
            Schema::table('produksi_telur', function (Blueprint $table) {
                $table->dropForeign(['gudang_id']);
                $table->dropColumn('gudang_id');
            });
        }

        if (Schema::hasColumn('penjualan_telur', 'gudang_id')) {
            Schema::table('penjualan_telur', function (Blueprint $table) {
                $table->dropForeign(['gudang_id']);
                $table->dropColumn('gudang_id');
            });
        }

        if (Schema::hasTable('return_telur') && Schema::hasColumn('return_telur', 'gudang_id')) {
            Schema::table('return_telur', function (Blueprint $table) {
                $table->dropForeign(['gudang_id']);
                $table->dropColumn('gudang_id');
            });
        }
    }
};
