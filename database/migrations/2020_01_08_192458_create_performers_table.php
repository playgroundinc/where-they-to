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
      Schema::create('users', function (Blueprint $table) {
        $table->string('username')->unique();
        $table->string('password');
        $table->string('email')->unique();
        $table->bigIncrements('id');
        $table->timestamps();
        $table->tinyInteger('type')->unsigned()->nullable();
      });

      Schema::create('events', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('name');
        $table->string('date');
        $table->text('description');
        $table->integer('type');
      });

      Schema::create('families', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('name');
        $table->text('description');
        $table->bigInteger('event_id')->unsigned()->nullable();
        $table->foreign('event_id')->references('id')->on('events');
      });

      Schema::create('performers', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->json('type');
          $table->string('name');
          $table->text('bio');
          $table->bigInteger('family_id')->unsigned()->nullable();
          $table->foreign('family_id')->references('id')->on('families');
          $table->bigInteger('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->bigInteger('event_id')->unsigned()->nullable();
          $table->foreign('event_id')->references('id')->on('events');
      });

      Schema::create('venues', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('name');
        $table->string('address');
        $table->string('city');
        $table->string('province')->default('Ontario');
        $table->integer('accessibility')->default('0');
        $table->integer('neighbourhood')->default('0');
        $table->text('description');
        $table->bigInteger('family_id')->unsigned()->nullable();
        $table->foreign('family_id')->references('id')->on('families');
        $table->bigInteger('user_id')->unsigned()->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->bigInteger('event_id')->unsigned()->nullable();
        $table->foreign('event_id')->references('id')->on('events');
    });

    Schema::create('social_links', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('facebook')->default('');
        $table->string('instagram')->default('');
        $table->string('twitter')->default('');
        $table->string('website')->default('');
        $table->string('youtube')->default('');
        $table->bigInteger('family_id')->unsigned()->nullable();
        $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
        $table->bigInteger('user_id')->unsigned()->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->bigInteger('event_id')->unsigned()->nullable();
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('venues');
        Schema::dropIfExists('performers');
        Schema::dropIfExists('families');
        Schema::dropIfExists('users');
        Schema::dropIfExists('events');

    }
}
