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
        Schema::create('messengers', function (Blueprint $table) {
            $table->id();
            $table->string('feed_id');
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('model');
            $table->string('mfr');
            $table->string('batt_state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messengers');
    }
};
