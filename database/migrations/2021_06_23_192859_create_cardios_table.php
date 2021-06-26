<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workout_id');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
            $table->enum('type', ['Circuit Training', 'Cycling', 'Dancing', 'Elliptical', 'Rowing', 'Running', 'Stair Climbing', 'Swimming', 'Walking', 'Other']);
            $table->string('other_type', 100)->nullable();
            $table->unsignedSmallInteger('heart_rate')->nullable();
            $table->unsignedDecimal('distance', 4, 2)->nullable();
            $table->unsignedSmallInteger('calories_burned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cardios');
    }
}
