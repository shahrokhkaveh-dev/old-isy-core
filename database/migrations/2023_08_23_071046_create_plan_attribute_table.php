<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plan_attribute', function (Blueprint $table) {
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained('plan_attributes')->onDelete('cascade');
            $table->primary(['plan_id' , 'attribute_id']);
            $table->timestamps();
        });

        $inputs = [
            "1" => [1 , 2 , 3 , 4, 5, 6 , 7 , 8 , 9 , 10 , 11 , 12 ,13 , 14 , 15] ,
            "2" => [1 , 2, 3 , 4 , 5 , 6 , 7],
            "3" => [ 1 , 2 , 3 , 4 , 5 , 6 , 7]
        ];
        foreach ($inputs as $key => $values) {
            foreach ($values as $value) {
                DB::table('plan_attribute')->insert([
                    'plan_id'=>$key ,
                    'attribute_id' => $value
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_attribute');
    }
};
