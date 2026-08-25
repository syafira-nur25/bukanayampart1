<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bobot_ayam', function (Blueprint $table) {
            $table->dropUnique(['kandang_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::table('bobot_ayam', function (Blueprint $table) {
            $table->unique(['kandang_id', 'tanggal']);
        });
    }
};
