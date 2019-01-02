<?php

namespace App\Http\Controllers\Admin\v1\User;

use App\Services\MemberService;
use App\Utilities\PageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Members\InfoModel as MemberInfoModel;

class MembersController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }
    /**
     * @OA\Get(
     *   path="/members/info",
     *   tags={"用户"},
     *   summary="用户清单",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
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
            'page' => 'integer|min:1',
            'pagesize' => 'integer|min:1',
        ]);

        list($skip, $take) =  PageHelper::getSqlSkipInArray($data);

        $count = MemberInfoModel::count();
        $userList = MemberInfoModel::orderBy('id', 'desc')->skip($skip)->take($take)->get();

        $this->responseJson('SUCCESS', '', $this->formatList($count, $userList));
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
     *   path="/members/info",
     *   tags={"用户"},
     *   summary="添加新用户",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="mobile",in="query",required=false,description="用户手机号",@OA\Schema(type="integer",format="int64",default="13100000000",minimum=0)),
     *   @OA\Parameter(name="password",in="query",required=false,description="用户登陆密码",@OA\Schema(type="string")),
     *   @OA\Parameter(name="level",in="query",required=false,description="用户级别",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="email",in="query",required=false,description="邮箱",@OA\Schema(type="string")),
     *   @OA\Parameter(name="out_date",in="query",required=false,description="过期日期",@OA\Schema(type="string")),
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
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'mobile' => 'required|integer|min:10',
            'level' => 'required|integer',
            'username' => 'required|string',
            'password' => 'string|nullable',
            'cover' => 'string|nullable',
            'email' => 'string|nullable',
            'out_date' => 'string|nullable',
        ]);
        list($code,$msg,$data) = $this->memberService->createRow($this->transNullToEmpty($data));
        if ($code == 1 ){
            $this->responseJson('SUCCESS', '');
        }else{
            $this->responseJson('ERROR', $msg);
        }
    }


    /**
     * @OA\Get(
     *   path="/members/info/{id}",
     *   tags={"用户"},
     *   summary="取用户信息",
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
     * @param $id
     */
    public function show($id)
    {
        $user = MemberInfoModel::find($id);
        unset($user->password);

        $this->responseJson('SUCCESS', '', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * @OA\Put(
     *   path="/members/info/{id}",
     *   tags={"用户"},
     *   summary="修改描写用户",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="mobile",in="query",required=false,description="用户手机号",@OA\Schema(type="integer",format="int64",default="13100000000",minimum=0)),
     *   @OA\Parameter(name="password",in="query",required=false,description="用户登陆密码",@OA\Schema(type="string")),
     *   @OA\Parameter(name="level",in="query",required=false,description="用户级别",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
     *   @OA\Parameter(name="email",in="query",required=false,description="邮箱",@OA\Schema(type="string")),
     *   @OA\Parameter(name="out_date",in="query",required=false,description="过期日期",@OA\Schema(type="string")),
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
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [
            'id' => 'integer|min:0',
            'mobile' => 'required|integer|min:10',
            'level' => 'required|integer',
            'password' => 'string|nullable',
            'email' => 'string|nullable',
            'cover' => 'string|nullable',
            'out_date' => 'string|nullable',
            'username' => 'string|nullable',
        ]);

        list($code,$msg,$data) = $this->memberService->editRow($this->transNullToEmpty($data),$id);
        if ($code == 1 ){
            $this->responseJson('SUCCESS', '');
        }else{
            $this->responseJson($msg);
        }
    }


    /**
     *
     * @OA\Delete(
     *   path="/members/info/{id}",
     *   tags={"用户"},
     *   summary="删除用户",
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
        $user = MemberInfoModel::find($id);
        $this->responseDefaultJson($user->delete());

    }


    /**
     *
     * @OA\Patch(
     *   path="/members/info/{id}",
     *   tags={"用户"},
     *   summary="更新用户状态",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="status",in="query",required=false,description="状态",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
    public function status(Request $request, $id)
    {

        $data = $this->validate($request, [
            'status' => 'required|integer|min:0',
        ]);

        $record = MemberInfoModel::find($id);
        if (!$record) {
            $this->responseJson('RECORD_NOT_FOUND');
        }

        $record->status = $data['status'];
        if ($record->save()) {
            $this->responseJson('SUCCESS');
        } else {
            $this->responseJson('ERROR');
        }
    }

}
