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
        Schema::create(TABLE_TEAMS, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->integer(FIELD_USER_ID)
                ->nullable(false);
            $table->uuid(FIELD_KEY)
                ->unique()
                ->nullable(false);
            $table->string(FIELD_NAME, 255)
                ->nullable(false);
            $table->text(FIELD_DESCRIPTION)
                ->nullable();
            $table->string(FIELD_IMAGE, 255)
                ->nullable();
            $table->string(FIELD_LOCATION, 255)
                ->nullable();
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Связи
            $table->foreign(FIELD_USER_ID)
                ->on(TABLE_USERS)
                ->references(FIELD_ID)
                ->onDelete("CASCADE");
            // Индексы
            $table->index([
                FIELD_USER_ID,
                FIELD_KEY,
                FIELD_NAME,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_TEAMS);
    }
};
