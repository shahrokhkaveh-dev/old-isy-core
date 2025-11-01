<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewed_by')->after('status')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('admins');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewed_by')->after('status')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn('reviewed_by');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn('reviewed_by');
        });
    }
};
