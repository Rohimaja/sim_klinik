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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->onUpdate('cascade');
            $table->char('nik','16')->unique()->nullable();
            $table->string('nama','100')->nullable();
            $table->string('no_rm', 8)->unique();
            $table->string('no_bpjs', 30)->nullable();
            $table->string('rfid', 30)->nullable();
            $table->string('jenis_pasien', 30);
            $table->char('jenis_kelamin','1');
            $table->string('tempat_lahir','100');
            $table->date('tgl_lahir');
            $table->char('no_telp','20');
            $table->string('alamat');
            $table->string('foto','100')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
