<?php
/**
 * 557 daisy_platform.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/13 下午9:58
 */

namespace App\Services;


use App\Utilities\ResponseHelper;
use App\Models\Articles\ArticleModel;

class ArticleService
{

    use ResponseHelper;

    /**
     * 取列表
     *
     * @param int $cid
     * @param int $author_id
     * @param int $skip
     * @param int $take
     * @return array
     */
    public function getRows($cid = 0, $author_id = 0, $skip = 0, $take = 0)
    {
        $where = array('author_id' => $author_id);
        if ($cid != 0) {
            $where['cid'] = $cid;
        }

        $count = ArticleModel::where($where)->count();
        $rows = ArticleModel::where($where)->orderBy('id', 'desc')->skip($skip)->take($take)->get();
        return $this->formatList($count, $rows);
    }

    /**
     * 新建记录
     *
     * @param $data
     * @return mixed
     */
    public function createRow($data)
    {
        return ArticleModel::create($data);
    }

    /**
     * 新建记录
     *
     * @param $data
     * @return mixed
     */
    public function editRow($data, $id)
    {
        return ArticleModel::where('id', $id)->update($data);
    }

    /**
     * 按 ID 取记录
     *
     * @param $data
     * @return mixed
     */
    public function getRow($id)
    {
        return ArticleModel::find($id);;
    }


    /**
     * 删除行
     *
     * @param $id
     * @return mixed
     */
    public function deleteRow($id)
    {
        $row = ArticleModel::find($id);
        return $row->delete();
    }
}