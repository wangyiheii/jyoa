<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Menu;
use app\index\model\Admin;
class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $menu= new Menu();
        $menu_list=$menu->list_all();
        $this->assign('menu_list',$menu_list);
        $admin=new Admin();
        $user_where['id']=session('admin')['id'];
        $user=$admin->detail($user_where);
        $this->assign('user',$user);
        return $this->view->fetch();
    }

}
