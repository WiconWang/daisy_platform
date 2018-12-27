<?php

$faker = Faker\Factory::create('zh_CN');
$factory->define(App\Models\Admins\InfoModel::class,function () use ($faker) {
    return [
        'mobile' => $faker->phoneNumber,
        'password' => bcrypt(123456),
        'username' => $faker->name,
        'email' => $faker->email,
        'cover' => $faker->imageUrl(),
        'level' => $faker->numberBetween($min = 0, $max = 5),
        'status' => $faker->numberBetween($min = 0, $max = 1),
        'out_date' => $faker->dateTime,
        'last_login' => $faker->dateTime,
    ];
});
