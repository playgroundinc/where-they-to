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
        Schema::create('performer_performer_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('performer_id')->unsigned();
            $table->bigInteger('performer_type_id')->unsigned();
        });

        Schema::create('family_performer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('family_id')->unsigned();
            $table->bigInteger('performer_id')->unsigned();
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
        Schema::dropIfExists('family_performer');
    }
}
