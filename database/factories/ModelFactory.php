<?php

use Carbon\Carbon;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$faker = \Faker\Factory::create('vi_VN');

$factory->define(App\Models\Admin::class, function () use ($faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'username' => $faker->userName,
        'birthday' => $faker->dateTime($max = '-10 years', $timezone = date_default_timezone_get()),
        'gender' => $faker->randomElement(\App\Models\Admin::$genders),
        'phone' => $faker->phoneNumber(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});

$factory->define(App\Models\User::class, function () use ($faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'username' => $faker->userName,
        'birthday' => $faker->dateTime($max = '-10 years', $timezone = date_default_timezone_get()),
        'gender' => $faker->randomElement(["male", "female"]),
        'phone' => $faker->phoneNumber(),
        'google_id' => $faker->randomNumber($nbDigits = null, $strict = false),
    ];
});

$factory->define(App\Models\Team::class, function () use ($faker) {

    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});

$factory->define(App\Models\Event::class, function () use ($faker) {

    $name = $faker->name;
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $name);
    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));

    return [
        'name' => $name,
        'start_time_at' => $faker->dateTimeBetween(
            $startDate = '-5 months',
            $endDate = '-3 months',
            $timezone = date_default_timezone_get()
        ),
        'end_time_at' => $faker->dateTimeBetween(
            $startDate = '-2 months',
            $endDate = '+2 months',
            $timezone = date_default_timezone_get()
        ),
            'status' => \App\Models\Event::PUBLISH_STATUS,
        'slug' => $slug,
        'description' => $faker->text,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
