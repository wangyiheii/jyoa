<?php

namespace app\index\model;
use think\Model;

class Finance extends Model
{
    public function list($where=[],$paginate="10",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            $where_u['id']=$item['u_id'];
            $u=db('admin')->where($where_u)->find();
            $item['user_name']=$u['nickname'];
            $where_o['id']=$u['department'];
            $o=db('organization')->where($where_o)->find();
            $item['o_name']=$o['name'];
        });
    }
    public function add($data){
        return $this->insertGetId($data);
    }
    public function details($where=[]){
        return $this->where($where)->find();
    }
    public function edit_finance($where,$data){
        return $this->save($data,$where);
    }
}