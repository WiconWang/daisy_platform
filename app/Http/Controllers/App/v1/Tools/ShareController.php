<?php
// 微信分享签名

namespace App\Http\Controllers\App\v1\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\jsSdk;

class ShareController extends Controller
{


    /**
     * @OA\Get(
     *   path="/share/weixin",
     *   tags={"分享"},
     *   summary="提供H5的微信分享签名鉴权",
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
     *     ),
     *   )
     * )
     *
     */
    public function getWeiXinAuth()
    {
        $jsSdk = new jsSdk(config('services.weixin.appid'), config('services.weixin.appsecret'));
        $this->responseJson('SUCCESS', '', $jsSdk->GetSignPackage());
    }

}
