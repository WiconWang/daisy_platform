<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/24 11:18 AM
 */

namespace App\Http\Controllers\Member\v1\Login;



use App\Http\Controllers\Member\v1\BaseController;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InfoController extends BaseController
{

    /**
     * @OA\Get(
     *    path="/info",
     *   tags={"登陆"},
     *   summary="取自己的资料",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *
     *   @OA\Response(
     *    response=200,
     *    description="正确",
     *  )
     * )
     */
    public function index()
    {
        $user = Auth::user();
        $user->avator =$user->cover;
        $user->access ="user";
        unset($user->password);
        $this->responseJson('SUCCESS', '', $user);
    }


    /**
     * @OA\Put(
     *   path="/info",
     *   tags={"登陆"},
     *   summary="修改自己的资料",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *
     *   @OA\Response(
     *    response=200,
     *    description="正确",
     *  )
     * )
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function info(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'integer|min:0',
            'mobile' => 'integer|min:10',
            'password' => 'string|nullable',
            'email' => 'string|nullable',
            'cover' => 'string|nullable',
            'username' => 'string|nullable',
        ]);

        list($code,$msg,$data) = (new MemberService())->editRow($this->transNullToEmpty($data),Auth::user()->id);
        if ($code == 1 ){
            $this->responseJson('SUCCESS', '');
        }else{
            $this->responseJson($msg);
        }
    }
    /**
     * @OA\Get(
     *    path="/logout",
     *   tags={"登陆"},
     *   summary="退出",
     *   operationId="login.logout",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *
     *   @OA\Response(
     *    response=200,
     *    description="正确",
     *  )
     * )
     */
    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        $this->responseJson('SUCCESS');
    }

}
