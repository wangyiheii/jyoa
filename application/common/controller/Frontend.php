<?php

namespace app\common\controller;

use app\common\library\Auth;
use think\Config;
use think\Controller;
use think\Hook;
use think\Lang;
use think\Loader;
use think\Validate;

/**
 * 前台控制器基类
 */
class Frontend extends Controller
{
public function convertUnderline1 ( $str , $ucfirst = true)
{
while(($pos = strpos($str , '_'))!==false)
$str = substr($str , 0 , $pos).ucfirst(substr($str , $pos+1));
return $ucfirst ? ucfirst($str) : $str;
}
    /**
     * 布局模板
     * @var string
     */
    protected $layout = '';

    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = [];

    /**
     * 权限Auth
     * @var Auth
     */
    protected $auth = null;

    public function _initialize()
    {
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        $modulename = $this->request->module();
        $controllername = Loader::parseName($this->request->controller());
        $actionname = strtolower($this->request->action());

        // 如果有使用模板布局
        if ($this->layout) {
            $this->view->engine->layout('layout/' . $this->layout);
        }
        $this->auth = Auth::instance();


        $path = str_replace('.', '/', $controllername) . '/' . $actionname;
        // 设置当前请求的URI
        // dump($path);
        $this->auth->setRequestUri($path);
        // 检测是否需要验证登录
        session_start();
        $admin=session('admin');
        if(empty($admin)){
            $this->redirect(url('Login/index'));
        }
        $where_admin['id']=$admin['id'];
        $admin_find=db('admin')->where($where_admin)->find();
        // dump($admin_find);die;
        if($admin_find['is_admin']!='1'){
            $where_menu['url']=$path;
            $url=$this->convertUnderline1($path);
            $where_menu_find['url']=$url;
            $menu=db('menu')->where($where_menu_find)->find();
            if(!empty($menu)){
               $where_group['u_id']=$admin['id'];
               $group_find=db('group')->where($where_group)->where('FIND_IN_SET(:id,rules)',['id'=>$menu['id']])->find();
               if(!empty($group_find)||$group_find==null){
                //   die("您没有权限访问");
                   $this->error('您没有权限访问');
               }
            }
            
            
        }

        $this->view->assign('user', $this->auth->getUser());

        // 语言检测
        $lang = strip_tags($this->request->langset());

        $site = Config::get("site");

        $upload = \app\common\model\Config::upload();

        // 上传信息配置后
        Hook::listen("upload_config_init", $upload);

        // 配置信息
        $config = [
            'site'           => array_intersect_key($site, array_flip(['name', 'cdnurl', 'version', 'timezone', 'languages'])),
            'upload'         => $upload,
            'modulename'     => $modulename,
            'controllername' => $controllername,
            'actionname'     => $actionname,
            'jsname'         => 'frontend/' . str_replace('.', '/', $controllername),
            'moduleurl'      => rtrim(url("/{$modulename}", '', false), '/'),
            'language'       => $lang
        ];
        $config = array_merge($config, Config::get("view_replace_str"));

        Config::set('upload', array_merge(Config::get('upload'), $upload));

        // 配置信息后
        Hook::listen("config_init", $config);
        // 加载当前控制器语言包
        $this->loadlang($controllername);
        $this->assign('admin', $admin);
        $this->assign('site', $site);
        $configse=db('admin_config')->select();
        foreach($configse as $key=>$vo){
            $configseve[$vo['name']]=$vo['value'];
        }
        if($configseve['logo_type']!='1'){
            $configseve['logo_img']="";
        }else{
            $configseve['logo_img']=$configseve['logo'];
        }
        $this->assign('config', $configseve);
    }

    /**
     * 加载语言文件
     * @param string $name
     */
    protected function loadlang($name)
    {
        $name =  Loader::parseName($name);
        Lang::load(APP_PATH . $this->request->module() . '/lang/' . $this->request->langset() . '/' . str_replace('.', '/', $name) . '.php');
    }

    /**
     * 渲染配置信息
     * @param mixed $name  键名或数组
     * @param mixed $value 值
     */
    protected function assignconfig($name, $value = '')
    {
        $this->view->config = array_merge($this->view->config ? $this->view->config : [], is_array($name) ? $name : [$name => $value]);
    }

    /**
     * 刷新Token
     */
    protected function token()
    {
        $token = $this->request->param('__token__');

        //验证Token
        if (!Validate::make()->check(['__token__' => $token], ['__token__' => 'require|token'])) {
            $this->error(__('Token verification error'), '', ['__token__' => $this->request->token()]);
        }

        //刷新Token
        $this->request->token();
    }
}
