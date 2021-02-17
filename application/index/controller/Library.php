<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Library as Mlibrary;
use app\index\model\LibraryLog;
class Library extends Frontend
{
    public function index(){
        $Mlibrary= new Mlibrary();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mlibrary->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $Mlibrary= new Mlibrary();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mlibrary->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function edit(){
        $Mlibrary= new Mlibrary();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Mlibrary->edit($where,$param);
            if($return){
                 return ajax_json('1','修改成功');
            }else{
                 return ajax_json('0','修改失败');
            }
        }
        $data = $Mlibrary->find_one($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function del(){
        $Mlibrary= new Mlibrary();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Mlibrary->where($where)->delete();
        return ajax_json('1','删除成功');
    }
    public function operation(){
        return $this->view->fetch();
    }
    public function details(){
        $LibraryLog= new LibraryLog();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$LibraryLog->list($where);
        $this->assign('list',$list);
        return $this->view->fetch(); 
    }
    public function details_del(){
        $LibraryLog= new LibraryLog();
        $param = $this->request->param();
        $where['id']=['in',implode(',',$param['id'])];
        $LibraryLog->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}