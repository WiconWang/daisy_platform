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

    public function getAll(){
        $count = ChannelModel::count();
        $list = ChannelModel::get();
        if (empty($count)) return  $this->formatList($count, $list);

        $res = $this->listToNest($list->toArray());
        
        echo "<pre>";
        print_r($res);
        exit;
        return $res;
    }

    public function getList(Request $request){
        $count = ChannelModel::count();
        $list = ChannelModel::get();
    }


    private function listToNest($rows){
        return $this->getTree($rows, 0);
    }

    private  function getTree($data, $pId)
    {
        $tree = '';
        foreach($data as $k => $v)
        {
            if($v['fid'] == $pId)
            {
                $v['fid'] = $this->getTree($data, $v['fid']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }



}