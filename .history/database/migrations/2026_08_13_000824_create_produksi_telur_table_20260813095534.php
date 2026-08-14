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
      Schema::create('produksi_telur', function (Blueprint $table) {
    $table->id();

    $table->date('tanggal');

    $table->foreignId('populasi_id')
        ->constrained('populasi')
        ->cascadeOnDelete();

    $table->foreignId('kandang_id')
        ->constrained('kandang')
        ->cascadeOnDelete();

    $table->integer('jumlah_produksi')->default(0);

    $table->decimal('presentase', 5, 2)->default(0);

    $table->integer('mati')->default(0);

    $table->integer('afkir')->default(0);

    $table->integer('sisa_ayam')->default(0);

    $table->integer('telur_bagus')->default(0);

    $table->integer('telur_reject')->default(0);

    $table->timestamps();
});

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_telur');
    }
};
