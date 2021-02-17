<?php

namespace app\index\model;
use think\Model;

class Admin extends Model
{

    // 表名
    protected $name = 'admin';
    public function user($where=[]){
        return $this->where($where)->find();
    }
    public function user_all($where=[],$paginate="",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            $where_d['id']=$item['department'];
            $d=db('organization')->where($where_d)->find();
            $item['d_name']=$d['name'];
        });
    }
    public function add_user($data=""){
        return $this->save($data);
    }
    public function edit_user($where=[],$data=[]){
        return $this->save($data,$where);
    }
    public function detail($where=[]){
        $find=$this->where($where)->find();
        $where_o['id']=$find['department'];
        $o=db('organization')->where($where_o)->find();
        $find['o_name']=$o['name'];
        return $find;
    }
}
