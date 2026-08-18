<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // hapus tabel lama (struktur lama) kalau ada, lalu buat ulang
        Schema::dropIfExists('laporan_harian');

        Schema::create('laporan_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('kandang_id')->constrained('kandang')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('umur_minggu')->default(0);
            $table->integer('hidup')->default(0);
            $table->integer('mati')->default(0);
            $table->integer('afkir')->default(0);
            $table->integer('sisa_ayam')->default(0);
            $table->decimal('total_pakan', 10, 2)->default(0);
            $table->integer('produksi_telur')->default(0);
            $table->integer('telur_pecah')->default(0);
            $table->string('column_10')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian');
    }
};
