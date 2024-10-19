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

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roles_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->smallInteger('role_verified_is')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('roles_id')->references('id')->on('roles');
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
        });
        
        
        Schema::create('menu_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menus_id');
            $table->string('name');
            $table->string('url');
            $table->timestamps();
            
            $table->foreign('menus_id')->references('id')->on('menus');
        });
        
        Schema::create('user_role_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roles_id');
            $table->unsignedBigInteger('menus_id');
            $table->timestamps();

            $table->foreign('roles_id')->references('id')->on('roles');
            $table->foreign('menus_id')->references('id')->on('menus');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_menus');
        Schema::dropIfExists('menu_subs');
        Schema::dropIfExists('menus');

        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
