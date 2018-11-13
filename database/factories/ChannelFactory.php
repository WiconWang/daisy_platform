<?php
$faker = Faker\Factory::create('zh_CN');
$factory->define(App\Models\Channels\InfoModel::class, function () use ($faker) {
    return [
        'fid'         => $faker->numberBetween($min = 1, $max = 5),
        'status'      => $faker->numberBetween($min = 0, $max = 1),
        'title'       => $faker->ColorName,
        'description' => $faker->catchPhrase,
        'weight'      => $faker->numberBetween($min = 0, $max = 100),
    ];
});