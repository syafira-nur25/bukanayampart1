<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->dropForeign(['populasi_id']);
        });

        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->unsignedBigInteger('populasi_id')->nullable()->change();
            $table->foreign('populasi_id')->references('id')->on('populasi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->dropForeign(['populasi_id']);
            $table->unsignedBigInteger('populasi_id')->nullable(false)->change();
            $table->foreign('populasi_id')->references('id')->on('populasi')->cascadeOnDelete();
        });
    }
};
