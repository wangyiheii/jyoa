<?php

namespace app\index\model;
use think\Model;

class AdminLog extends Model
{

    // 表名
    protected $name = 'admin_log';
    public function log_list_all($where=[],$paginate="10"){
        return $this->where($where)->order('id desc')->paginate($paginate);
    }
}
