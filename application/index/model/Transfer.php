<?php

namespace app\index\model;
use think\Model;

class Transfer extends Model
{
    public function list($where=[],$paginate="10",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            
        });
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
    public function detail($where){
        $find=$this->where($where)->find();
        return $find;
    }
    
}