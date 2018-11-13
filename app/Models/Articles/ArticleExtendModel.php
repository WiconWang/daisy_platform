<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Model;

class ArticleExtendModel extends Model
{
    protected $table = 'articles_extend';
    protected $fillable = ['aid', 'content'];

}
