<?php
/**
 * 557 上传方法.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/14 3:22 PM
 *
 *
 *
 */

namespace App\Services;


use App\Utilities\ResponseHelper;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class UploadService
{
    use ResponseHelper;
    private $uploads = "upload/";

    /**
     * 图像存储
     * @param $requestFile
     * @param string $folder
     * @return mixed
     */
    public function saveFiles($requestFile, $folder = '')
    {
        $folder = empty($folder) ? $this->uploads : $folder . '/';
        $ext = $requestFile->getClientOriginalExtension();
        $path = $requestFile->getRealPath();
        $size = $requestFile->getSize();
        if (empty($ext) || empty($path)) return $this->returnArray(0, '未能提取到文件信息');
        $file = date('Ymd_his') . '_' . rand(100, 999);
        $filename = $file . '.' . $ext;

//        $bool = $requestFile->move('uploads', $filename);
        // print_r($c->getPathname());
        $bool = Storage::disk('public')->put($folder . $filename, File::get($path));
        if ($bool) {
            return $this->returnArray(1, '成功', array(
                'path' => $folder . $filename,
                'filename' => $filename,
                'file' => $file,
                'ext' => $ext,
                'size' => $size,
                'finish' => 1,
                'md5' => md5_file($folder . $filename)
            ));
        }
        return $this->returnArray(0, '保存失败');
    }


    /**
     * 图像存储
     * @param $requestFile
     * @param string $folder
     * @return mixed
     */
    public function saveVideo($requestFile, $folder = '')
    {
        $folder = empty($folder) ? $this->uploads : $folder . '/';
        $ext = $requestFile->getClientOriginalExtension();
        $path = $requestFile->getRealPath();
        $size = $requestFile->getSize();
        if (empty($ext) || empty($path)) return $this->returnArray(0, '未能提取到文件信息');
        $file = date('Ymd_his') . '_' . rand(100, 999);
        $filename = $file . '.' . $ext;

        $bool = $requestFile->move(storage_path('app/public/' . $folder), $filename);

//        move_uploaded_file($_FILES["file"]["tmp_name"], storage_path('app/public/media/'). $_FILES["file"]["name"]);

//        $bool = Storage::disk('public')->put($folder . $filename, File::get($path));
        if ($bool) {
            return $this->returnArray(1, '成功', array(
                'path' => $folder . $filename,
                'filename' => $filename,
                'file' => $file,
                'ext' => $ext,
                'size' => $size,
                'finish' => 1,
            ));
        }
        return $this->returnArray(0, '保存失败');
    }


}
