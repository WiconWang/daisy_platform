<?php

use Illuminate\Database\Seeder;
use App\Models\Articles\ArticleModel;
use App\Models\Articles\ArticleExtendModel;

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
        ArticleExtendModel::truncate();
        //生成文章
        factory(ArticleModel::class, 50)
            ->create()
            ->map(function ($article) {
                //同时生成一篇关联的文章正文
                factory(ArticleExtendModel::class, 1)
                    ->create([ 'aid' => $article->id ]);
            });
    }
}
