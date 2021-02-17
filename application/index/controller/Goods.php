<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Goods as Mgoods;
use app\index\model\Library;
use app\index\model\Collect;
use app\index\model\Transfer;
use app\index\model\AssetsClassification;
use app\index\model\LibraryLog;
class Goods extends Frontend
{
    public function collect(){
        $Collect= new Collect();
        $param = $this->request->param();
        $where=[];
        if(request()->isPost()){
            $where['']=$param[''];
        }
        $list=$Collect->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function collect_add(){
        $Collect= new Collect();
        $LibraryLog= new LibraryLog();
        $param = $this->request->param();
        if(request()->isPost()){
            $LibraryLog->add_log($param['goods']);
            $return =$Collect->add($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch();
    }
    public function collect_detail(){
        $Collect= new Collect();
        $param = $this->request->param();
        
        $where['id']=$param['id'];
        $data=$Collect->detail($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function collect_del(){
        $Collect= new Collect();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Collect->where($where)->delete();
        return ajax_json('1','删除成功');
    }
    public function transfer(){
        $Transfer= new Transfer();
        $where=[];
        $param = $this->request->param();
        if(request()->isPost()){
            $where['']=$param[''];
        }
        $list=$Transfer->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function transfer_add(){
        $Collect= new Collect();
        $LibraryLog= new LibraryLog();
        $param = $this->request->param();
        if(request()->isPost()){
            $LibraryLog->add_log($param['goods']);
            $return =$Collect->add($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch();
    }
    public function transfer_detail(){
        $Transfer= new Transfer();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $data=$Transfer->detail($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function transfer_del(){
        $Transfer= new Transfer();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Transfer->where($where)->delete();
        return ajax_json('1','删除成功');
    }
    public function Inventory(){
        $Mgoods= new Mgoods();
        $where=[];
        $param = $this->request->param();
        if(request()->isPost()){
            $where['']=$param[''];
        }
        $list=$Mgoods->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function Inventory_add(){
        $Mgoods= new Mgoods();
        $AssetsClassification= new AssetsClassification();
        $Library= new Library();
        if(request()->isPost()){
            $param = $this->request->param();
            $return= $Mgoods->add($param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        //仓库
        $library_list=$Library->list();
        //分类
        $classification=$AssetsClassification->list();
        $this->assign('classification',$classification);
        $this->assign('library',$library_list);
        return $this->view->fetch();
    }
    public function Inventory_edit(){
        $Mgoods= new Mgoods();
        $AssetsClassification= new AssetsClassification();
        $Library= new Library();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Mgoods->edit($where,$param);
            if($return){
                 return ajax_json('1','添加成功');
            }else{
                 return ajax_json('0','添加失败');
            }
        }
        $data = $Mgoods->find_one($where);
        $this->assign('data',$data);
        $library_list=$Library->list();
        //分类
        $classification=$AssetsClassification->list();
        $this->assign('classification',$classification);
        $this->assign('library',$library_list);
        return $this->view->fetch();
    }
    public function Inventory_del(){
        $Mgoods= new Mgoods();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Mgoods->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}