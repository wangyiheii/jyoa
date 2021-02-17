<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Admin as Madmin;
class Admin extends Frontend
{
    //查看个人设置//更改个人设置
    public function set_up(){
        $Admin=new Madmin();
        $where['id']=session('admin')['id'];
        if(request()->isPost()){
            $param = $this->request->param();
            $Admin->edit_user($where,$param);
            admin_logse(session('admin')['id'],session('admin')['username'],request()->url(),'修改个人设置','修改成功');
            $this->success('修改成功');
        }
        $data=$Admin->user($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function newpass(){
        $param = $this->request->param();
        $Admin=new Madmin();
        $where['id']=session('admin')['id'];
        $find=$Admin->user($where);
        $where['password']=md5($param['used_password'].$find['salt']);
        $is_find=$Admin->user($where);
        if(!empty($is_find)){
            $salt=rand();
            $data['salt']=$salt;
            $data['password']=md5($param['password'].$salt);
            $Admin->edit_user($where,$data);
            admin_logse($is_find['id'],$is_find['nickname'],request()->url(),'修改密码','修改密码成功');
            $this->success('修改成功');  
        }else{
            admin_logse($find['id'],$find['nickname'],request()->url(),'修改密码','修改密码失败[密码错误]');
            $this->error('旧密码错误');
        }
        
    }
}