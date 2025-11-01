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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('province',20)->nullable();
            $table->string('state',20)->nullable();
            $table->string('city',20)->nullable();
            $table->string('address')->nullable();
            $table->string('phone' , 15)->nullable();
            $table->string('central_address')->nullable();
            $table->string('central_phone',15)->nullable();
            $table->string('licence',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
