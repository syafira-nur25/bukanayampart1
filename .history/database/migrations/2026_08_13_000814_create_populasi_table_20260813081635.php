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
        Schema::create('populasi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->int('hidup');
            $table->int('mati');
            $table->int('afkir');
            $table->int('sisa');
            $table->int('usia');
            $table->foreignId('kandang_id')->constrained('kandang')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('populasi');
    }
};
