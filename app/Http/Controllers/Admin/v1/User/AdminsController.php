<?php

namespace App\Http\Controllers\Admin\v1\User;

use App\Utilities\PageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admins\InfoModel as AdminInfoModel;

class AdminsController extends Controller
{

    /**
     * @OA\Get(
     *   path="/admins/info",
     *   tags={"管理员"},
     *   summary="管理员清单",
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

        $count = AdminInfoModel::count();
        $userList = AdminInfoModel::orderBy('id', 'desc')->skip($skip)->take($take)->get();

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
     *   path="/admins/info",
     *   tags={"管理员"},
     *   summary="添加新管理员",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="mobile",in="query",required=false,description="管理员手机号",@OA\Schema(type="integer",format="int64",default="13100000000",minimum=0)),
     *   @OA\Parameter(name="password",in="query",required=false,description="管理员登陆密码",@OA\Schema(type="string")),
     *   @OA\Parameter(name="level",in="query",required=false,description="管理员级别",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
            'password' => 'string',
            'cover' => 'string',
            'email' => 'string',
            'out_date' => 'string',
        ]);
        $user = new AdminInfoModel();
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        } else {
            $this->responseJson('FORM_LACK');
        }
        //检测手机号是否重复
        $counts = AdminInfoModel::where('mobile', $data['mobile'])->count();
        if ($counts) {
            $this->responseJson('USER_MOBILE_IS_EXIST');
        }
        //检测管理员名是否重复
        $counts = AdminInfoModel::where('username', $data['username'])->count();
        if ($counts) {
            $this->responseJson('USER_NAME_IS_EXIST');
        }

        $user->mobile = $data['mobile'];
        $user->level = $data['level'];
        $user->cover = $data['cover'];
        $user->email = isset($data['email']) ? $data['email'] : '';
        $user->username = isset($data['username']) ? $data['username'] : '';
        if (isset($data['out_date']) && !empty($data['out_date'])) {
            $user->out_date = date('Y-m-d', strtotime($data['out_date']));
        }

        if ($user->save()) {
            $this->responseJson('SUCCESS');
        } else {
            $this->responseJson('ERROR');
        }
    }


    /**
     * @OA\Get(
     *   path="/admins/info/{id}",
     *   tags={"管理员"},
     *   summary="取管理员信息",
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
        $user = AdminInfoModel::find($id);
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
     *   path="/admins/info/{id}",
     *   tags={"管理员"},
     *   summary="修改描写管理员",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *   @OA\Parameter(name="mobile",in="query",required=false,description="管理员手机号",@OA\Schema(type="integer",format="int64",default="13100000000",minimum=0)),
     *   @OA\Parameter(name="password",in="query",required=false,description="管理员登陆密码",@OA\Schema(type="string")),
     *   @OA\Parameter(name="level",in="query",required=false,description="管理员级别",@OA\Schema(type="integer",format="int64",default="0",minimum=0)),
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
            'password' => 'string',
            'email' => 'string',
            'cover' => 'string',
            'out_date' => 'string',
            'username' => 'string',
        ]);
        $user = AdminInfoModel::find($id);
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        //修改时，帐号验证
        if ($user->mobile != $data['mobile']) {
            //检测手机号是否重复
            $counts = AdminInfoModel::where('mobile', $data['mobile'])->count();
            if ($counts) {
                $this->responseJson('USER_MOBILE_IS_EXIST');
            }
        }


        //修改时，帐号验证
        if ($user->username != $data['username']) {
            //检测管理员名是否重复
            $counts = AdminInfoModel::where('username', $data['username'])->count();
            if ($counts) {
                $this->responseJson('USER_NAME_IS_EXIST');
            }
        }

        $user->mobile = $data['mobile'];
        $user->level = $data['level'];
        $user->cover = $data['cover'];
        $user->email = isset($data['email']) ? $data['email'] : '';
        $user->username = isset($data['username']) ? $data['username'] : '';
        if (isset($data['out_date']) && !empty($data['out_date'])) {
            $user->out_date = date('Y-m-d', strtotime($data['out_date']));
        }

        if ($user->save()) {
            $this->responseJson('SUCCESS');
        } else {
            $this->responseJson('ERROR');
        }
    }


    /**
     *
     * @OA\Delete(
     *   path="/admins/info/{id}",
     *   tags={"管理员"},
     *   summary="删除管理员",
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
        $user = AdminInfoModel::find($id);
        $this->responseDefaultJson($user->delete());

    }


    /**
     *
     * @OA\Patch(
     *   path="/admins/info/{id}",
     *   tags={"管理员"},
     *   summary="更新管理员状态",
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

        $record = AdminInfoModel::find($id);
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
