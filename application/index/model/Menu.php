<?php

namespace app\index\model;
use think\Model;
use fast\Tree;
class Menu extends Model
{
    public function  personnel_menu($where=[]){
        $where_menu['enable']="1";
        $where_menu['show']="1";
        $menu=$this->where($where_menu)->select();
        Tree::instance()->init($menu);
        $list=Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
        foreach($list as $key=>$va){
            $find=db('group')->where($where)->where('FIND_IN_SET(:id,rules)',['id'=>$va['id']])->find();
            if($find){
                $select=true;
            }else{
                $select=false;
            }
            $list[$key]['select']=$select;
        }
        return $list;
    }
    public function list_all(){
        $where_menu['enable']="1";
        $where_menu['show']="1";
        $admin=session('admin');
        $where_admin['id']=$admin['id'];
        $admin_find=db('admin')->where($where_admin)->find();
        if($admin_find['is_admin']!='1'){
            $where_g['u_id']=$admin['id'];
            $oa_group=db('group')->where($where_g)->find();
            $where_menu['id']=['in',$oa_group['rules']];    
        }
        $menu=$this->where($where_menu)->order('sort')->select();
        $list=$this->getTree($menu,'0');
        return $list;
    }
    public function getTree($data, $pId){
        $tree =[];
        foreach($data as $k => $v){
            if($v['pid'] == $pId){
            //父亲找到儿子
            $v['son_data']= $this->getTree($data, $v['id']);
            if(empty($v['son_data'])){
                $v['is_son']="1";
            }else{
                $v['is_son']="0";
            }
            $tree[] = $v;
            }
        }
        return $tree;
    }
}