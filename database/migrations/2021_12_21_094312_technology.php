<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Technology extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("purpose_id");
            $table->foreign('purpose_id')->references('id')->on('purposes')->onDelete('cascade');
            $table->unsignedBigInteger("type_id");
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->unsignedBigInteger("methodology_id");
            $table->foreign('methodology_id')->references('id')->on('methodologies')->onDelete('cascade');
            $table->string("technology",50)->nullable();
            $table->string("language",50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technologies');
    }
}
