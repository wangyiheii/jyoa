<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\FileAll;
class PersonalCenter extends Frontend
{
    public function my_file(){
        $FileAll= new FileAll();
        $where['u_id']=session('admin')['id'];
        if(request()->isPost()){
            $param = $this->request->param();
            $where['title']=['like',"%".$param['title']."%"];
            $this->assign('title',$param['title']);
            $start=strtotime($param['start']);
            $end=strtotime($param['end']);
            $where['add_time']=['BETWEEN',[$start,$end]];
            $this->assign('start',$param['start']);
            $this->assign('end',$param['end']);
        }
        $list=$FileAll->list($where);
        $count=$FileAll->where($where)->count();
        $this->assign('list',$list);
        $this->assign('count',$count);
        return $this->view->fetch();
    }
    public function del_select(){ //批量删除
        $param = $this->request->param();
        $where['id']=['in',implode(',',$param['ids'])];
        $FileAll=new FileAll();
        $FileAll->where($where)->delete();
        return ajax_json('1','删除成功');
    }
}