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
        Schema::dropIfExists('files');

        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('disk')->default(config('filesystems.default', 'local'))->index();
            $table->string('path')->index();
            $table->string('filename');
            $table->string('extension', 10);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->string('visibility')->default('public');
            $table->json('metadata')->nullable();
            $table->morphs('fileable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
