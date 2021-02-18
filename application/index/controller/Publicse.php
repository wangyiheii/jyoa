<?php

namespace app\index\controller;

use app\common\controller\Frontend;
class Publicse extends Frontend
{
    public function upload(){
        $file = request()->file('file');
        // dump($file);die;
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $data = '/uploads/'.$info->getSaveName();
                return ajax_json('1','修改成功',$data);
            }else{
                // 上传失败获取错误信息
                $data=$file->getError();
                return ajax_json('1','修改成功',$data);
            }
        }else{
            // return "上传失败错误";
            return ajax_json('0','上传失败');
        }
    }
    public function uploads(){
        $file = request()->file('file');
    }
}