<?php

namespace app\index\model;
use think\Model;

class Group extends Model
{
    public function add_user_group($where,$data){
        $find=$this->where($where)->find();
        if(empty($find)){
            return $this->save($data);
        }else{
            return $this->save($data,$where);
        }
    }

}