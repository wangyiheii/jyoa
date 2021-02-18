<?php

namespace app\index\model;
use think\Model;

class Remind extends Model
{
    public function add($data){
        return $this->insertGetId($data);
    }
}