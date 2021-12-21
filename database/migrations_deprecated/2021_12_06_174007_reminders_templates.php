<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemindersTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders_templates', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement();
            $table->string("days_of_week",255)->default("");
            $table->string("hour_of_reminder",255)->default("");
            $table->string("title_of_reminder",255)->default("");
            $table->string("active_of_reminder",255)->default("");
            $table->string("text_of_reminder",255)->default("");
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
        Schema::dropIfExists('reminders_templates');
    }
}
