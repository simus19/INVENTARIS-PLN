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
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_hardware');
            $table->string('merk_hardware');
            $table->string('tipe_hardware');
            $table->string('serial_number')->unique(); // Serial number harus unik
            $table->string('lokasi');
            $table->string('status');
            $table->string('qr_code')->nullable(); // Kolom untuk menyimpan path QR Code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};
