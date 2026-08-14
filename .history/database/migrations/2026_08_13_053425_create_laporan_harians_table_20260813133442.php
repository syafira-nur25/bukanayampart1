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

            $table->integer('umur_minggu');

            $table->integer('mati')->default(0);

            $table->integer('hidup')->default(0);

            $table->integer('afkir')->default(0);

            $table->integer('sisa_ayam')->default(0);

            $table->integer('produksi_telur')->default(0);

            $table->integer('telur_pecah')->default(0);

            $table->string('column_10')->nullable();

            $table->foreignId('kandang_id')
                ->constrained('kandang')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian');
    }
};
