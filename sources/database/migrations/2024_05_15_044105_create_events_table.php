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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')
                ->nullable(false);
            $table->uuid('key')
                ->unique()
                ->nullable(false);
            $table->string('name', 255)
                ->nullable(false);
            $table->text('description')
                ->nullable(false);
            $table->string('image', 255)
                ->nullable(false);
            $table->date("start_date")
                ->nullable(false);
            $table->time("start_time")
                ->nullable(false);
            $table->date("expiration_date");
            $table->time("expiration_time");
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')
                ->nullable();
            // Связь
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete("CASCADE");
            // Индексы
            $table->index([
                'id',
                'user_id',
                'key',
                'start_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
