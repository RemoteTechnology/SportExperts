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
        Schema::create(TABLE_PARTICIPANTS, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->integer(FIELD_EVENT_ID)
                ->nullable();
            $table->integer(FIELD_USER_ID)
                ->nullable(false);
            $table->integer(FIELD_INVITED_USER_ID)
                ->nullable();
            $table->uuid(FIELD_TEAM_KEY)
                ->nullable();
            $table->uuid(FIELD_KEY)
                ->unique()
                ->nullable(false);
            // TODO: связать с опциями "под какими опциями регается спортсмен на событие"

            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Связи
            $table->foreign(FIELD_EVENT_ID)
                ->on(TABLE_EVENTS)
                ->references(FIELD_ID);
            $table->foreign(FIELD_USER_ID)
                ->on(TABLE_USERS)
                ->references(FIELD_ID)
                ->onDelete("CASCADE");
            $table->foreign(FIELD_INVITED_USER_ID)
                ->on(TABLE_USERS)
                ->references(FIELD_ID);
            $table->foreign(FIELD_TEAM_KEY)
                ->on(TABLE_TEAMS)
                ->references(FIELD_KEY);
            // Индексы
            $table->index([
                FIELD_ID,
                FIELD_EVENT_ID,
                FIELD_USER_ID,
                FIELD_INVITED_USER_ID,
                FIELD_TEAM_KEY,
                FIELD_KEY,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_PARTICIPANTS);
    }
};
