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
        Schema::create('pilots_in_flights', function (Blueprint $table) {
            $table->id();
            $table->foreign('pilot_id')
                ->references('id')
                ->on('users');
            $table->foreign('flight_id')
                ->references('id')
                ->on('flights');
            $table->boolean('is_flying');
            $table->boolean('sos');
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
        Schema::dropIfExists('pilots_in_flights');
    }
};
