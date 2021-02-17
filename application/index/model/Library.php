<?php

namespace app\index\model;
use think\Model;

class Library extends Model
{
    public function list($where=[],$paginate="",$order="id desc"){
         return $this->where($where)->order($order)->paginate($paginate);
     }
     public function add($data){
         return $this->insertGetId($data);
     }
     public function edit($where,$data){
         return $this->save($data,$where);
     }
     public function find_one($where){
         return $this->where($where)->find();
     }
}