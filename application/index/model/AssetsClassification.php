<?php

namespace app\index\model;
use think\Model;
use fast\Tree;
class AssetsClassification extends Model
{
    public function list($where=[],$paginate="",$order="sort desc"){
        $menu=$this->where($where)->select();
        Tree::instance()->init($menu);        
        $list=Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
        return $list;
    }
    public function add($data){
        return $this->insertGetId($data);
    }
    public function edit($where,$data){
        return $this->save($data,$where);
    }
    public function find_one($where=[]){
        return $this->where($where)->find();
    }
    
}