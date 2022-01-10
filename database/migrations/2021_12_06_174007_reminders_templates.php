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
            $table->id();
            $table->char("days_of_week",255)->nullable();
            $table->char("hour_of_reminder",255)->nullable();
            $table->char("title_of_reminder",255)->nullable();
            $table->integer("active_reminder")->nullable();
            $table->char("text_of_reminder",255)->nullable();
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
