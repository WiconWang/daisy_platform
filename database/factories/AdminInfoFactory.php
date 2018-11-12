<?php

$factory->define(App\Models\Admin\InfoModel::class, function () {
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
