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

      Schema::create('families', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('name');
        $table->text('description');
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
