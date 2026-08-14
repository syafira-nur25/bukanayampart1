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
            $table->foreignId('populasi_id')->constrained('populasi')->onDelete('cascade');
            $table->foreignId('kandang')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_telur');
    }
};
