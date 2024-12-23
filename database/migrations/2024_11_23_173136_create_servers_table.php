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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('merk_server');
            $table->string('server_serial_number');
            $table->string('operating_system');
            $table->string('lisensi_os');
            $table->string('ip_address');
            $table->string('processor');
            $table->string('memory');
            $table->string('jumlah_core');
            $table->string('storage');
            $table->string('status_hardisk');
            $table->string('fungsi_server');
            $table->string('server_type');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
