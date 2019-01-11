<?php
/**
 * 557 daisy_platform.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/13 5:17 PM
 */

namespace App\Services;


use App\Models\Channels\InfoModel as ChannelModel;
use App\Utilities\ResponseHelper;
use Illuminate\Http\Request;


class ChannelService
{
    use ResponseHelper;

    /**
     * 取列表
     *
     * @param int $fid
     * @return array
     */
    public function getRows($fid = 0)
    {
        $count = ChannelModel::where('fid', $fid)->count();
        $rows = ChannelModel::get();
        $list = [];
        if (!empty($count)) $list = $this->getTree($rows->toArray(), $fid);
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
        if (isset($data['position'])) { $data['position'] = implode(',',$data['position']);}
        return ChannelModel::create($data);
    }

    /**
     * 新建记录
     *
     * @param $data
     * @return mixed
     */
    public function editRow($data,$id)
    {
        if (isset($data['position'])) { $data['position'] = implode(',',$data['position']);}
        return ChannelModel::where('id',$id)->update($data);
    }

    /**
     * 按 ID 取记录
     *
     * @param $data
     * @return mixed
     */
    public function getRow($id)
    {
        return ChannelModel::find($id);;
    }


    /**
     * 删除行
     *
     * @param $id
     * @return mixed
     */
    public function deleteRow($id)
    {
        // 删除时检测是否有下层栏目，如有则禁止删除
        $hasChildren = ChannelModel::where('fid', $id)->count();
        if (!empty($hasChildren)) return 'has_children';
        $row = ChannelModel::find($id);
        return $row->delete();
    }

    /**
     * 无限分类拼合
     *
     * @param $data
     * @param $fid
     * @return array
     */
    private function getTree($data, $fid)
    {
        $tree = [];
        foreach ($data as $k => $v) {
            if ($v['fid'] == $fid) {
                $v['children'] = $this->getTree($data, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }


}