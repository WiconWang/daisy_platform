<?php
/**
 * 557 daisy_platform.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/13 5:17 PM
 */

namespace App\Services;


use App\Models\System\MessageModel;
use App\Utilities\ResponseHelper;


class MessageService
{
    use ResponseHelper;

    public function countMessages($uid,$user_type,$status)
    {

        $where = array('uid' => $uid,
            'user_type' => $user_type,
            'status' => $status,
        );
        return MessageModel::where($where)->count();
    }

    /**
     * 取列表
     *
     * @param $uid
     * @param $user_type
     * @param $status
     * @return array
     */
    public function getRows($uid,$user_type,$status,$skip = 0, $limit = 20)
    {
        $where = array('uid' => $uid,
            'user_type' => $user_type,
            'status' => $status,
        );
        $rows = (new MessageModel)->getList($where,$skip,$limit);
        if (!empty($rows) || $rows->count > 0 ){
            return $rows->toArray();
        }else{
            return [];
        }
    }

    /**
     * 新建记录
     *
     * @param $data
     * @return mixed
     */
    public function createRow($data)
    {
        return MessageModel::create($data);
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
        return MessageModel::where('id',$id)->update($data);
    }

    public function changeStatus($status,$id)
    {
        return MessageModel::where('id',$id)->update(array('status' => $status));
    }

    /**
     * 按 ID 取记录
     *
     * @param $data
     * @return mixed
     */
    public function getRow($id)
    {
        return MessageModel::find($id);;
    }


    /**
     * 删除行
     *
     * @param $id
     * @return mixed
     */
    public function deleteRow($id)
    {
        $row = MessageModel::find($id);
        return $row->delete();
    }




}