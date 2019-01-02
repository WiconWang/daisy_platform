<?php

namespace App\Http\Controllers\Member\v1\Tools;

use App\Services\ImagesService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    protected $imagesService;

    /**
     * PictureController constructor.
     * 初始化图片处理相关Service层
     * @param ImagesService $imagesService
     */
    public function __construct(ImagesService $imagesService)
    {
        $this->imagesService = $imagesService;
    }
    /**
     * @OA\Post(
     *   path="/upload/editorimage",
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
    public function uploadEditorImage(Request $request){
        $base_url = config('app.url').'/';
        $res = array(
            "errno"=> 0,
            "data"=> '',
        );

        if (!empty($request->file())){
//            $destinationPath = 'uploads';
            $list = array();

            try {
                foreach ($request->file() as $item) {
                    // $c = $item->move($destinationPath,$item->getClientOriginalName());
                    //  array_push($list,$base_url.$c->getPathname()) ;
                    //调用图片存储服务
                    list($status, $msg, $fileInfo) = $this->imagesService->saveImages($item);
                    //如果返回结果为1 则认为结果正确，可以把图片Info拿去用了
                    if ($status) {
                        array_push($list,$base_url.$fileInfo['path']);
                    }
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


    /**
     * @OA\Post(
     *   path="/upload/image",
     *   tags={"上传"},
     *   summary="上传图片",
     *   description="此方法为上传图片接口，将图片内容post到此接口的 file 字段上",
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
    public function uploadImage(Request $request)
    {
        // 提取post上来的file字段
        $fileUpload = $request->file('file');
        // 验证此字段是否是有效的文件
        if ($fileUpload->isValid()) {
            //调用图片存储服务
            list($status, $msg, $fileInfo) = $this->imagesService->saveImages($fileUpload);
            //如果返回结果为1 则认为结果正确，可以把图片Info拿去用了
            if ($status) {
                $this->responseJson('SUCCESS', '', $fileInfo);
            }
        }
        $this->responseJson('ERROR');
    }

    /**
     * 显示缩略图
     * 比如要显示名为20180706_212342_111.jpg图片的缩略图，要求是宽300，高250，水印wms.png
     * 可以按以下方式请求：
     * http://api.net.cn/user/v1/picture/show/thumb/20180317_233342_112_300_250_wms.jpg
     * 缩略图的格式为   年月日_时分秒_随机数_宽度_高度_水印名.扩展名
     * 文件存在直接回显，不存在会生成
     * @param $filename
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getThumb($filename){
        if (empty($filename)) $this->responseFailed();
        header("Content-type: image/".pathinfo($filename)['extension']);
        // 在调用以下方法前，需要验证用户是否显示此图的权限
        echo $this->imagesService->getThumbnail($filename);
        exit;
    }


    /**
     * 显示带水印的原图
     * 比如要显示名为 20180706_212342_111.jpg 图片的原图
     * 可以按以下方式请求：
     * http://api.net.cn/user/v1/picture/show/thumb/20180317_233342_112.jpg
     * 文件存在直接回显，不存在会生成，，默认为水印wms.png
     * @param $filename
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getImageWithWater($filename){
        if (empty($filename)) $this->responseFailed();
        header("Content-type: image/".pathinfo($filename)['extension']);
        // 在调用以下方法前，需要验证用户是否显示此图的权限
        echo $this->imagesService->getOriginWithWater($filename);
        exit;
    }


}
