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
        Schema::create('skrining', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->onDelete('cascade');
            $table->foreignId('perawat_id')->constrained('perawat'); // jika perawat = user
            $table->float('berat_badan')->nullable(); // kg
            $table->float('tinggi_badan')->nullable(); // cm
            $table->string('tensi',20)->nullable(); // 120/80
            $table->float('suhu')->nullable(); // celcius
            $table->text('keluhan_utama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skrining');
    }
};
