<?php

$factory->define(App\Models\Article\ArticleModel::class, function () {
    $faker = \Faker\Factory::create('zh_CN');
    return [
        'cid'         => 1,
        'status'      => $faker->numberBetween($min = 0, $max = 1),
        'flag'        => '',
        'title'       => $faker->sentence,
        'short_title' => $faker->word,
        'description' => $faker->paragraph,
        'keyword'     => $faker->word,
        'author_id'   => $faker->numberBetween($min = 0, $max = 5),
        'author_name' => $faker->name,
        'author_site' => $faker->numberBetween($min = 0, $max = 1),
        'weight'      => $faker->numberBetween($min = 0, $max = 100),
    ];
});