<?php

use App\Domain\Constants\EnumConstants\GenderEnum;
use App\Domain\Constants\EnumConstants\RoleEnum;
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
        Schema::create(TABLE_USERS, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->integer(FIELD_GOOGLE_ID)
                ->nullable();
            $table->string(FIELD_FIRST_NAME, 255)
                ->nullable(false);
            $table->string(FIELD_FIRST_NAME_ENG)
                ->nullable(false);
            $table->string(FIELD_LAST_NAME)
                ->nullable(false);
            $table->string(FIELD_LAST_NAME_ENG)
                ->nullable(false);
            $table->date(FIELD_BIRTH_DATE)
                ->nullable();
            $table->enum(FIELD_GENDER, [
                GenderEnum::MALE->value,
                GenderEnum::FEMALE->value
            ])
                ->nullable();
            $table->string(FIELD_EMAIL, 255)
                ->unique()
                ->nullable();
            $table->string(FIELD_PHONE, 20)
                ->unique()
                ->nullable();
            $table->string(FIELD_LOCATION, 255)
                ->nullable();
            $table->enum(FIELD_ROLE, [
                RoleEnum::SUPERUSER->value,
                RoleEnum::ADMIN->value,
                RoleEnum::ATHLETE->value,
                RoleEnum::ADMIN_ATHLETE->value,
            ])
                ->default(RoleEnum::ADMIN->value);
            $table->string(FIELD_PASSWORD, 255)
                ->nullable();
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();
            // Индексы
            $table->index([
                FIELD_ID,
                FIELD_EMAIL,
                FIELD_PHONE,
                FIELD_GENDER,
                FIELD_ROLE,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_USERS);
    }
};
