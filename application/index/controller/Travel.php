<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Travel as Mtravel;
class Travel extends Frontend
{
   public function index(){
        $Mtravel= new Mtravel();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mtravel->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $Mtravel= new Mtravel();
        if(request()->isPost()){
            $param = $this->request->param();
            $return= $Mtravel->add($param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch();
    }
    public function edit(){
        $Mtravel= new Mtravel();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Mtravel->edit($where,$param);
            if($return){
                 return ajax_json('1','修改成功');
            }else{
                 return ajax_json('0','修改失败');
            }
        }
        $data = $Mtravel->find_one($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function detail(){
        $Mtravel= new Mtravel();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $data=$Mtravel->detail($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function del(){
        $Mtravel= new Mtravel();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Mtravel->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}