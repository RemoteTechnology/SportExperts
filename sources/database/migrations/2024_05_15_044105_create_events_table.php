<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EventStatusesConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/FieldConst.php';
require_once dirname(__DIR__, 2) . '/app/Domain/Constants/EntitiesConst.php';

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TABLE_EVENTS, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->integer(FIELD_USER_ID)
                ->nullable(false);
            $table->uuid(FIELD_KEY)
                ->unique()
                ->nullable(false);
            $table->string(FIELD_NAME, 255)
                ->nullable(false);
            $table->text(FIELD_DESCRIPTION)
                ->nullable(false);
            $table->string(FIELD_IMAGE, 255)
                ->nullable(false);
            $table->string(FIELD_LOCATION, 255)
                ->nullable(false);
            $table->enum(FIELD_STATUS, [
                EVENT_ACTIVE,
                EVENT_NO_ACTIVE,
                EVENT_ARCHIVE])
                ->default(EVENT_ACTIVE)
                ->nullable(false);
            $table->date(FIELD_START_DATE)
                ->nullable(false);
            $table->time(FIELD_START_TIME)
                ->nullable(false);
            $table->date(FIELD_EXPIRATION_DATE);
            $table->time(FIELD_EXPIRATION_TIME);
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Связь
            $table->foreign(FIELD_USER_ID)
                ->on(TABLE_USERS)
                ->references(FIELD_ID)
                ->onDelete('SET NULL');
            // Индексы
            $table->index([
                FIELD_ID,
                FIELD_USER_ID,
                FIELD_KEY,
                FIELD_START_DATE
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_EVENTS);
    }
};
