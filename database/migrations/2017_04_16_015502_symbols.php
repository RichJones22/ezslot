<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Symbols extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        \Schema::create('symbols', function (Blueprint $table) {
            $table->increments('id');
            $table->string('underlier_symbol');
            $table->string('security_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        \Schema::dropIfExists('symbols');
    }
}
