<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Admin;
use app\index\model\Menu;
use app\index\model\Group;
class Authority extends Frontend
{
    public function department(){
        return $this->view->fetch();
    }
    public function personnel(){
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['nickname']=['like',"%".$param['title']."%"];
            $this->assign('title',$param['title']);
        }
        $amdin=new Admin();
        $menu= new Menu();
        $user_list=$amdin->user_all($where,'10');
        $menu_list=[];
        if(!empty($user_list)){
            $nickname=$user_list['0']['nickname'];
            $this->assign('nickname',$nickname);
            $where_menu['u_id']=$user_list['0']['id'];
            $menu_list=$menu->personnel_menu($where_menu);
        }
        $this->assign('menu_list',$menu_list);
        $this->assign('user_list',$user_list);
        return $this->view->fetch();
    }
    public function menu(){
        $param = $this->request->param();
        $admin=new Admin();
        $menu= new Menu();
        $where['id']=$param['id'];
        $user=$admin->detail($where);
        $nickname=$user['nickname'];
        $where_menu['u_id']=$user['id'];
        $menu_list=$menu->personnel_menu($where_menu);
        $data['nickname']=$nickname;
        $data['user_id']=$param['id'];
        $data['menu_list']=$menu_list;
        return ajax_json('1','请求成功',$data);
    }
    public function personnel_post(){
        $param = $this->request->param();
        $Group= new Group();
        $data['u_id']=$param['u_id'];
        $data['rules']=$param['ids'];
        $where['u_id']=$param['u_id'];
        $Group->add_user_group($where,$data);
        return ajax_json('1','保存成功');
    }

}