<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_performer_types', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('performer_id')->unsigned();
          $table->foreign('performer_id')->references('id')->on('performers')->onDelete('cascade');
          $table->bigInteger('performer_type_id')->unsigned();
          $table->foreign('performer_type_id')->references('id')->on('performer_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performer_performer_types');
    }
}
