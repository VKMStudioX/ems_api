<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Project extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("project_technology_ids",50)->nullable();
            $table->string("project_name",255)->nullable();
            $table->longText("project_info ")->nullable();
            $table->datetime('project_start');
            $table->datetime('project_end');
            $table->datetime('project_start');
            $table->string("client_name",255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
