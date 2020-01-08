<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserType;


class CreatePerformersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('family')->default('0');
            $table->json('type');
        });

        Schema::create('users', function (Blueprint $table) {
          $table->string('username')->unique();
          $table->string('password');
          $table->string('email')->unique();
          $table->bigIncrements('id');
          $table->timestamps();
          $table->tinyInteger('type')->unsigned()->default(UserType::Performer);
          $table->json('events');
          $table->string('name');
          $table->text('bio');
          $table->integer('socialLinks')->default('0');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performers');
    }
}
