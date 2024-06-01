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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')
                ->nullable();
            $table->integer('user_id')
                ->nullable(false);
            $table->integer('invited_user_id')
                ->nullable();
            $table->uuid('team_key')
                ->nullable();
            $table->uuid('key')
                ->unique()
                ->nullable(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
            // Связи
            $table->foreign('event_id')
                ->on('events')
                ->references('id')
                ->onDelete("CASCADE");
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete("CASCADE");
            $table->foreign('invited_user_id')
                ->on('users')
                ->references('id')
                ->onDelete("CASCADE");
            $table->foreign('team_key')
                ->on('teams')
                ->references('key')
                ->onDelete("CASCADE");
            // Индексы
            $table->index([
                'id',
                'event_id',
                'user_id',
                'invited_user_id',
                'team_key',
                'key',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
