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
            $table->string('security_description');
            $table->string('position_state');
            $table->string('option_side');
            $table->integer('option_quantity')->nullable();
            $table->float('strike_price');
            $table->date('expiration')->nullable();
            $table->float('amount');
            $table->string('symbol');
            $table->bigInteger('transaction_id')->unique();
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
        Schema::dropIfExists('closed_trades');
    }
}
