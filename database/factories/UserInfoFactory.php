<?php

//use Faker\Generator as Faker;
$factory->define(App\Models\User\InfoModel::class, function () {
    $faker = \Faker\Factory::create('zh_CN');
    return [
        'mobile' => $faker->phoneNumber,
        'password' => bcrypt(123456),
        'username' => $faker->name,
        'email' => $faker->email,
        'level' => $faker->numberBetween($min = 0, $max = 5),
        'status' => $faker->numberBetween($min = 0, $max = 1),
        'out_date' => $faker->dateTime,
        'last_login' => $faker->dateTime,
    ];
});

//use Faker\Factory as Faker;
//
//$factory->define(App\test\Article::class, function () {
//    $faker = Faker::create('zh_CN');
//    return [
//        'title' =>  $faker->name,
//        'body' => $faker->catchPhrase,
//        'created_at' => $faker->dateTimeThisMonth(),
//        'updated_at' => $faker->dateTimeThisMonth(),
//
//    ];
//});

