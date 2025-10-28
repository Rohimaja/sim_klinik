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
        Schema::create('jadwal_perawat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perawat_id')->constrained('perawat')->onDelete('cascade')->onUpdate('cascade');
            $table->date('hari');
            $table->time('jam_mulai');
            $table->time('jam_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_perawat');
    }
};
