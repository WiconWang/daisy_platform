<?php

$faker = Faker\Factory::create('zh_CN');
$factory->define(App\Models\Articles\ArticleModel::class, function () use ($faker) {
    return [
        'cid'         => $faker->numberBetween($min = 1, $max = 8),
        'status'      => $faker->numberBetween($min = 0, $max = 1),
        'flag'        => '',
        'title'       => $faker->catchPhrase,
        'short_title' => $faker->ColorName,
        'description' => $faker->catchPhrase,
        'keyword'     => $faker->ColorName,
        'author_id'   => $faker->numberBetween($min = 0, $max = 5),
        'author_name' => $faker->name,
        'author_site' => $faker->numberBetween($min = 0, $max = 1),
        'weight'      => $faker->numberBetween($min = 0, $max = 100),
    ];
});