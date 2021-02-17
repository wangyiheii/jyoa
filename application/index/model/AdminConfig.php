<?php

namespace app\index\model;
use think\Model;

class AdminConfig extends Model
{

    // 表名
    protected $name = 'admin_config';
    public function config($where=""){
        return $this->where($where)->select();
    }
    public function config_edit($where,$data){
        return $this->save($data,$where);
    }
}