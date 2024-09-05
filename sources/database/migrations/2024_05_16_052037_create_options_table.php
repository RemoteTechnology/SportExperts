<?php

use App\Domain\Constants\EnumConstants\OptionEntityEnum;
use App\Domain\Constants\EnumConstants\TypeOptionEnum;
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
        Schema::create(TABLE_OPTIONS, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->uuid(FIELD_EVENT_KEY)
                ->nullable();
            $table->integer(FIELD_USER_ID)
                ->nullable();
            $table->enum(FIELD_ENTITY, [
                OptionEntityEnum::EVENT->value,
                OptionEntityEnum::USER->value,
            ]);
            $table->string(FIELD_NAME, 255)
                ->nullable(false);
            $table->string(FIELD_VALUE, 255)
                ->nullable(false);
            $table->enum(FIELD_TYPE, [
                TypeOptionEnum::_STRING->value,
                TypeOptionEnum::_INTEGER->value,
                TypeOptionEnum::_BOOLEAN->value,
            ])
                ->default(TypeOptionEnum::_STRING->value)
                ->nullable(false);
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Связи
            $table->foreign(FIELD_EVENT_KEY)
                ->on(TABLE_EVENTS)
                ->references(FIELD_KEY);
            $table->foreign(FIELD_USER_ID)
                ->on(TABLE_USERS)
                ->references(FIELD_ID);
            // Индексы
            $table->index([
                FIELD_ID,
                FIELD_EVENT_KEY,
                FIELD_USER_ID,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_OPTIONS);
    }
};
