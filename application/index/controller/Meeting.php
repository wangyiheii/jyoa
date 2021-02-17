<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Meeting as Mmeeting;
use app\index\model\Summary;
class Meeting extends Frontend
{
    public function index(){
        $Mmeeting= new Mmeeting();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mmeeting->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $Mmeeting= new Mmeeting();
        if(request()->isPost()){
            $param = $this->request->param();
            $return= $Mmeeting->add($param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch();
    }
    public function edit(){
        $Mmeeting= new Mmeeting();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Mmeeting->edit($where,$param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        $data = $Mmeeting->find_one($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function summary(){
        $Summary= new Summary();
        $param = $this->request->param();
        if(request()->isPost()){
            $param['u_id']=session('admin')['id'];
            $return= $Summary->add($param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
            
        }
        $this->assign('meeting_id',$param['id']);
        $user=applicant(session('admin')['id']);
        $this->assign('user',$user);
        return $this->view->fetch();
    }
    public function detail(){
        $Mmeeting= new Mmeeting();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $data=$Mmeeting->detail($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function del(){
        $Mmeeting= new Mmeeting();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Mmeeting->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}