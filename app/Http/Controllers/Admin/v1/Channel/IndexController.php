<?php

namespace App\Http\Controllers\Admin\v1\Channel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ChannelService;

class IndexController extends Controller
{
    protected $channelService;

    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }

    /**
     * @OA\Get(
     *   path="/channels",
     *   tags={"频道"},
     *   summary="频道列表",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="fid",in="query",required=true,description="栏目编号",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
            'fid' => 'integer|min:0',
        ]);
        $id = isset($data['fid'])?$data['fid']:0;
        $this->responseJson('SUCCESS','',$this->channelService->getRows($id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * @OA\Post(
     *   path="/channels",
     *   tags={"频道"},
     *   summary="频道列表",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="fid",in="query",required=false,description="栏目ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="title",in="query",required=true,description="标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="description",in="query",required=false,description="摘要",@OA\Schema(type="string")),
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
            'fid' => 'required|integer|min:0',
            'title' => 'required|string|nullable',
            'description' => 'string|nullable',
            'link' => 'string|nullable',
            'position' => 'array',
            'cover' => 'string|nullable',
            'status' => 'integer|min:0',
            'weight' => 'integer|min:0',
        ]);
        $this->responseJson('SUCCESS','', $this->channelService->createRow($this->transNullToEmpty($data)));
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *   path="/channels/{id}",
     *   tags={"频道"},
     *   summary="取得指定id的频道",
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
        if ($row = $this->channelService->getRow($id)){
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
     *   path="/channels/{id}",
     *   tags={"频道"},
     *   summary="更新指定id的频道",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="fid",in="query",required=false,description="栏目ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="title",in="query",required=false,description="标题",@OA\Schema(type="string")),
     *   @OA\Parameter(name="description",in="query",required=false,description="摘要",@OA\Schema(type="string")),
     *   @OA\Parameter(name="status",in="query",required=false,description="状态",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="weight",in="query",required=false,description="权重",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
        $data = $this->validate($request, [
            'fid' => 'integer|min:0',
            'title' => 'string|nullable',
            'description' => 'string|nullable',
            'link' => 'string|nullable',
            'position' => 'array',
            'cover' => 'string|nullable',
            'status' => 'integer|nullable',
            'weight' => 'integer|min:0',
        ]);

        $this->responseDefaultJson($this->channelService->editRow($this->transNullToEmpty($data), $id));

    }

    /**
     * @OA\Delete(
     *   path="/channels/{id}",
     *   tags={"频道"},
     *   summary="删除指定id的频道",
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
        $result = $this->channelService->deleteRow($id);
        if ($result === 'has_children') {
            $this->responseJson('CHANNEL_HAS_CHILDREN');
        }
        $this->responseDefaultJson($result);
    }

}
