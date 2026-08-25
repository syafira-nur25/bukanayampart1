<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Tambahkan index biasa dulu, biar foreign key kandang_id
        //    punya pengganti penopang
        Schema::table('bobot_ayam', function (Blueprint $table) {
            $table->index('kandang_id');
        });

        // 2) Sekarang aman menghapus unique (kandang_id, tanggal)
        Schema::table('bobot_ayam', function (Blueprint $table) {
            $table->dropUnique(['kandang_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::table('bobot_ayam', function (Blueprint $table) {
            $table->unique(['kandang_id', 'tanggal']);
        });

        Schema::table('bobot_ayam', function (Blueprint $table) {
            $table->dropIndex(['kandang_id']);
        });
    }
};
