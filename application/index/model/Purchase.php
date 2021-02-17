<?php

namespace app\index\model;
use think\Model;

class Purchase extends Model
{
    public function list($where=[],$paginate="10",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item,$key){
            $where_u['id']=$item['u_id'];
            $u=db('admin')->where($where_u)->find();
            $item['user_name']=$u['nickname'];
            $where_o['id']=$u['department'];
            $o=db('organization')->where($where_o)->find();
            $item['o_name']=$o['name'];
            $where_s['id']=$item['supplier_id'];
            $s=db('supplier')->where($where_s)->find();
            $item['supplier_name']=$s['title'];
        });
    }
    public function detail($where=[]){
        $find=$this->where($where)->find();
        $where_s['id']=$find['supplier_id'];
        $s=db('supplier')->where($where_s)->find();
        $find['supplier_name']=$s['title'];
        $where_u['id']=$find['u_id'];
        $u=db('admin')->where($where_u)->find();
        $find['user_name']=$u['nickname'];
        $where_o['id']=$u['department'];
        $o=db('organization')->where($where_o)->find();
        $find['o_name']=$o['name'];
        return $find;
    }
    public function add_purchase($data){
        return $this->insertGetId($data);
    }
}