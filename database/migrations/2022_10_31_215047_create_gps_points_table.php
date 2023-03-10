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
            $table->string('lat');
            $table->string('lon');
            $table->integer('alt');
            $table->float('dist_LP');
            $table->float('avg_speed');
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
