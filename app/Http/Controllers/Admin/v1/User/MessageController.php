<?php

namespace App\Http\Controllers\Admin\v1\User;

use App\Services\messageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @OA\Get(
     *   path="/count",
     *   tags={"消息通知"},
     *   summary="未读的消息通知数量",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
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
     */
    public function count()
    {
        $this->responseJson('SUCCESS','',$this->messageService->countMessages(Auth::id(),0,0));
    }

    /**
     * @OA\Get(
     *   path="/index",
     *   tags={"消息通知"},
     *   summary="消息通知列表",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
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
     */
    public function index()
    {
        $this->responseJson('SUCCESS','',array(
            'unread' => $this->messageService->getRows(Auth::id(),0,0),
            'readed' => $this->messageService->getRows(Auth::id(),0,1),
            'trash' => $this->messageService->getRows(Auth::id(),0,2),
        ));

    }

    /**
     * @OA\Get(
     *   path="/content",
     *   tags={"消息通知"},
     *   summary="取得消息通知内容",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="id",in="query",required=false,description="消息ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function content(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'integer|min:1',
        ]);
        return $this->messageService->getRow($data['id']);
    }

    /**
     * @OA\Patch(
     *   path="/reading",
     *   tags={"消息通知"},
     *   summary="标记消息为已读",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="id",in="query",required=false,description="消息ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
     * @return
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reading(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'integer|min:1',
        ]);

        return $this->messageService->changeStatus(1,$data['id']);
    }

    /**
     * @OA\Patch(
     *   path="/remove",
     *   tags={"消息通知"},
     *   summary="删除消息",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="id",in="query",required=false,description="消息ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
     * @return
     * @throws \Illuminate\Validation\ValidationException
     */
    public function remove(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'integer|min:1',
        ]);
        return $this->messageService->changeStatus(2,$data['id']);
    }

    /**
     * @OA\Patch(
     *   path="/restore",
     *   tags={"消息通知"},
     *   summary="恢复已删除的消息",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="id",in="query",required=false,description="消息ID",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
     * @return
     * @throws \Illuminate\Validation\ValidationException
     */
    public function restore(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'integer|min:1',
        ]);

        return $this->messageService->changeStatus(1,$data['id']);
    }

}
