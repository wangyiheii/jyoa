<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\FileAll;
use app\index\model\FileFolder;
class Filese extends Frontend
{
    public function file_index(){//首页
        $FileAll= new FileAll();
        $FileFolder= new FileFolder();
        $param = $this->request->param();
        $where=[];
        if(request()->isPost()){
            $where_f['title']=['like',"%".$param['title']."%"];
            $this->assign('title',$param['title']);
        }
        $folder_list=$FileFolder->list();
        $list_file=[];
        if(!empty($folder_list)){
            $where_f['folder']=$folder_list['0']['id'];
            $list_file=$FileAll->list($where_f,'10');
        }
        $this->assign('list_file',$list_file);
        $this->assign('folder_list',$folder_list);
        return $this->view->fetch();    
    }
    public function file_upload(){//上传文件
        $param = $this->request->param();
        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $data['src'] = '/uploads/'.$info->getSaveName();
                $data['title']=$info->getFilename();
                $data['type']=$info->getExtension();
                $data['add_time']=time();
                $data['size']=$info->getSize();
                $data['u_id']=session('admin')['id'];;
                $data['ip']=request()->ip();
                $data['folder']=$param['folder_id'];
                $FileAll= new FileAll();
                $FileAll->add_log($data);
                return ajax_json('1','上传成功');
            }else{
                // 上传失败获取错误信息
                $data=$file->getError();
                return ajax_json('0','上传失败',$data);
            }
        }else{
            // return "上传失败错误";
            return ajax_json('0','上传失败');
        }
    }
    public function select_folder(){//选中文件夹
        $FileAll= new FileAll();
        $FileFolder= new FileFolder();
        $param = $this->request->param();
        $where['id']=$param['id'];
        $folder=$FileFolder->find_one($where);
        $where_f['folder']=$folder['id'];
        $list=$FileAll->list($where_f,'10');
        return ajax_json('1','请求成功',$list);
    }
    public function download(){ //更新下载数量
        $param = $this->request->param();
        $where['id']=$param['id'];
        $FileAll= new FileAll();
        $FileAll->download_updata($where);
        return ajax_json('1','请求成功');
    }
    public function del_select(){ //批量删除
        $param = $this->request->param();
        $where['id']=['in',implode(',',$param['ids'])];
        $FileAll=new FileAll();
        $FileAll->where($where)->delete();
        return ajax_json('1','删除成功');
    }
    public function add_folder(){//添加文件夹
        $param = $this->request->param();
        $FileFolder= new FileFolder();
        $return=$FileFolder->add_folder($param);
        if($return){
            return ajax_json('1','添加成功');
        }else{
            return ajax_json('0','添加失败');
        }
        
    }
    public function del_folder(){
        $param = $this->request->param();
        $FileAll= new FileAll();
        $FileFolder= new FileFolder();
        $where['folder']=$param['id'];
        $find=$FileAll->find_one($where);
        if(!empty($find)){
            return ajax_json('0','删除失败,请先删除文件夹内文件');
        }else{
            $where_f['id']=$param['id'];
            $FileFolder->where($where_f)->delete();
            return ajax_json('1','删除成功');
        }
    }
}