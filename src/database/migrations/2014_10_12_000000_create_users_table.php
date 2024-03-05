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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('auth_platform', ['Сайт', 'Google', 'Вконтакте'])->default('Сайт');
            // Персональные данные Вконтакте
            $table->string('vk_id')->nullable();
            $table->text('vk_sid_token')->nullable();
            $table->string('vk_sig_token')->nullable();
            // Персональные данные Google
            $table->string('google_id')->nullable();
            $table->text('google_access_token')->nullable();
            //
            $table->string('first_name')->nullable();
            $table->string('first_name_eng');
            $table->string('last_name')->nullable();
            $table->string('last_name_eng');
            $table->dateTime('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
