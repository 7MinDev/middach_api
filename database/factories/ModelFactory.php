<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Models\User::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'last_login' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'username' => $faker->userName,
        'password' => str_random(10),
    ];
});

$factory->define(\App\Models\OpeningTime::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'restaurant_id' => $faker->unique()->randomDigit,
        'day_of_week' => $faker->numberBetween(1, 7),
        'opening_time' => $faker->time,
        'closing_time' => $faker->time,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});

$factory->define(\App\Models\Restaurant::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'user_id' => $faker->unique()->randomDigit,
        'name' => $faker->company,
        'street' => $faker->streetAddress,
        'town' => $faker->city,
        'postal_code' => $faker->postcode,
        'description' => $faker->text,
        'feedback_email' => $faker->email,
        'website' => 'www' . $faker->domainName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

$factory->define(\App\Models\Food::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'restaurant_id' => $faker->unique()->randomDigit,
        'title' => $faker->sentence(3),
        'sub_title' => $faker->sentence(6),
        'price' => $faker->randomFloat(2, 0, 10),
        'additional_info' => $faker->sentence(3),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

$factory->define(\App\Models\Menu::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'user_id' => $faker->unique()->randomDigit,
        'name' => $faker->word,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
