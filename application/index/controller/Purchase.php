<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Purchase as M_Purchase;
use app\index\model\Supplier;
use app\index\model\Admin;
use app\index\model\DetailsLog;
class Purchase extends Frontend
{
    public function index(){
        $M_Purchase = new M_Purchase();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['name']=['like','%'.$param['title'].'%'];
            $this->assign('title',$param['title']);
        }
        $list=$M_Purchase->list($where);
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function add(){
        $M_Purchase = new M_Purchase();
        if(request()->isPost()){
            $param = $this->request->param();
            $u_id=session('admin')['id'];
            $param['u_id']=$u_id;
            $param['goods']=serialize($param['goods']);
            $return =  $M_Purchase -> add_purchase($param);
            $AuditProcess=AuditProcess($return);
            if($return){
                details_handle_log('添加','添加成功',$u_id,'待审核',$return,'4');
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        $Supplier= new Supplier();
        $Admin= new Admin();
        $supplier_list= $Supplier->list();
        $where_u['id']=session('admin')['id'];
        $user=$Admin->detail($where_u);
        $this->assign('supplier_list',$supplier_list);
        $this->assign('user',$user);
        return $this->view->fetch();
    }
    public function detail(){
        $DetailsLog= new DetailsLog();
        $M_Purchase = new M_Purchase();
        $u_id=session('admin')['id'];
        $param = $this->request->param();
        details_consult_log($u_id,$param['id'],'4');
        $where['id']=$param['id'];
        $data=$M_Purchase->detail($where);
        $this->assign('data',$data);
        $where_log['is_d']="4";
        $where_log['d_id']=$param['id'];
        $handle_log=$DetailsLog->handle_log($where_log);
        $consult_log=$DetailsLog->consult_log($where_log);
        $this->assign('handle_log',$handle_log);
        $this->assign('consult_log',$consult_log);
        return $this->view->fetch();
    }
    public function del(){
        $param = $this->request->param();
        $M_Purchase = new M_Purchase();
        $where_del['id']=$param['id'];
        $M_Purchase->where($where_del)->delete();
        return ajax_json('1','删除成功');
    }
}