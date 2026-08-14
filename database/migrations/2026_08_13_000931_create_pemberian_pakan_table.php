<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemberian_pakan', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 20);

            $table->foreignId('populasi_id')
                ->constrained('populasi')
                ->cascadeOnDelete();

            $table->integer('gr');
            $table->integer('kg');
            $table->integer('total');
            $table->string('jenis_pakan', 50);
            $table->integer('harga');
            $table->integer('pengeluaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemberian_pakan');
    }
};
