<?php

namespace app\index\model;
use think\Model;

class FileAll extends Model
{
    public function list($where=[],$paginate="10",$order="id desc"){
       return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            $where_u['id']=$item['u_id'];
            $u=db('admin')->where($where_u)->find();
            $item['user_name']=$u['nickname'];
            $where_f['id']=$item['folder'];
            $f=db('file_folder')->where($where_f)->find();
            $item['folder_name']=$f['title'];
        });
    }
    public function add_log($data){
        return $this->save($data);
    }
    public function download_updata($where=[]){
        $find=$this->where($where)->find();
        $num=$find['download_num']+1;
        $data['download_num']=$num;
        return $this->save($data,$where);
    }
    public function find_one($where){
        return $this->where($where)->find();
    }
}