<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TABLE_TOURNAMENTS, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->uuid(FIELD_KEY);
            $table->uuid(FIELD_EVENT_KEY);
            $table->integer(FIELD_STAGE)->default(1);
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Связи
            $table->foreign(FIELD_EVENT_KEY)
                ->on(TABLE_EVENTS)
                ->references(FIELD_KEY);
            // Индексы
            $table->index([
                FIELD_ID,
                FIELD_KEY,
                FIELD_EVENT_KEY,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_TOURNAMENTS);
    }
};
