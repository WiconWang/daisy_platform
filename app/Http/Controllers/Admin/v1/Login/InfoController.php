<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/24 11:18 AM
 */

namespace App\Http\Controllers\Admin\v1\Login;



use App\Http\Controllers\Admin\v1\BaseController;
 use Illuminate\Support\Facades\Auth;

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
        $user->access ="admin";
        unset($user->password);
        $this->responseJson('SUCCESS', '', $user);
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