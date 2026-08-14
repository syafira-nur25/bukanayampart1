<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakan_kandang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('total_masuk', 10, 2);

            $table->foreignId('kandang_id')
                ->constrained('kandang')
                ->cascadeOnDelete();

            $table->decimal('keluar', 10, 2);
            $table->decimal('sisa', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakan_kandang');
    }
};
