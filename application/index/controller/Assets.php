<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Assets as Massets;
use app\index\model\AssetsClassification;
use app\index\model\Explain;
use app\index\model\Library;
class Assets extends Frontend
{
    public function index(){
        $AssetsClassification= new AssetsClassification();
        $Massets= new Massets();
        $classification=$AssetsClassification->list();
        $where['state']='1';
        if(request()->isPost()){
            $param = $this->request->param();
            $where['title|user|num']=['like',"%".$param['title']."%"];
            $this->assign('title',$param['title']);
        }
        $assets_list=$Massets->list($where);
        $this->assign('classification',$classification);
        $this->assign('assets_list',$assets_list);
        // die("asd");
        return $this->view->fetch();
    }
    public function select(){
        $param = $this->request->param();
        $where['assets_class']=$param['id'];
        $Massets= new Massets();
        $assets_list=$Massets->list($where,'1000');
        return ajax_json('1','请求成功',$assets_list);
    }
    public function add(){
        $AssetsClassification= new AssetsClassification();
        $Library = new Library();
        $Massets= new Massets();
        if(request()->isPost()){
            $param = $this->request->param();
            $return=$Massets->add($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
            
        }
        $classification=$AssetsClassification->list();
        $Library=$Library->list();
        $this->assign('classification',$classification);
        $this->assign('library',$Library);
        return $this->view->fetch();
    }
    public function edit(){
        $AssetsClassification= new AssetsClassification();
        $Massets= new Massets();
        $Library = new Library();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return=$Massets->edit($where,$param);
            if($return){
                return ajax_json('1','修改成功');
            }else{
                return ajax_json('0','修改失败');
            }
        }
        $data=$Massets->find_one($where);
        $this->assign('data',$data);
        $classification=$AssetsClassification->list();
        $Library=$Library->list();
        $this->assign('classification',$classification);
        $this->assign('library',$Library);
        return $this->view->fetch();
    }
    public function detail(){
        $Massets= new Massets();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $data=$Massets->find_one($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function del(){
        $Massets= new Massets();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $Massets->where($where)->delete();
        return ajax_json('1','删除成功');
    }
    public function repair(){
        $param =$this->request->param();
        $Explain= new Explain();
        if(request()->isPost()){
            $return=$Explain->add_explain($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        $this->assign('p_id',$param['id']);
        return $this->view->fetch();
    }
    public function returnse(){
        $param =$this->request->param();
        $Explain= new Explain();
        if(request()->isPost()){
            $return=$Explain->add_explain($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        $this->assign('p_id',$param['id']);
        return $this->view->fetch();
    }
    public function add_classification(){
        $AssetsClassification= new AssetsClassification();
        if(request()->isPost()){
            $param = $this->request->param();
            $return=$AssetsClassification->add($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        $classification=$AssetsClassification->list();
        $this->assign('classification',$classification);
        return $this->view->fetch();
    }
    public function edit_classification(){
        $AssetsClassification= new AssetsClassification();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return=$AssetsClassification->edit($where,$param);
            if($return){
                return ajax_json('1','修改成功');
            }else{
                return ajax_json('0','修改失败');
            }
        }
        $data=$AssetsClassification->find_one($where);
        $this->assign('data',$data);
        $classification=$AssetsClassification->list();
        $this->assign('classification',$classification);
        return $this->view->fetch();
    }
    public function del_classification(){
        $AssetsClassification= new AssetsClassification();
        $param = $this->request->param();
        $where['pid']=$param['id'];
        $p_find=$AssetsClassification->find_one($where);
        if(empty($p_find)){
            $where_del['id']=$param['id'];
            $AssetsClassification->where($where_del)->delete();
            return ajax_json('1','删除成功');
        }else{
            return ajax_json('0','需先删除子类');
        }
    }
}