<?php

namespace App\Http\Controllers\Member\v1\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Members\InfoModel as MemberInfoModel;

class IndexController extends Controller
{

    /**
     * @OA\Post(
     *   path="/login",
     *   tags={"登陆"},
     *   summary="用户登陆",
     *   @OA\Parameter(name="username",in="query",required=false,description="用户名",@OA\Schema(type="string")),
     *   @OA\Parameter(name="password",in="query",required=false,description="密码",@OA\Schema(type="string")),
     *
     *   @OA\Response(
     *     response=200,
     *     description="成功",
     *     @OA\JsonContent(
     *       @OA\Property(type="integer",property="code",example="1000",description="返回码"),
     *       @OA\Property(property="message",type="string",description="返回信息"),
     *       @OA\Property(property="data",type="array",description="信息数组",
     *         @OA\Items(
     *         type="object", @OA\Property(property="accessToken", type="string",example="用户TOKEN,此值需要在认证接口中Header区传回，格式：Bearer空格token"),
     *         ),
     *       ),
     *     ),
     *   )
     *  )
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $data = $this->validate($request, [
            'username' => 'required|min:2|max:20',
            'password' => 'required|min:2|max:20',
        ]);
        $record = MemberInfoModel::where(['mobile' => $data['username']])->first();
        if (empty($record)) {
            $this->responseJson('USER_NOT_EXIST');
        }

        if (!password_verify($data['password'], $record->password)) {
            $this->responseJson('USER_PASSWORD_ERROR');
        }

        if ($record->status){
            $this->responseJson('USER_DISABLED');
        }

        $token = $record->createToken('Member_Token');
        $this->responseJson('SUCCESS', '', $token);

    }



}
