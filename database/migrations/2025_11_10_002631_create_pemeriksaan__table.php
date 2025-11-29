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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrian_poli_id')->constrained('antrian_poli');
            $table->foreignId('dokter_id')->constrained('dokter');
            $table->string('keluhan');
            $table->string('diagnosa');
            $table->string('tindakan');
            $table->string('catatan');
            $table->string('tensi');
            $table->float('suhu');
            $table->dateTime('tgl_periksa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
