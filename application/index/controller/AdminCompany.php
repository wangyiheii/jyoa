<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Admin as Madmin;
use app\index\model\DetailsLog;
use app\index\model\Company;
use fast\Tree;
class AdminCompany extends Frontend
{
    public function index(){
        $Company = new Company();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['name']=['like','%'.$param['title'].'%'];
            $this->assign('title',$param['title']);
        }
        $ruleList=$Company->list($where);
        Tree::instance()->init($ruleList);
        $list= Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'name');
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $Company = new Company();
        if(request()->isPost()){
            $param = $this->request->param();
            $return=$Company->add_company($param);
            if($return){
                $u_id=session('admin')['id'];
                details_handle_log('添加','添加成功',$u_id,'',$return,'1');
                return ajax_json('1','添加成功');
                // $this->success('添加成功',url('index'));
            }else{
                return ajax_json('0','添加失败');
                // $this->error('添加失败');
            }
        }
        $company_list=$Company->list_all();
        $this->assign('company_list',$company_list);
        $Madmin=new Madmin();
        $user_list=$Madmin->user_all('','','id asc');
        $this->assign('user_list',$user_list);
        return $this->view->fetch();
    }
    public function edit(){
        $param = $this->request->param();
        $Company = new Company();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Company->edit_post($where,$param);
            if($return){
                return ajax_json('1','修改成功');
            }else{
                return ajax_json('0','修改失败');
            }
        }
        $data=$Company->find_one($where);
        $company_list=$Company->list_all();
        $this->assign('company_list',$company_list);
        $Madmin=new Madmin();
        $user_list=$Madmin->user_all('','','id asc');
        $this->assign('user_list',$user_list);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function del(){
        $param = $this->request->param();
        $where['pid']=$param['id'];
        $Company= new Company();
        $p_find=$Company->find_one($where);
        if(empty($p_find)){
            $where_del['id']=$param['id'];
            $Company->where($where_del)->delete();
            return ajax_json('1','删除成功');
        }else{
            return ajax_json('0','需先删除子类');
        }
        
    }
    public function detail($id){
        $u_id=session('admin')['id'];
        details_consult_log($u_id,$id,'1');
        $where['id']=$id;
        $Company= new Company();
        $data=$Company->find_company($where);
        $DetailsLog= new DetailsLog();
        $where_log['is_d']="1";
        $where_log['d_id']=$id;
        $handle_log=$DetailsLog->handle_log($where_log);
        $consult_log=$DetailsLog->consult_log($where_log);
        $this->assign('handle_log',$handle_log);
        $this->assign('consult_log',$consult_log);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
}