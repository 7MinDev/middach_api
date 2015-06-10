<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFoodsTableRemoveUserIdAddRestaurantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropForeign('foods_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('foods', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id')
                ->default(0);

            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropForeign('foods_restaurant_id_foreign');
            $table->dropColumn('restaurant_id');
        });

        Schema::table('foods', function (Blueprint $table) {
            $table->unsignedInteger('user_id')
                ->default(0);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
}
