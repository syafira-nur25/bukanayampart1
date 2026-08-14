<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('total_pakan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pakan_kandang_id')
                ->constrained('pakan_kandang')
                ->cascadeOnDelete();

            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('total_pakan');
    }
};
