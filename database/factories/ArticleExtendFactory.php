<?php
$factory->define(App\Models\Article\ArticleExtendModel::class, function () {
    $faker = \Faker\Factory::create('zh_CN');
    return [
        'aid'      => $faker->numberBetween($min = 0, $max = 50),
        'content'     => $faker->text,
    ];
});