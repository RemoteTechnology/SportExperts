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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')
                ->nullable(false);
            $table->uuid('key')
                ->unique()
                ->nullable(false);
            $table->string('name', 255)
                ->nullable(false);
            $table->text('description')
                ->nullable();
            $table->string('image', 255)
                ->nullable();
            $table->string('location', 255)
                ->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
            // Связи
            $table->foreign('users_id')
                ->on('users')
                ->references('id')
                ->onDelete("CASCADE");
            // Индексы
            $table->index([
                'users_id',
                'key',
                'name',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
