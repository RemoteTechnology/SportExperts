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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_key')
                ->nullable();
            $table->integer('user_id')
                ->nullable();
            $table->enum('entity', ['event', 'user']);
            $table->string('name', 255)
                ->nullable(false);
            $table->string('value', 255)
                ->nullable(false);
            $table->enum('type', ['string', 'integer', 'boolean'])
                ->default('string')
                ->nullable(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
            // Связи
            $table->foreign('event_key')
                ->on('events')
                ->references('key');
            $table->foreign('user_id')
                ->on('users')
                ->references('id');
            // Индексы
            $table->index([
                'id',
                'event_key',
                'user_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
