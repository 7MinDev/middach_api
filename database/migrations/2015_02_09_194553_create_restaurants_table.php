<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('name');
            $table->string('street');
            $table->string('town');
            $table->string('postal_code');
            $table->string('description')->nullable();
            $table->string('feedback_email')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });

        Schema::create('opening_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onDelete('cascade');
            $table->integer('day_of_week');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->timestamps();
        });

        Schema::create('opening_times_overrides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onDelete('cascade');
            $table->integer('day_of_week');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opening_times_overrides', function (Blueprint $table) {
            $table->dropForeign('opening_times_overrides_restaurant_id_foreign');
        });
        Schema::drop('opening_times_overrides');

        Schema::table('opening_times', function (Blueprint $table) {
            $table->dropForeign('opening_times_restaurant_id_foreign');
        });
        Schema::drop('opening_times');

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign('restaurants_user_id_foreign');
        });
        Schema::drop('restaurants');
    }

}
