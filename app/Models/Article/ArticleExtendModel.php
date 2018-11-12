<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleExtendModel extends Model
{
    protected $table = 'article_extend';
    protected $fillable = ['aid', 'content'];

}
