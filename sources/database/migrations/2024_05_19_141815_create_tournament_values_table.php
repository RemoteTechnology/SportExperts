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
        Schema::create('tournament_values', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id');
            $table->uuid('participants_A');
            $table->uuid('participants_B')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
            // Связи
            $table->foreign('tournament_id')
                ->on('tournaments')
                ->references('id');
            $table->foreign('participants_A')
                ->on('participants')
                ->references('key');
            $table->foreign('participants_B')
                ->on('participants')
                ->references('key');
            // Индексы
            $table->index([
                'id',
                'tournament_id',
                'participants_A',
                'participants_B',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_values');
    }
};
