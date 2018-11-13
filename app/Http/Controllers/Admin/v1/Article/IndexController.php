<?php

namespace App\Http\Controllers\Admin\v1\Article;

use App\Models\Articles\ArticleExtendModel;
use App\Utilities\PageHelper;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articles\ArticleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *   path="/article",
     *   tags={"文章"},
     *   summary="文章列表",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="cid",in="query",required=true,description="栏目编号",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="page",in="query",required=false,description="页码",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="pagesize",in="query",required=false,description="每页条数",@OA\Schema(type="integer",format="int64",default="20",minimum=0)),
     *
     *   @OA\Response(
     *     response=200,
     *     description="返回 TOKEN需要在其它接口带回",
     *     @OA\JsonContent(
     *       @OA\Property(type="integer",property="code",example="1000",description="返回码"),
     *       @OA\Property(property="message",type="string",description="返回信息"),
     *       @OA\Property(property="data",type="array",description="信息数组",
     *         @OA\Items(
     *         type="object", @OA\Property(property="param1", type="string",example="详细参数，这里省略请调试真实数据"),
     *         ),
     *       ),
     *
     *     ),
     *   )
     * )
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        $data = $this->validate($request, [
            'cid' => 'integer|min:1',
            'page' => 'integer|min:1',
            'pagesize' => 'integer|min:1',
        ]);

        list($skip, $take) = PageHelper::pageToSqlSkip(
            (isset($data['page']) ? $data['page'] : 0),
            (isset($data['pagesize']) ? $data['pagesize'] : 20)
        );

        if (isset($data['cid']) &&!empty($data['cid'])){
            $count = ArticleModel::where('cid',$data['cid'])->count();
            $ArticleList = ArticleModel::where('cid',$data['cid'])->orderBy('id','desc')->skip($skip)->take($take)->get();
        }else{
            $count = ArticleModel::count();
            $ArticleList = ArticleModel::skip($skip)->orderBy('id','desc')->take($take)->get();
        }

        $this->responseJson('SUCCESS', '',  $this->formatList($count, $ArticleList));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //GET	/posts/create	create	posts.create
    public function create()
    {
    }

    /**
     * @OA\Post(
     *   path="/article",
     *   tags={"文章"},
     *   summary="添加新文章",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="cid",in="query",required=true,description="栏目ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="title",in="query",required=true,description="标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="status",in="query",required=false,description="状态",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="flag",in="query",required=false,description="标记",@OA\Schema(type="string")),
     *   @OA\Parameter(name="short_title",in="query",required=false,description="短标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="description",in="query",required=false,description="摘要",@OA\Schema(type="string")),
     *   @OA\Parameter(name="keyword",in="query",required=false,description="关键词",@OA\Schema(type="string")),
     *   @OA\Parameter(name="weight",in="query",required=false,description="权重",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="content",in="query",required=true,description="内容",@OA\Schema(type="string")),
     *
     *   @OA\Response(
     *     response=200,
     *     description="返回 TOKEN需要在其它接口带回",
     *     @OA\JsonContent(
     *       @OA\Property(type="integer",property="code",example="1000",description="返回码"),
     *       @OA\Property(property="message",type="string",description="返回信息"),
     *       @OA\Property(property="data",type="array",description="信息数组",
     *         @OA\Items(
     *         type="object", @OA\Property(property="param1", type="string",example="详细参数，这里省略请调试真实数据"),
     *         ),
     *       ),
     *
     *     ),
     *   )
     * )
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'cid' => 'required|integer|min:1',
            'title' => 'required|string',
            'content' => 'required|string',
            'content_origin' => 'required|string',
            'status' => 'integer|min:0',
            'weight' => 'integer|min:0',
        ]);


        try {
            DB::beginTransaction();

            request()->offsetSet('author_id', Auth::user()->id);
            request()->offsetSet('author_name', Auth::user()->username);
            request()->offsetSet('author_site', 0);

            $article=ArticleModel::create($request->all());
            if (!$article->id) throw new Exception('RECORD_INSERT_ERROR');
            $articleExtend=new ArticleExtendModel();
            $articleExtend->aid = $article->id;
            $articleExtend->content =$data['content'];
            $articleExtend->content_origin =$data['content_origin'];
            $bool2=$articleExtend->save();
            if (!$bool2) throw new Exception('RECORD_INSERT_ERROR');

            DB::commit();

            $this->responseJson('SUCCESS');
        } catch (Exception $e) {
            DB::rollBack();
            $this->responseJson($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *   path="/article/{id}",
     *   tags={"文章"},
     *   summary="取得指定id的文章",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),

     *   @OA\Response(
     *     response=200,
     *     description="返回 TOKEN需要在其它接口带回",
     *     @OA\JsonContent(
     *       @OA\Property(type="integer",property="code",example="1000",description="返回码"),
     *       @OA\Property(property="message",type="string",description="返回信息"),
     *       @OA\Property(property="data",type="array",description="信息数组",
     *         @OA\Items(
     *         type="object", @OA\Property(property="param1", type="string",example="详细参数，这里省略请调试真实数据"),
     *         ),
     *       ),
     *
     *     ),
     *   )
     * )
     * @param $id
     */
    public function show($id)
    {
        if ($res = ArticleModel::find($id)){
            $res2 = ArticleExtendModel::where('aid',$id)->first();
            $res->content = $res2->content;
            $res->content_origin = $res2->content_origin;
            $this->responseJson('SUCCESS','',$res);
        }else{
            $this->responseJson('RECORD_NOT_FOUND');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //GET	/posts/{post}/edit	edit	posts.edit
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     * PUT 完整/PATCH 部分    /posts/{post}    update    posts.update
     *
     * @OA\Put(
     *   path="/article/{id}",
     *   tags={"文章"},
     *   summary="更新指定id的文章",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="cid",in="query",required=false,description="栏目ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="title",in="query",required=false,description="标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="status",in="query",required=false,description="状态",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="flag",in="query",required=false,description="标记",@OA\Schema(type="string")),
     *   @OA\Parameter(name="short_title",in="query",required=false,description="短标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="description",in="query",required=false,description="摘要",@OA\Schema(type="string")),
     *   @OA\Parameter(name="keyword",in="query",required=false,description="关键词",@OA\Schema(type="string")),
     *   @OA\Parameter(name="weight",in="query",required=false,description="权重",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="content",in="query",required=true,description="内容",@OA\Schema(type="string")),
     *   @OA\Response(
     *     response=200,
     *     description="返回 TOKEN需要在其它接口带回",
     *     @OA\JsonContent(
     *       @OA\Property(type="integer",property="code",example="1000",description="返回码"),
     *       @OA\Property(property="message",type="string",description="返回信息"),
     *       @OA\Property(property="data",type="array",description="信息数组",
     *         @OA\Items(
     *         type="object", @OA\Property(property="param1", type="string",example="详细参数，这里省略请调试真实数据"),
     *         ),
     *       ),
     *
     *     ),
     *   )
     * )
     * @param Request $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cid' => 'integer|min:1',
            'status' => 'integer|min:0',
            'weight' => 'integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $res1 = $res2 = true;
            $saveData = $request->all();
            if (!empty($saveData['content'])){

                $res1=ArticleExtendModel::where('aid',$id)->update(array('content' =>$saveData['content'],'origin_content' =>$saveData['origin_content'],));
                unset($saveData['content'],$saveData['origin_content']);
            }


            if (!empty($saveData)){
                $res2=ArticleModel::where('id',$id)->update($saveData);
            }

            if (!$res1 || !$res2) throw new Exception('RECORD_UPDATE_ERROR');

            DB::commit();

            $this->responseJson('SUCCESS');
        } catch (Exception $e) {
            DB::rollBack();
            $this->responseJson($e->getMessage());
        }

    }


    /**
     * Remove the specified resource from storage.
     * DELETE    /posts/{post}    destroy    posts.destroy
     *
     * @OA\Delete(
     *   path="/article/{id}",
     *   tags={"文章"},
     *   summary="删除指定id的文章",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Response(
     *     response=200,
     *     description="返回 TOKEN需要在其它接口带回",
     *     @OA\JsonContent(
     *       @OA\Property(type="integer",property="code",example="1000",description="返回码"),
     *       @OA\Property(property="message",type="string",description="返回信息"),
     *       @OA\Property(property="data",type="array",description="信息数组",
     *         @OA\Items(
     *         type="object", @OA\Property(property="param1", type="string",example="详细参数，这里省略请调试真实数据"),
     *         ),
     *       ),
     *
     *     ),
     *   )
     * )
     * @param Request $request
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($id)
    {
        try {
            if (!is_numeric($id)) throw new Exception('PARAM_ERROR');
            DB::beginTransaction();

            $article=ArticleModel::find($id);
            if (empty($article))  throw new Exception('RECORD_NOT_FOUND');
            $bool = $article->delete(); //返回bool值

            $articleExtend=ArticleExtendModel::find($id);
            if (empty($articleExtend))  throw new Exception('RECORD_NOT_FOUND');
            $bool2 = $articleExtend->delete(); //返回bool值
            if (!$bool || !$bool2) throw new Exception('ERROR');

            DB::commit();

            $this->responseJson('SUCCESS');
        } catch (Exception $e) {
            DB::rollBack();
            $this->responseJson($e->getMessage());
        }


    }
}

