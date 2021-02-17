<?php

namespace app\index\model;
use think\Model;

class Explain extends Model
{
    public function add_explain($data){
        return $this->save($data);
    }
}