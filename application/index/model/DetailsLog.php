<?php

namespace app\index\model;
use think\Model;

class DetailsLog extends Model
{
    public function handle_log($where=[],$paginate="10",$order="id desc"){
        $where['type']="1";
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item,$key){
            $where_u['id']=$item['u_id'];
            $u=db('admin')->where($where_u)->find();
            $item['user_name']=$u['nickname'];
        });
        
    }
    public function consult_log($where=[],$paginate="10",$order="id desc"){
        $where['type']="2";
        return $this->where($where)->order($order)->group('u_id')->paginate($paginate)->each(function($item,$key){
            $where_u['id']=$item['u_id'];
            $u=db('admin')->where($where_u)->find();
            $item['nickname']=$u['nickname'];
            $item['avatar']=$u['avatar'];
        });
    }

}