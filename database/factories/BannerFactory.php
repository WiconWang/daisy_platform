<?php

$faker = Faker\Factory::create('zh_CN');
$factory->define(App\Models\Component\BannerModel::class,  function () use ($faker) {
    return [
        'title'       => $faker->ColorName.$faker->ColorName.$faker->ColorName,
        'short_title'       => $faker->ColorName,
        'description' => $faker->catchPhrase,
        'pic_url' => $faker->url,
        'link_url' => $faker->url,
        'classification'         => $faker->numberBetween($min = 1, $max = 3),
        'status'      => $faker->numberBetween($min = 0, $max = 1),
        'out_date'      => $faker->dateTime,
        ];
});
