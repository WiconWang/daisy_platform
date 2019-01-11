<?php
/**
 * 557 用户消息模块.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2019/1/11 4:27 PM
 */

namespace App\Models\System;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MessageModel  extends Model
{
    protected $table = 'messages';
    protected $fillable = ['uid', 'user_type', 'title', 'content',  'status'];
    protected $listable = ['id','uid', 'user_type', 'title', 'status', 'created_at', 'updated_at'];


    public function  getList($where,$skip = 0,$limit = 20)
    {
        return  MessageModel::select(DB::raw(implode(',',$this->listable)))
            ->where($where)
            ->skip($skip)
            ->take($limit)
            ->get();
    }
}
