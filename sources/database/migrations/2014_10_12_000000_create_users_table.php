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
            $table->string('email', 255)
                ->unique()
                ->nullable();
            $table->string('phone', 20)
                ->unique()
                ->nullable();
            $table->string('location', 255)
                ->nullable();
            $table->enum('role', ['superuser', 'admin', 'athlete'])
                ->default('athlete');
            $table->string('password', 255)
                ->nullable(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
            // Индексы
            $table->index([
                'id',
                'email',
                'phone',
                'gender',
                'role',
            ]);
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
