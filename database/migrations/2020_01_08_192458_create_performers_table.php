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
            $table->string('name');
            $table->text('bio');
            $table->integer('user_id');
        });

        Schema::create('users', function (Blueprint $table) {
          $table->string('username')->unique();
          $table->string('password');
          $table->string('email')->unique();
          $table->bigIncrements('id');
          $table->timestamps();
          $table->tinyInteger('type')->unsigned()->default(UserType::PERFORMER);
          $table->json('events');
          $table->integer('socialLinks')->default('0');
      });

      Schema::create('venues', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->integer('family')->default('0');
        $table->string('name');
        $table->string('address');
        $table->string('city');
        $table->string('province')->default('Ontario');
        $table->integer('accessibility')->default('0');
        $table->integer('neighbourhood')->default('0');
        $table->text('description');
        $table->integer('user_id')->unsigned()->default('1');
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
