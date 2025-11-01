<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\ApiKeyManager\Enumerations\Tables;
use App\Modules\ApiKeyManager\Enumerations\ApiKeyLogsFields;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Tables::API_KEY_LOGS->value, function (Blueprint $table) {
            $table->id();
            $table->string(ApiKeyLogsFields::API_KEY->value);
            $table->string(ApiKeyLogsFields::ENDPOINT->value);
            $table->string(ApiKeyLogsFields::IP_ADDRESS->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Tables::API_KEY_LOGS->value);
    }
};
