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
        Schema::create('aplikasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->string('versi_aplikasi');
            $table->string('tahun_produksi');
            $table->string('bahasa_pemrograman');
            $table->string('jenis_database');
            $table->string('server_id');
            $table->string('pengelola');
            $table->string('penanggung_jawab');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplikasis');
    }
};
