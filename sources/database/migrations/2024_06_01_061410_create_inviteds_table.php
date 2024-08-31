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
        Schema::create(TABLE_INVITES, function (Blueprint $table) {
            $table->id(FIELD_ID);
            $table->integer(FIELD_WHO_USER_ID);
            $table->foreignId(FIELD_USER_ID)
                ->unique();
            $table->timestamp(FIELD_CREATED_AT);
            $table->timestamp(FIELD_UPDATED_AT);
            $table->timestamp(FIELD_DELETED_AT)
                ->nullable();

            $table->foreign(FIELD_WHO_USER_ID)
                ->on(TABLE_USERS)
                ->references(FIELD_ID)
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_INVITES);
    }
};
