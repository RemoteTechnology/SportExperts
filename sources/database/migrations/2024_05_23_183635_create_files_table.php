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
        Schema::create(TABLE_FILES, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->uuid(FIELD_KEY);
            $table->string(FIELD_NAME, 255);
            $table->string(FIELD_MIME, 100);
            $table->bigInteger(FIELD_SIZE);
            $table->string(FIELD_EXTENSION, 10);
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Индексы
            $table->index([
                FIELD_KEY,
                FIELD_MIME,
                FIELD_EXTENSION
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_FILES);
    }
};
