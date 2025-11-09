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
        Schema::create('perawat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('poli_id')->constrained('poli')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_str','20')->nullable()->unique();
            $table->string('no_sip','50')->nullable()->unique();
            $table->string('no_nira','30')->nullable()->unique();
            $table->char('jenis_kelamin','1');
            $table->string('tempat_lahir','100');
            $table->date('tgl_lahir');
            $table->char('no_telp','20');
            $table->string('alamat');
            $table->boolean('status')->default(true);
            $table->string('foto','100')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perawat');
    }
};
