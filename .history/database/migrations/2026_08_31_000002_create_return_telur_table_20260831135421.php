<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_telur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('gudang_id')->constrained('gudang_telur')->cascadeOnDelete();
            $table->integer('jumlah');
            $table->string('alasan', 50);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_telur');
    }
};
