<?php

use Illuminate\Database\Seeder;
use App\Models\Article\ArticleModel;
use App\Models\Article\ArticleExtendModel;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleModel::truncate();
        factory(ArticleModel::class, 50)->create();
        ArticleExtendModel::truncate();
        factory(ArticleExtendModel::class, 50)->create();
    }
}
