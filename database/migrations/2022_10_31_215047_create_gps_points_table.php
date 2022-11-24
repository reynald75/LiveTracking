<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id');
            $table->float('lat', 8, 5);
            $table->float('lon', 8, 5);
            $table->integer('alt');
            $table->string('msg_type');
            $table->string('msg_content')->nullable();
            $table->boolean('msg_show')->default(true);
            $table->dateTime('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gps_points');
    }
};
