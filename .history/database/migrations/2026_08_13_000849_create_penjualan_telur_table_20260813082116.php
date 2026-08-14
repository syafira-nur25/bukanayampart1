<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_telur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('customer', 100);
            $table->integer('total');

            $table->foreignId('produksi_id')
                ->constrained('produksi_telur')
                ->cascadeOnDelete();

            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_telur');
    }
};
