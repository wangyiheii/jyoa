<?php


namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Organization;
use think\Db;
use app\index\model\Admin;

/**
 * 面试安排
 */
class InterviewArrangement extends Frontend
{

    public function list()
    {
        return $this->fetch();
    }

    /**
     * 添加
     */
    public function iaAdd()
    {
        //面试人员
        $admin_model = new Admin();
        $interview_leader = $admin_model->getAll();
        $interview_leader = collection($interview_leader)->toArray();
        $this->assign('interview_leader_list', $interview_leader);
        //所属部门
        $organization_model = new Organization();
        $department_list = $organization_model->list_all();
        $department_list = collection($department_list)->toArray();
        $this->assign('department_list', $department_list);

        return $this->fetch();
    }

}