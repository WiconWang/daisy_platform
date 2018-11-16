<?php
/**
 * 557 图片处理、生成方法.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/14 3:22 PM
 *
 *
 *
 * 图片上传：
 *
 * 将request直接推送到此服务中即可：
 * 提取post上来的file字段
 * $fileUpload = $request->file('file');
 * 验证此字段是否是有效的文件
 * if ($fileUpload->isValid()) {
 * 调用图片存储服务
 * list($status, $msg, $fileInfo) = $this->imagesService->saveImages($fileUpload);
 * 如果返回结果为1 则认为结果正确，可以把图片Info拿去用了
 * if ($status) {
 * $this->responseJson('SUCCESS', '', $fileInfo);
 * }
 * }
 * $this->responseFailed();
 *
 * 取图片的缩略图：
 *
 *  header("Content-type: image/".pathinfo($filename)['extension']);
 *  在调用以下方法前，需要验证用户是否显示此图的权限
 *  echo $imagesService->getThumbnail($filename);
 *
 *
 */
namespace App\Services;


use App\Utilities\ResponseHelper;
use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ImagesService
{
    use ResponseHelper;
    const WATER_SIZE_PERCENT = 0.4;
    private $uploads = "images/";

    /**
     * 图像存储
     * @param $requestFile
     * @param string $folder
     * @return mixed
     */
    public function saveImages($requestFile , $folder = '')
    {
        $folder = empty($folder)?$this->uploads: $folder.'/';
        $ext = $requestFile->getClientOriginalExtension();
        $path = $requestFile->getRealPath();
        $size = $requestFile->getSize();
        if (empty($ext) || empty($path)) return $this->returnArray(0, '未能提取到文件信息');
        $file = date('Ymd_his') . '_' . rand(100, 999);
        $filename = $file . '.' . $ext;

//        $bool = $requestFile->move('uploads', $filename);
        // print_r($c->getPathname());
         $bool = Storage::disk('public')->put($folder . $filename, file_get_contents($path));
        if ($bool) {
            return $this->returnArray(1, '成功', array(
                'path' => $folder.$filename,
                'filename' => $filename,
                'file' => $file,
                'ext' => $ext,
                'size' => $size,
            ));
        }
        return $this->returnArray(0, '保存失败');
    }


    /**
     * 根据图像加工缩略图
     * 如果已经有对应文件，则直接返回地址
     * 不存在，则重新生成
     * @param $thumbName
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getThumbnail($thumbName)
    {
        if (Storage::disk('public')->exists('thumbs/' . $thumbName)) {
            return Storage::disk('public')->get('thumbs/' . $thumbName);
        }

        if ($fileInfo = $this->separateThumbInPath($thumbName)) {
            if ($this->makeThumbnail($fileInfo['origin_file'], $fileInfo['width'], $fileInfo['height'], $fileInfo['water'], $fileInfo['ext'])) {
                return Storage::disk('public')->get('thumbs/' . $thumbName);
            }
        }
        return '';
    }

    /**
     * 生成新缩略图
     * @param $origin_file
     * @param $width
     * @param $height
     * @param $water_name
     * @param $ext
     * @return string
     */
    public function makeThumbnail($origin_file, $width, $height, $water_name, $ext)
    {
        $basePath = config('filesystems.disks.public.root') . '/';
//        $water_width = '40%';
//        $water_width = '40%';
        //如果源文件不存在
        $origin_filename = $origin_file . '.' . $ext;
        if (!Storage::disk('public')->exists($this->uploads . $origin_filename)) {
            return false;
        }
        $origin_path = $basePath . $this->uploads . $origin_filename;

        // 调整文件大小
        $img = Image::make($origin_path)->resize($width, $height);
        // 添加水印
        if ($water_name != '' && $water_name != 'null') {
            $water_path = $basePath . 'water/' . $water_name . '.png';
            if (Storage::disk('public')->exists('water/' . $water_name . '.png')) {
                list($water_width, $water_height) = $this->getWaterPicResizeWidth($water_path, $width);
                $imgWater = Image::make($water_path)->resize($water_width, $water_height);
                $img->insert($imgWater, 'center');
            }
        }
        $new_Filename = $origin_file . "_" . $width . "_" . $height . "_" . $water_name . "." . $ext;
        return $img->save($basePath . 'thumbs/' . $new_Filename);
    }

    /**
     * 从缩略图地址中分离出尺寸等信息
     * 一个标准的缩略图应该是： 年月日_时分秒_随机数_宽度_高度_水印名.扩展名
     * @param $path
     * @return mixed
     */
    private function separateThumbInPath($path)
    {
        $fileInfo = [];
        try {
            $p1 = explode('.', $path);
            $fileInfo['ext'] = $p1[1];
            $p2 = explode('_', $p1[0]);
            $fileInfo['origin_file'] = $p2[0] . '_' . $p2[1] . '_' . $p2[2];
            $fileInfo['width'] = $p2[3];
            $fileInfo['height'] = $p2[4];
            $fileInfo['water'] = $p2[5];
            return $fileInfo;
        } catch (Exception $e) {
            return [];
        }

    }

    private function getWaterPicResizeWidth($waterPicPath, $width,$percent = self::WATER_SIZE_PERCENT)
    {
        list($waterWidth, $waterHeight) = getimagesize($waterPicPath);
        return array(
            intval($width * $percent),
            intval(($width * $percent) * $waterHeight / $waterWidth)
        );
    }

}