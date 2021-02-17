<?php

namespace app\index\model;
use think\Model;
use fast\Tree;
class Company extends Model
{
    public function list($where=[],$paginate="",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            $where_p['id']=$item['pid'];
            $p=$this->where($where_p)->find();
            $item['p_name']=$p['name'];
            $where_r['id']=$item['responsible'];
            $r=db('admin')->where($where_r)->find();
            $item['r_name']=$r['nickname'];
        });
    }
    public function list_all($where=[],$paginate="",$order="id desc"){
        $list=$this->where($where)->order($order)->paginate($paginate);
        Tree::instance()->init($list);
        return Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'name');
    }
    public function find_company($where=[]){
        $find=$this->where($where)->find();
        $where_p['id']=$find['pid'];
        $p=$this->where($where_p)->find();
        $find['p_name']=$p['name'];
        $where_r['id']=$find['responsible'];
        $r=db('admin')->where($where_r)->find();
        $find['r_name']=$r['nickname'];
        return $find;
    }
    public function find_one($where=[]){
        return $this->where($where)->find();
    }
    public function add_company($data=[]){
        return $this->insertGetId($data);
    }
    public function edit_post($where=[],$data=[]){
        return $this->save($data,$where);
    }
}