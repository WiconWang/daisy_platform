<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int status
 * @property string flag
 * @property string short_title
 * @property string description
 * @property string keyword
 * @property string weight
 * @property  cid
 * @property  title
 * @property  author_id
 */
class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $fillable = ['cid', 'status', 'flag', 'title', 'short_title', 'description', 'keyword', 'author_id', 'author_name', 'author_site', 'weight'];


    public function content()
    {
        return $this->hasOne('App\Models\Article\ArticleExtendModel', 'aid', 'id');
    }

}
