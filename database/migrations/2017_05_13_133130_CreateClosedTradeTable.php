<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClosedTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closed_trades', function (Blueprint $table) {
            $table->increments('id');
            $table->date('close_date');
            $table->string('underlier_symbol');
            $table->json('trade_details');
            $table->timestamps();
            $table->unique(['close_date', 'underlier_symbol']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closed_trades');
    }
}
