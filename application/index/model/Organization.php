<?php

namespace app\index\model;
use think\Model;
use fast\Tree;
class Organization extends Model
{
    public function list($where=[],$paginate="",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            $where_c['id']=$item['company_id'];
            $c=db('company')->where($where_c)->find();
            $item['c_name']=$c['name'];
        });
    }
    public function list_all($where=[],$paginate="",$order="id desc"){
        $list=$this->where($where)->order($order)->paginate($paginate);
        Tree::instance()->init($list);
        return Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'name');
    }
    public function find_one($where){
        return $this->where($where)->find();
    }
    public function add_post($data){
        return $this->insertGetId($data);
    }
    public function edit_post($where=[],$data=[]){
        return $this->save($data,$where);
    }
}