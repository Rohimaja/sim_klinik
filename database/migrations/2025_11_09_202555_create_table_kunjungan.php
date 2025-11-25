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
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien');
            $table->foreignId('poli_id')->constrained('poli')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_antrian',20);
            $table->time('jam_awal');
            $table->time('jam_akhir');
            $table->date('tgl_kunjungan');
            $table->string('keluhan_awal',100)->nullable();
            $table->enum('status',['tidak hadir','menunggu','dipanggil','selesai','dibatalkan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
