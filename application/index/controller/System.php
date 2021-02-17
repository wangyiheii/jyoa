<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\AdminLog;
use app\index\model\AdminConfig;
class System extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function admin_log(){
        $AdminLog=new AdminLog();
        $where=[];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['username|title|ip']=['like',"%".$param['title']."%"];
            $this->assign('title',$param['title']);
        }
        $log_list=$AdminLog->log_list_all($where);
        $this->assign('log_list',$log_list);
        return $this->view->fetch();
    }
    public function admin_log_delall(){
        $param = $this->request->param();
        $where['id']=['in',implode(',',$param['ids'])];
        $AdminLog=new AdminLog();
        $AdminLog->where($where)->delete();
        return ajax_json('1','删除成功');
    }
    public function config(){
        $AdminConfig= new AdminConfig();
        if(request()->isPost()){
            $param = $this->request->param();
            foreach($param as $key=>$val){
                $where['name']=$key;
                $where['group']="admin";
                $data['value']=$val;
                $config=$AdminConfig->config_edit($where,$data);
            }
            admin_logse(session('admin')['id'],session('admin')['username'],request()->url(),'修改系统设置','修改成功');
        }
        $config=$AdminConfig->config();
        foreach($config as $key=>$val){
            $config_val[$val['name']]=$val['value'];
        }
        $this->assign('config',$config_val);
        return $this->view->fetch();
    }
}