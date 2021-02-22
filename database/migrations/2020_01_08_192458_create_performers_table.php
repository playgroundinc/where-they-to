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
            $table->string('password');
            $table->string('email')->unique();
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('role')->default(1);
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable()->default('CA');
            $table->json('attending')->nullable();
            $table->json('following_performers')->nullable();
            $table->json('following_venues')->nullable();
            $table->json('following_families')->nullable();
            $table->string('timezone')->nullable();
            $table->rememberToken();
        });

        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('country')->default('CA');
            $table->string('province')->default('ON');
            $table->string('timezone')->nullable();
            $table->text('description');      
            $table->string('accent_color')->default('#000000');
            $table->json('accessibility')->nullable();
            $table->text('accessibility_description')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->string('accent_color')->default('#000000');
            $table->json('performers_no_profile')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->string('venue_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->date('date')->nullable();
            $table->string('show_time')->nullable();
            $table->string('doors')->nullable();
            $table->string('timezone')->nullable();
            $table->text('description');
            $table->text('tickets')->nullable();
            $table->string('tickets_url')->nullable();
            $table->string('accent_color')->default('#000000');
            $table->json('accessibility')->nullable();
            $table->json('performers_no_profile')->nullable();
            $table->text('accessibility_description')->nullable();
            $table->bigInteger('venue_id')->unsigned()->nullable();
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
            $table->bigInteger('family_id')->unsigned()->nullable();
            $table->foreign('family_id')->references('id')->on('families')->onDelete('set null');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

        Schema::create('performers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->text('bio');
            $table->string('accent_color')->default('#000000');
            $table->text('tips')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('province');
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('facebook')->nullable()->default('');
            $table->string('instagram')->nullable()->default('');
            $table->string('twitter')->nullable()->default('');
            $table->string('website')->nullable()->default('');
            $table->string('twitch')->nullable()->default('');
            $table->string('tiktok')->nullable()->default('');
            $table->string('youtube')->nullable()->default('');
            $table->bigInteger('family_id')->unsigned()->nullable();
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->bigInteger('venue_id')->unsigned()->nullable();
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->bigInteger('performer_id')->unsigned()->nullable();
            $table->foreign('performer_id')->references('id')->on('performers')->onDelete('cascade');
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
        Schema::dropIfExists('cities');

    }
    }
