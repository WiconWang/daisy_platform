<?php

namespace App\Http\Controllers\Admin\v1\Component;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BannerService;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * @OA\Get(
     *   path="/banners",
     *   tags={"焦点图"},
     *   summary="焦点图列表",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="classification",in="query",required=true,description="栏目编号",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
            'classification' => 'integer|min:0',
        ]);
        $id = isset($data['classification'])?$data['classification']:1;
        $this->responseJson('SUCCESS','',$this->bannerService->getRows($id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }


    /**
     * @OA\Post(
     *   path="/banners",
     *   tags={"焦点图"},
     *   summary="焦点图列表",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="classification",in="query",required=false,description="焦点图类型，默认为0",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="title",in="query",required=true,description="标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="short_title",in="query",required=false,description="短标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="description",in="query",required=false,description="摘要",@OA\Schema(type="string")),
     *   @OA\Parameter(name="link_url",in="query",required=false,description="焦点图点击连接",@OA\Schema(type="string")),
     *   @OA\Parameter(name="pic_url",in="query",required=false,description="焦点图url",@OA\Schema(type="string")),
     *   @OA\Parameter(name="status",in="query",required=false,description="状态",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="weight",in="query",required=false,description="权重",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
            'classification' => 'required|integer|min:0',
            'title' => 'required|string',
            'short_title' => 'string',
            'description' => 'string',
            'link_url' => 'string',
            'status' => 'string',
            'pic_url' => 'string',
            'out_date' => 'string',
        ]);

        $this->responseJson('SUCCESS','', $this->bannerService->createRow($data));
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *   path="/banners/{id}",
     *   tags={"焦点图"},
     *   summary="取得指定id的焦点图",
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
        if ($row = $this->bannerService->getRow($id)){
            $this->responseJson('SUCCESS', '', $row);
        }
        $this->responseJson('RECORD_NOT_FOUND', '', $row);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT 完整/PATCH 部分    /posts/{post}    update    posts.update
     *
     * @OA\Put(
     *   path="/banners/{id}",
     *   tags={"焦点图"},
     *   summary="更新指定id的焦点图",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="classification",in="query",required=false,description="焦点图类型，默认为0",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="title",in="query",required=true,description="标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="short_title",in="query",required=false,description="短标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="description",in="query",required=false,description="摘要",@OA\Schema(type="string")),
     *   @OA\Parameter(name="link_url",in="query",required=false,description="焦点图点击连接",@OA\Schema(type="string")),
     *   @OA\Parameter(name="pic_url",in="query",required=false,description="焦点图url",@OA\Schema(type="string")),
     *   @OA\Parameter(name="status",in="query",required=false,description="状态",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="weight",in="query",required=false,description="权重",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *
     *    @OA\Response(
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
        $data = $this->validate($request, [
            'classification' => 'integer|min:0',
            'title' => 'string',
            'short_title' => 'string',
            'description' => 'string',
            'link_url' => 'string',
            'status' => 'string',
            'pic_url' => 'string',
            'out_date' => 'string',
        ]);

        $this->responseDefaultJson($this->bannerService->editRow($data, $id));

    }

    /**
     * @OA\Delete(
     *   path="/banners/{id}",
     *   tags={"焦点图"},
     *   summary="删除指定id的焦点图",
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
        $this->responseDefaultJson($this->bannerService->deleteRow($id));
    }

}
