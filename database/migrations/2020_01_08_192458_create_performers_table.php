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
        $table->string('username')->unique()->nullable();
        $table->string('password');
        $table->string('email')->unique();
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('name')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->integer('role')->default(1);
        $table->rememberToken();
        $table->tinyInteger('type')->unsigned()->nullable();
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
        $table->bigInteger('user_id')->unsigned()->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });

    Schema::create('families', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->string('name');
      $table->text('description');
    });

    Schema::create('event_types', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->string('name');
    });

    Schema::create('performer_types', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->string('name');
    });

    Schema::create('events', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name');
        $table->timestamps();
        $table->string('date')->nullable();
        $table->string('time')->nullable();
        $table->text('description');
        $table->bigInteger('venue_id')->unsigned()->nullable();
        $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
        $table->bigInteger('family_id')->unsigned()->nullable();
        $table->foreign('family_id')->references('id')->on('families')->onDelete('set null');
        $table->bigInteger('event_type_id')->unsigned()->nullable();
        $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('set null');
        $table->bigInteger('user_id')->unsigned()->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      });

      Schema::create('performers', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->string('name');
          $table->text('bio');
          $table->bigInteger('family_id')->unsigned()->nullable();
          $table->foreign('family_id')->references('id')->on('families');
          $table->bigInteger('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('performers');
        Schema::dropIfExists('events');
        Schema::dropIfExists('performer_types');
        Schema::dropIfExists('event_types');
        Schema::dropIfExists('families');
        Schema::dropIfExists('venues');
        Schema::dropIfExists('users');

    }
}
