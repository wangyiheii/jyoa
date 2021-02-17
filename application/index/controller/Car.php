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
        $CcarReserve= new CarReserve();
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
         switch($param['id']){
            case "1":
                $fetch="add";
            break;
            case "2":
                $fetch="register_add";
            break;
            case "3":
                $fetch="reserve_add";
            break;
            case "4":
                $fetch="repair_add";
            break;
            case "5":
                $fetch="maintain_add";
            break;
            case "6":
                $fetch="information_add";
            break;
            case "7":
                $fetch="returnse_add";
            break;
        }
        if(request()->isPost()){
            switch($param['add_id']){
                case "1":
                    $model= new Mcar();
                break;
                case "2":
                    $model= new CarRegister();
                break;
                case "3":
                    $model= new CarReserve();
                break;
                case "4":
                    $model= new CarRepair();
                break;
                case "5":
                    $model= new CarMaintain();
                break;
                case "6":
                    $model="information_add";
                break;
                case "7":
                    $model= new CarReturn();
                break;
            }
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
         switch($param['id']){
            case "1":
                $fetch="edit";
            break;
            case "2":
                $fetch="register_edit";
            break;
            case "3":
                $fetch="reserve_edit";
            break;
            case "4":
                $fetch="repair_edit";
            break;
            case "5":
                $fetch="maintain_edit";
            break;
            case "6":
                $fetch="information_edit";
            break;
            case "7":
                $fetch="returnse_edit";
            break;
        }
        switch($param['edit_id']){
            case "1":
                $model= new Mcar();
            break;
            case "2":
                $model= new CarRegister();
            break;
            case "3":
                $model= new CarReserve();
            break;
            case "4":
                $model= new CarRepair();
            break;
            case "5":
                $model= new CarMaintain();
            break;
            case "6":
                $model="information_edit";
            break;
            case "7":
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