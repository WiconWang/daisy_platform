<?php
/**
 * 557 daisy_platform.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/11/13 5:17 PM
 */

namespace App\Services;


use App\Models\Admins\InfoModel as InfoModel;
use App\Utilities\ResponseHelper;


class AdminService
{
    use ResponseHelper;

    /**
     * 取列表
     *
     * @param int $fid
     * @return array
     */
    public function getRows()
    {
        $count = InfoModel::count();
        $rows = InfoModel::get();
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
        $emptyData =array('mobile'=>'','password'=>'','username'=>'');
        list($code,$msg,$saveData) =$this->filterData($data,$emptyData);
        if ($code != 1 ){
            return $this->returnArray($code,$msg);
        }
        $res = InfoModel::create($saveData);
        if ($res){
            return $this->returnArray(1,'SUCCESS');
        }else{
            return $this->returnArray(0,'ERROR');
        }
    }

    /**
     * 调整记录
     *
     * @param $data
     * @return mixed
     */
    public function editRow($data,$id)
    {
        $existData =  InfoModel::find($id);
        if (!$existData){
            return $this->returnArray(0,'RECORD_NOT_FOUND');
        }

        list($code,$msg,$saveData) =$this->filterData($data, $existData-> toArray());
        if ($code != 1 ){
            return $this->returnArray($code,$msg);
        }
        $res = InfoModel::where('id',$id)->update($saveData);
        if ($res){
            return $this->returnArray(1,'SUCCESS');
        }else{
            return $this->returnArray(0,'ERROR');
        }
    }

    private function filterData($data,$existData){
        $saveData = [];
        if (isset($data['password']) && isset($existData['password']) && !empty($data['password']) && ($data['password'] != $existData['password'])) {
            $saveData['password'] = bcrypt($data['password']);
        }
        //检测手机号是否重复
        if (isset($data['mobile']) && isset($existData['mobile']) && !empty($data['mobile']) && ($data['mobile'] != $existData['mobile'])) {
            $counts = InfoModel::where('mobile', $data['mobile'])->count();
            if ($counts) {
                return $this->returnArray(0,'USER_MOBILE_IS_EXIST');
            }else{
                $saveData['mobile'] = $data['mobile'];
            }
        }
        //检测用户名是否重复
        if (isset($data['username']) && isset($existData['username']) && !empty($data['username']) && ($data['username'] != $existData['username'])) {
            $counts = InfoModel::where('username', $data['username'])->count();
            if ($counts) {
                return $this->returnArray(0,'USER_NAME_IS_EXIST');
            }else{
                $saveData['username'] = $data['username'];
            }
        }
        if (isset($data['level'])) { $saveData['level'] = $data['level']; }
        if (isset($data['cover'])) { $saveData['cover'] = $data['cover']; }
        if (isset($data['email'])) { $saveData['email'] = $data['email']; }
        if (isset($data['out_date']) && !empty($data['out_date'])) {
            $saveData['out_date']= date('Y-m-d', strtotime($data['out_date']));
        }
        if (empty($saveData)){
            return $this->returnArray(0,'FORM_LACK');
        }
        return  $this->returnArray(1,'', $saveData);
    }

    /**
     * 按 ID 取记录
     *
     * @param $data
     * @return mixed
     */
    public function getRow($id)
    {
        return InfoModel::find($id);
    }


    /**
     * 删除行
     *
     * @param $id
     * @return mixed
     */
    public function deleteRow($id)
    {
        $row = InfoModel::find($id);
        return $row->delete();
    }



}