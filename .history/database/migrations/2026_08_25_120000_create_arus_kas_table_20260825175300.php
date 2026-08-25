<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arus_kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('keterangan', 255);
            $table->string('nomor_bukti', 100)->nullable();
            $table->decimal('penerimaan', 15, 2)->default(0);
            $table->decimal('pengeluaran', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arus_kas');
    }
};