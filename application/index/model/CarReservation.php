<?php

namespace app\index\model;
use think\Model;

class CarReservation extends Model
{
    public function list($where=[],$paginate="10",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            
        });
    }
}
