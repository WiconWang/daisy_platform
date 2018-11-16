<?php

namespace App\Http\Controllers\Web\v1\Site;

use App\Http\Controllers\Web\v1\BaseController;
use App\Services\ChannelService;

class ChannelController extends BaseController
{
    private $channelService;

    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }


    /**
     * @OA\Get(
     *   path="/site/channels/{id}",
     *   tags={"频道"},
     *   summary="指定频道下的子频道列表。默认id为0全部",
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
    public function getChannelList($id)
    {
        $id = isset($id)?intval($id):0;
        $this->responseJson('SUCCESS','',$this->channelService->getRows($id));
    }
    
}
