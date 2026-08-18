<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
            $table->decimal('total_pakan', 10, 2)->default(0); // pemberian pagi/sore (kg)
            $table->integer('produksi_telur')->default(0);     // telur bagus
            $table->integer('telur_pecah')->default(0);
            $table->string('column_10')->nullable();           // catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian');
    }
};
