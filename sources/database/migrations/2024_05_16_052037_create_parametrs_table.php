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
        Schema::create('parametrs', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_key');
            $table->uuid('event_user_key');
            $table->enum('entity', ['event', 'event_user']);
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
                ->references('key')
                ->onDelete('CASCADE');
            $table->foreign('event_user_key')
                ->on('event_users')
                ->references('key')
                ->onDelete('CASCADE');
            // Индексы
            $table->index([
                'id',
                'event_key',
                'event_user_key',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametrs');
    }
};
