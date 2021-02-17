<?php

namespace app\index\model;
use think\Model;

class BillingSelgita extends Model
{
    public function add_selgita($data){
        return $this->save($data);        
    }
}