<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('price');
            $table->string('description');
            $table->string('url')->nullable();
        });
        Schema::create('event_ticket', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->bigInteger('ticket_id')->nullable();
          $table->bigInteger('event_id')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
