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
            $table->id();
            $table->char("type",255)->nullable();
            $table->char("title",255)->nullable();
            $table->char("backgroundColor",255)->nullable();
            $table->char("display",255)->nullable();
            $table->char("className",255)->nullable();
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
