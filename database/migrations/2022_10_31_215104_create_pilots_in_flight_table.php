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
        Schema::create('pilots_in_flight', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('flight_id');
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
        Schema::dropIfExists('pilots_in_flight');
    }
};
