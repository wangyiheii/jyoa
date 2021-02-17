<?php

namespace app\index\controller;

use app\common\controller\Frontend_L;
use app\index\model\Admin;
class Login extends Frontend_L
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';
    //登录
    public function index()
    {
        if(request()->isPost()){
            $param = $this->request->param();
            $user=new Admin();
            $where['username']=$param['username'];
            $find=$user->user($where);
            if(empty($find)){
                $this->error('没有此用户');
            }else{
                $password=md5($param['password'].$find['salt']);
                if($password==$find['password']){
                    $data['id']=$find['id'];
                    $data['username']=$find['nickname'];
                    session_start();
                    session('admin',$data);
                    admin_logse($find['id'],$find['nickname'],request()->url(),'登录','登录成功');
                    $this->redirect(url('index/index'));
                }else{
                    // admin_log();
                    admin_logse($find['id'],$find['nickname'],request()->url(),'登录','登录失败错误密码:'.$param['password']);
                    $this->error('密码错误'); 
                }
            }
            dump($param);

        }

        return $this->view->fetch();
    }
    //忘记密码
    public function recoverpw(){

        return $this->view->fetch();
    }
    //注册
    public function register(){

        if(request()->isPost()){
            $param = $this->request->param();
            $user=new Admin();
            $where['username']=$param['username'];
            $find=$user->user($where);
            if(!empty($find)){
                $this->error('已有此用户名');
            }else{
                $data['username']=$param['username'];
                $data['nickname']=$param['username'];
                $salt=rand();
                $password=md5($param['password'].$salt);
                $data['password']=$password;
                $data['salt']=$salt;
                $add=$user->add_user($data);
                if($add){
                    $this->success('注册成功',url('Login/index'));
                }else{
                    $this->error('注册失败');
                }
            }
        }
        return $this->view->fetch();
    }
    public function sign_out(){
        session_start();
        session_destroy();
        $this->redirect(url('Login/index'));
    }

}
