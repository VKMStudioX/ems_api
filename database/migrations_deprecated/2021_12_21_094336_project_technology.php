<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectTechnology extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_technologies', function (Blueprint $table) {
            $table->id();
            $table->integer("purpose_id")->nullable();
            $table->integer("type_id")->nullable();
            $table->integer("methodology_id")->nullable();
            $table->integer("project_id")->nullable();
            $table->integer("technology_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_technologies');
    }
}
