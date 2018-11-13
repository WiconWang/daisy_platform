<?php

namespace App\Http\Controllers;

use App\Models\Articles\ArticleExtendModel;
use App\Models\Articles\ArticleModel;

class ArticleController extends Controller
{

    /**
     * 文档相关
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function index($id)
    {
        $res = ArticleModel::find($id);
        $res2 = ArticleExtendModel::where('aid',$id)->first();
        $res->content = $res2->content;
        return view('article/show', array('article'=>$res));
    }

}
