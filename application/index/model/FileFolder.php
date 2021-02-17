<?php

namespace app\index\model;
use think\Model;

class FileFolder extends Model
{
    public function list($where=[],$paginate="",$order="id desc"){
        return $this->where($where)->order($order)->paginate($paginate)->each(function($item, $key){
            $where_f['folder']=$item['id'];
            $f=db('file_all')->where($where_f)->count();
            $item['count']=$f;
        });
    }
    public function find_one($where=[]){
        return $this->where($where)->find();
    }
    public function add_folder($data){
        return $this->save($data);
    }
}