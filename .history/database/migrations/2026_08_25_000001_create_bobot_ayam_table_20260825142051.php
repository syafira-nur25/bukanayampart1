<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bobot_ayam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained('kandang')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('bobot')->default(0); // dalam gram
            $table->timestamps();
            $table->unique(['kandang_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobot_ayam');
    }
};
