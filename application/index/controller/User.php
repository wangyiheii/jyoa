<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Admin;
use app\index\model\Company;
use app\index\model\DetailsLog;
class User extends Frontend
{
    public function index(){
        $admin=new Admin();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['username|nickname|phone_num|phone']=$param['title'];
            $this->assign('title',$param['title']);
        }
        $user_list=$admin->user_all($where,20);
        $this->assign('user_list',$user_list);
        return $this->view->fetch();
    }
    public function add(){
        $Company = new Company();
        $admin=new Admin();
        if(request()->isPost()){
            $param = $this->request->param();
            $param['salt']=rand();
            $param['password']=md5($param['password'].$param['salt']);
            $return=$admin->add_user($param);
            if($return){
                $u_id=session('admin')['id'];
                details_handle_log('添加','添加成功',$u_id,'',$return,'3');
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        $company_list=$Company->list_all();
        $this->assign('company_list',$company_list);
        return $this->view->fetch();
    }
    public function edit(){
        $admin=new Admin();
        $Company = new Company();
        $param = $this->request->param();
        $where['id']=$param['id'];
        if(request()->isPost()){
            if($param['password']){
                $param['salt']=rand();
                $param['password']=md5($param['password'].$param['salt']);
            }
            $return=$admin->edit_user($where,$param);
            if($return){
                $u_id=session('admin')['id'];
                details_handle_log('修改','修改成功',$u_id,'',$return,'3');
                return ajax_json('1','修改成功');
            }else{
                return ajax_json('0','修改失败');
            }
        }
        $company_list=$Company->list_all();
        $this->assign('company_list',$company_list);
        $data=$admin->detail($where);
        $this->assign('data',$data);
        return $this->view->fetch();
    }
    public function detail(){
        $param = $this->request->param();
        $u_id=session('admin')['id'];
        details_consult_log($u_id,$param['id'],'3');
        $where['id']=$param['id'];
        $admin=new Admin();
        $data=$admin->detail($where);
        $this->assign('data',$data);
        $DetailsLog= new DetailsLog();
        $where_log['is_d']="3";
        $where_log['d_id']=$param['id'];
        $handle_log=$DetailsLog->handle_log($where_log);
        $consult_log=$DetailsLog->consult_log($where_log);
        $this->assign('handle_log',$handle_log);
        $this->assign('consult_log',$consult_log);
        return $this->view->fetch();
    }
    public function del(){
        $admin=new Admin();
        $param = $this->request->param();
        if($param['id']=="1"){
          return ajax_json('0','删除失败不可删除管理员');  
        }
        $where['id']=$param['id'];
        $admin->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}