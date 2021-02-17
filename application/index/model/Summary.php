<?php

namespace app\index\model;
use think\Model;

class Summary extends Model
{
    public function add($data){
        return $this->insertGetId($data);
    }
    public function edit($where,$data){
        return $this->save($data,$where);
    }
    public function find_one($where){
        return $this->where($where)->find();
    }
    public function detail($where){
        $find=$this->where($where)->find();
        return $find;
    }
}
