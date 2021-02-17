<?php

namespace app\index\model;
use think\Model;

class Supplier extends Model
{
    public function list($where=[],$paginate="",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate);
    }
}