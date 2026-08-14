<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('populasi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('hidup')->default(0);
            $table->integer('mati')->default(0);
            $table->integer('afkir')->default(0);
            $table->integer('sisa')->default(0);
            $table->integer('usia')->default(0);

            $table->foreignId('kandang_id')
                ->constrained('kandang')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('populasi');
    }
};
