<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('expense_id');
            $table->string('lat_from');
            $table->string('long_from');
            $table->string('lat_to');
            $table->string('long_to');
            $table->double('leters');
            $table->double('distance')->default(0);
            $table->double('fuel_price_per_leter');
            $table->double('fuel_price_total');
            $table->double('prev_reading');
            $table->double('current_reading');
            $table->text('purpose')->nullable();
            $table->text('journey')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logbooks');
    }
}
