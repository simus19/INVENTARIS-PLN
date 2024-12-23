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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_layanan');
            $table->string('unit_induk_PLN');
            $table->string('no_BA_aktivasi');
            $table->date('tanggal_BA');
            $table->string('nama_layanan');
            $table->string('level_unit');
            $table->string('alamat_unit');
            $table->string('bandwidth');
            $table->string('ip_gateway');
            $table->string('status');
            $table->string('harga_layanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
