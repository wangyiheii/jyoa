<?php

namespace app\index\controller;
use app\common\controller\Frontend;
use app\index\model\Car as Mcar;
use app\index\model\CarRegister;
use app\index\model\CarReserve;
use app\index\model\CarReservation;
use app\index\model\CarMaintain;
use app\index\model\CarReturn;
class Car extends Frontend
{
    public function index(){
        $Mcar= new Mcar();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mcar->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function register(){
        $CarRegister= new CarRegister();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$CarRegister->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function reserve(){
        $CarReserve= new CarReserve();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$CarReserve->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function reservation(){
        $CarReservation= new CarReservation();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$CarReservation->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function repair(){
        $CarReservation= new CarReservation();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$CarReservation->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function maintain(){
        $CarMaintain= new CarMaintain();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$CarMaintain->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function information(){
        $Mcat= new Mcat();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$Mtravel->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function returnse(){
        $McarReturn= new McarReturn();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['']=$param[''];
        }
        $list=$McarReturn->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
         $param = $this->request->param();
         switch($param['add_id']){
            case "1":
                $fetch="add";
                $model= new Mcar();
            break;
            case "2":
                $fetch="register_add";
                $model= new CarRegister();
            break;
            case "3":
                $fetch="reserve_add";
                $model= new CarReserve();
            break;
            case "4":
                $fetch="repair_add";
                $model= new CarRepair();
            break;
            case "5":
                $fetch="maintain_add";
                $model= new CarMaintain();
            break;
            case "6":
                $fetch="information_add";
                $model= new Mcar();
            break;
            case "7":
                $fetch="returnse_add";
                $model= new CarReturn();
            break;
        }
        if(request()->isPost()){
            $return=$model->add($param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch($fetch);
    }
    public function edit(){
         $param = $this->request->param();
         $where['id']=$param['id'];
         switch($param['edit_id']){
            case "1":
                $fetch="edit";
                $model= new Mcar();
            break;
            case "2":
                $fetch="register_edit";
                $model= new CarRegister();
            break;
            case "3":
                $fetch="reserve_edit";
                $model= new CarReserve();
            break;
            case "4":
                $fetch="repair_edit";
                $model= new CarRepair();
            break;
            case "5":
                $fetch="maintain_edit";
                $model= new CarMaintain();
            break;
            case "6":
                $fetch="information_edit";
                $model= new Mcar();
            break;
            case "7":
                $fetch="returnse_edit";
                $model= new CarReturn();
            break;
        }
        if(request()->isPost()){
            $return=$model->edit($param,$where);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }  
        }
        $data=$model->find_one($where);
        return $this->view->fetch($fetch);
    }
    public function details(){
         $param = $this->request->param();
         switch($param['details_id']){
            case "1":
                $fetch="details";
                $model= new Mcar();
            break;
            case "2":
                $fetch="register_details";
                $model= new CarRegister();
            break;
            case "3":
                $fetch="reserve_details";
                $model= new CarReserve();
            break;
            case "4":
                $fetch="repair_details";
                $model= new CarRepair();
            break;
            case "5":
                $fetch="maintain_details";
                $model= new CarMaintain();
            break;
            case "6":
                $fetch="information_details";
                $model= new Mcar();
            break;
            case "7":
                $fetch="returnse_details";
                $model= new CarReturn();
            break;
        }
        $where['id']=$param['id'];
        $data=$model->details($where);
        return $this->view->fetch($fetch);
    }
}