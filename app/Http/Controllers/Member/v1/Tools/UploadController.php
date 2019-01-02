<?php

namespace App\Http\Controllers\Member\v1\Tools;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    /**
     * @OA\Post(
     *   path="/upload/image",
     *   tags={"上传"},
     *   summary="wangEditor上传图片",
     *   description="此方法提供给wangEditor使用，支持多个图片上传，直接post图片列表到此接口即可",
     *   @OA\Parameter(name="Authorization",in="header",description="Bearer TOKEN",required=true,@OA\Schema(type="string")),
     *
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
     * @return JsonResponse
     */
    public function uploadImage(Request $request){
        $base_url = config('app.url').'/';
        $res = array(
            "errno"=> 0,
            "data"=> '',
        );

        if (!empty($request->file())){
            $destinationPath = 'uploads';
            $list = array();

            try {
                foreach ($request->file() as $item) {
                    $c = $item->move($destinationPath,$item->getClientOriginalName());
                    array_push($list,$base_url.$c->getPathname()) ;
                }
                $res['data'] = $list;
            } catch (Exception $e) {
                $res['errno'] = 1;
                $res['data'] = $e->getMessage();
            }
        }else{
            $res['errno'] = 1;
            $res['data'] = '未接收到参数';
        }
        return new JsonResponse($res,200);

//
//        //Display File Name
//        echo 'File Name: '.$file->getClientOriginalName();
//        echo '<br>';
//
//        //Display File Extension
//        echo 'File Extension: '.$file->getClientOriginalExtension();
//        echo '<br>';
//
//        //Display File Real Path
//        echo 'File Real Path: '.$file->getRealPath();
//        echo '<br>';
//
//        //Display File Size
//        echo 'File Size: '.$file->getSize();
//        echo '<br>';
//
//        //Display File Mime Type
//        echo 'File Mime Type: '.$file->getMimeType();
//
//        //Move Uploaded File
//        $destinationPath = 'uploads';
//        $c = $file->move($destinationPath,$file->getClientOriginalName());
//        $res = array(
//            "errno"=> 0,
//            "data"=> array($c->getPathname()),
//        );
    }
}
