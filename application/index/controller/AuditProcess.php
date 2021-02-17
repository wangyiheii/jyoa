<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\AuditProcess as MAuditProcess;
class AuditProcess extends Frontend
{
    public function index(){
        $MAuditProcess= new MAuditProcess();
        $list=$MAuditProcess->list();
        $this->assign('list',$list);
        return $this->view->fetch($fetch);
    }
}