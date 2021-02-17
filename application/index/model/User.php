<?php

namespace app\index\model;
use think\Model;

class User extends Model
{

    // 表名
    protected $name = 'user';
    public function user($where=[]){
        return $this->where($where)->find();
    }
    public function add_user($data=""){
        return $this->insertGetId($data);
    }
}
