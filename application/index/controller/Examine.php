<?php

namespace app\index\controller;
use app\common\controller\Frontend;
use app\index\model\Examine as MExamine;
use app\index\model\Admin;
class Examine extends Frontend
{
    public function index(){
        $MExamine= new MExamine();
        $admin=new Admin();
        $user_where['id']=session('admin')['id'];
        $user=$admin->detail($user_where);
        $where['d_id']=['in',$user['department'].",".$user['departments']];
        $list=$MExamine->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        
    }
}