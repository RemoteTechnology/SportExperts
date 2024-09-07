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
        Schema::create(TABLE_TOURNAMENT_VALUES, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->integer(FIELD_TOURNAMENT_ID);
            $table->uuid(FIELD_PARTICIPANTS_A);
            $table->uuid(FIELD_PARTICIPANTS_B)->nullable();
            $table->uuid(FIELD_PARTICIPANTS_PASSES)->nullable();
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Связи
            $table->foreign(FIELD_TOURNAMENT_ID)
                ->on(TABLE_TOURNAMENTS)
                ->references(FIELD_ID);
            $table->foreign(FIELD_PARTICIPANTS_A)
                ->on(TABLE_PARTICIPANTS)
                ->references(FIELD_KEY);
            $table->foreign(FIELD_PARTICIPANTS_B)
                ->on(TABLE_PARTICIPANTS)
                ->references(FIELD_KEY);
            $table->foreign(FIELD_PARTICIPANTS_PASSES)
                ->on(TABLE_PARTICIPANTS)
                ->references(FIELD_KEY);
            // Индексы
            $table->index([
                FIELD_ID,
                FIELD_TOURNAMENT_ID,
                FIELD_PARTICIPANTS_A,
                FIELD_PARTICIPANTS_B,
                FIELD_PARTICIPANTS_PASSES,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_TOURNAMENT_VALUES);
    }
};
