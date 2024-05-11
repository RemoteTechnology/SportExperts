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
            $table->boolean('is_admin')
                ->default(false);
            $table->string('first_name', 255)
                ->nullable(false);
            $table->string('first_name_eng')
                ->nullable(false);
            $table->string('last_name')
                ->nullable(false);
            $table->string('last_name_eng')
                ->nullable(false);
            $table->date('birth_date')
                ->nullable();
            $table->enum('gender', ['Мужчина', 'Женщина'])
                ->nullable();
            $table->string('email')
                ->unique()
                ->nullable();
            $table->string('phone')
                ->unique()
                ->nullable();
            $table->string('location')
                ->nullable();
            $table->string('password')
                ->nullable(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
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
