<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Remind as Mremind;
class Remind extends Frontend
{
    public function list(){
        
    }
    public function add_remind(){
        $Mremind = new Mremind();
        $param = $this->request->param();
        if(request()->isPost()){
            $return = $Mremind->add($param);
            if($return){
                return ajax_json('1','添加成功');
            }else{
                return ajax_json('0','添加失败');
            }
        }
        return $this->view->fetch();
    }
}