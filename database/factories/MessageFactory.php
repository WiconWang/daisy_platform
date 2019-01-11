<?php

$faker = Faker\Factory::create('zh_CN');
$factory->define(App\Models\System\MessageModel::class,function () use ($faker) {
    return [
        'uid' => $faker->numberBetween($min = 1, $max = 5),
        'user_type' => $faker->numberBetween($min = 0, $max = 1),
        'status' => $faker->numberBetween($min = 0, $max = 2),
        'title'       => $faker->catchPhrase,
        'content'     => $faker->text,
    ];
});