<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enumerations\Table;
use App\Enumerations\Category\Fields;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(Table::CATEGORIES->value, function (Blueprint $table) {
            $table->renameColumn('url',Fields::SLUG->value);
            $table->dropColumn('search_url');
            $table->dropColumn('notShow');
            $table->dropColumn('isFinal');
            $table->jsonb(Fields::ICONS->value)->nullable()->change();
            $table->jsonb(Fields::IMAGES->value)->nullable()->change();
            $table->tinyInteger(Fields::STATUS->value)->default(\App\Enumerations\Category\Status::ACTIVE->value)->change();
            $table->tinyInteger(Fields::LEVEL->value)->default(\App\Enumerations\Category\Level::FOUR->value)->change();
            $table->string(Fields::CODE->value, 20)->nullable()->change();
            $table->integer(Fields::ORDER->value)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Table::CATEGORIES->value, function (Blueprint $table) {
            $table->renameColumn(Fields::SLUG->value,'url');
            $table->string('search_url')->nullable();
            $table->boolean('notShow')->nullable();
            $table->boolean('isFinal')->nullable();
            $table->dropColumn(Fields::ICONS->value);
            $table->dropColumn(Fields::IMAGES->value);
            $table->dropColumn(Fields::STATUS->value);
            $table->dropColumn(Fields::LEVEL->value);
            $table->dropColumn(Fields::CODE->value);
            $table->dropColumn(Fields::ORDER->value);
        });
    }
};
