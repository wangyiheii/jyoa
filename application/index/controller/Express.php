<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Express as Mexpress;
class Express extends Frontend
{
    public function index(){
        $Mexpress= new Mexpress();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mexpress->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $Mexpress= new Mexpress();
        if(request()->isPost()){
            $param = $this->request->param();
            $return= $Mexpress->add($param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch();
    }
    public function edit(){
        $Mexpress= new Mexpress();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Mexpress->edit($where,$param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        $data = $Mexpress->find_one($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function detail(){
        $Mexpress= new Mexpress();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $data=$Mexpress->detail($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function del(){
        $Mexpress= new Mexpress();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Mexpress->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}