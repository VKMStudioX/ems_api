<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventsDefaultsForBg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_defaults_for_bg', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement();
            $table->string("type",255)->default("");
            $table->string("title",255)->default("");
            $table->string("backgroundColor",255)->default("");
            $table->string("display",255)->default("");
            $table->string("className",255)->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_defaults_for_bg');
    }
}
