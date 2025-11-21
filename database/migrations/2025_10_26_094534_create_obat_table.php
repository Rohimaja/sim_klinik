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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('jenis_obat', 100);
            $table->integer('stok');
            $table->decimal('harga', 8, 2);
            $table->string('keterangan')->nullable();
            $table->boolean('status')->default(true);   // ✔ perbaikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
