<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Remind as Mremind;
class Remind extends Frontend
{
    public function add_remind(){
        return $this->view->fetch();
    }
}