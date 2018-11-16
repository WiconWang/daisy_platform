<?php
/**
 * 557 daisy_platform.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/13 5:17 PM
 */

namespace App\Services;


use App\Models\Component\BannerModel;
use App\Utilities\ResponseHelper;
use Illuminate\Http\Request;


class BannerService
{
    use ResponseHelper;

    /**
     * 取列表
     *
     * @param int $classification
     * @return array
     */
    public function getRows($classification = 0)
    {
        $count = BannerModel::where('classification', $classification)->count();
        $rows = BannerModel::where('classification', $classification)->get();
        $list = [];
        if (!empty($count)) $list = $rows->toArray();
        return $this->formatList($count, $list);
    }

    /**
     * 新建记录
     *
     * @param $data
     * @return mixed
     */
    public function createRow($data)
    {
        return BannerModel::create($data);
    }

    /**
     * 新建记录
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function editRow($data,$id)
    {
        return BannerModel::where('id',$id)->update($data);
    }

    /**
     * 按 ID 取记录
     *
     * @param $data
     * @return mixed
     */
    public function getRow($id)
    {
        return BannerModel::find($id);;
    }


    /**
     * 删除行
     *
     * @param $id
     * @return mixed
     */
    public function deleteRow($id)
    {
        $row = BannerModel::find($id);
        return $row->delete();
    }




}