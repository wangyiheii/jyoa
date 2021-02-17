<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Finance as M_Finance;
use app\index\model\BillingSelgita;
class Finance extends Frontend
{
    public function cost(){
        $where['type']="1";
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $Finance= new M_Finance();
        $list=$Finance->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function evection(){
        $where['type']="2";
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $Finance= new M_Finance();
        $list=$Finance->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function borrow(){
        $where['type']="3";
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $Finance= new M_Finance();
        $list=$Finance->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function still(){
        $where['type']="4";
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $Finance= new M_Finance();
        $list=$Finance->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function payment(){
        $where['type']="5";
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $Finance= new M_Finance();
        $list=$Finance->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function billing(){
        $where['type']="6";
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $Finance= new M_Finance();
        $list=$Finance->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function billing_edit(){
        $param=$this->request->param();
        $where['id']=$param['id'];
        $Finance= new M_Finance();
        if(request()->isPost()){
            $return=$Finance->edit_finance($where,$param);
            if($return){
                return ajax_json('1','修改成功');
            }else{
                return ajax_json('0','修改失败');
            }
        }
        $data=$Finance->details($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function selgita(){
        $param=$this->request->param();
        if(request()->isPost()){
            $BillingSelgita= new BillingSelgita();
            $return = $BillingSelgita->add_selgita($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        switch($param['type']){
            case "1":
                $fetch="billing_add_add";
            break;
            case "2":
                $fetch="billing_void";
            break;
            case "3":
                $fetch="billing_urge";
            break;
        }
        $this->assign('data',$param);
        return $this->view->fetch($fetch);
    }
    public function add_finance(){
        $Finance= new M_Finance();
        $param = $this->request->param();
        if(request()->isPost()){
            $param['u_id']=session('admin')['id'];
            if(!empty($param['apply_time'])){
                $param['apply_time']=strtotime($param['apply_time']);
            }
            if(!empty($param['detailed'])){
                $param['detailed']=serialize($param['detailed']);
            }
            $return=$Finance->add($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','删除失败');
            }
        }
        switch($param['id']){
            case "1":
                $fetch="cost_add";
            break;
            case "2":
                $fetch="evection_add";
            break;
            case "3":
                $fetch="borrow_add";
            break;
            case "4":
                $fetch="still_add";
            break;
            case "5":
                $fetch="payment_add";
            break;
            case "6":
                $fetch="billing_add";
            break;
        }
        return $this->view->fetch($fetch);
    }
    public function details(){
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Finance= new M_Finance();
        $find=$Finance->details($where);
        $find['detailed']=unserialize($find['detailed']);
        switch($find['type']){
            case "1":
                $fetch="cost_details";
            break;
            case "2":
                $fetch="evection_details";
            break;
            case "3":
                $fetch="borrow_details";
            break;
            case "4":
                $fetch="still_details";
            break;
            case "5":
                $fetch="payment_details";
            break;
            case "6":
                $fetch="billing_details";
            break;
        }
        $this->assign('data',$find);
        return $this->view->fetch($fetch);
    }
    public function del(){
        $param = $this->request->param();
        $Finance= new M_Finance();
        $where_del['id']=$param['id'];
        $Finance->where($where_del)->delete();
        return ajax_json('1','删除成功');
    }
}