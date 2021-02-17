<?php

namespace app\index\model;
use think\Model;

class LibraryLog extends Model
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
     public function add_log($datas){
         foreach ($datas as $vo){
             $where['id']=$vo['id'];
             $find=db('goods')->where($where)->find();
             $data['title']=$find['title'];
             $data['specifications']=$find['specifications'];
             $data['model']=$find['model'];
             $data['c_id']=$find['c_id'];
             $data['type']="2";
             $data['add_time']=time();
             $data['u_id']=session('admin')['id'];;
             $data['l_id']=$find['l_id'];
             $data['explain']=$find['explain'];
             $data['num']=$vo['num'];
             $this->save($data);
         }
     }
}