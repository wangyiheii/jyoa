<?php


namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use app\index\model\Organization;

/**
 * 人员需求
 */
class PersonnelRequirements extends Frontend
{
    /**
     * 展示
     */
    public function displayList()
    {
        return $this->fetch();
    }

    /**
     * 添加
     */
    public function prAdd()
    {
        $uid = session('admin')['id'];
        $organization_model = new Organization();
        $department_list = $organization_model->list();
        var_dump('asd');
        exit;
    }
}