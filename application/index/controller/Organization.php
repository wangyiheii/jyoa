<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Organization as M_Organization;
use app\index\model\Company;
use fast\Tree;
class Organization extends Frontend
{
    public function index(){
        $Organization= new M_Organization();
        if(request()->isPost()){
            $param = $this->request->param();
        }
        $ruleList=$Organization->list();
        Tree::instance()->init($ruleList);
        $list= Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'name');

        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $Organization= new M_Organization();
        if(request()->isPost()){
            $param = $this->request->param();
            $return= $Organization->add_post($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        $organization_list=$Organization->list_all();
        $this->assign('o_list',$organization_list);
        $Company=new Company();
        $company_list=$Company->list_all();
        $this->assign('c_list',$company_list);
        return $this->view->fetch();
    }
    public function edit(){
        $param = $this->request->param();
        $Organization= new M_Organization();
        $where['id']=$param['id'];
        if(request()->isPost()){
            $return= $Organization->edit_post($where,$param);
            if($return){
                return ajax_json('1','修改成功');
            }else{
                return ajax_json('0','修改失败');
            }
        }
        $data=$Organization->find_one($where);
        $this->assign('data',$data);
        $organization_list=$Organization->list_all();
        $this->assign('o_list',$organization_list);
        $Company=new Company();
        $company_list=$Company->list_all();
        $this->assign('c_list',$company_list);
        return $this->view->fetch();
    }
    public function del(){
        $param = $this->request->param();
        $where['pid']=$param['id'];
        $Organization= new M_Organization();
        $p_find=$Organization->find_one($where);
        if(empty($p_find)){
            $where_del['id']=$param['id'];
            $Organization->where($where_del)->delete($param['id']);
            return ajax_json('1','删除成功');
        }else{
            return ajax_json('0','需先删除子类');
        }
    }
}