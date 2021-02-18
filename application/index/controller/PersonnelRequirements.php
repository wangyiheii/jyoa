<?php


namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use app\index\model\Organization;
use app\index\model\PersonnelRequirements as PrModel;

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
        $post_data = $_POST;
        $pr_model = new PrModel();
        $where = array();
        if (isset($post_data['start_time'])) {
            $where['add_datetime'] = array('>=', $post_data['start_time']);
        }
        if (isset($post_data['end_time'])) {
            $where['add_datetime'] = array('<=', $post_data['end_time']);
        }
        $dis_list = $pr_model->list($where)->toArray();
        $this->assign('list', $dis_list);
        return $this->fetch();
    }

    /**
     * 添加
     */
    public function prAdd()
    {
        $uid = session('admin')['id'];

        //所有部门
        $organization_model = new Organization();
        $department_list = $organization_model->list_all();
        $department_list = collection($department_list)->toArray();
        $this->assign('department_list', $department_list);
        return $this->fetch();
    }

    /**
     * 新增
     */
    public function prInsert()
    {
        $pr_model = new PrModel();
        $res = $pr_model->prInsert();
        $apply_for =  AuditProcess();
        if ($res) {
            return ajax_json('1', '新增成功');
        } else {
            return ajax_json('0', '新增失败');
        }
    }

    /**
     * 批量删除
     */
    public function batchRemove()
    {
        $pr_model = new PrModel();
        $res = $pr_model->batchRemove();
        if ($res) {
            return ajax_json('1', '删除成功');
        } else {
            return ajax_json('0', '删除失败');
        }
    }

    /**
     * 编辑
     */
    public function prEdit()
    {
        $organization_model = new Organization();
        $department_list = $organization_model->list_all();
        $department_list = collection($department_list)->toArray();
        $this->assign('department_list', $department_list);

        $pr_model = new PrModel();
        $res = $pr_model->prEdit();
        $this->assign('res', $res);
        return $this->fetch();
    }

    /**
     * 编辑请求
     */
    public function prUpdate()
    {
        $pr_model = new PrModel();
        $res = $pr_model->prUpdate();
        if ($res) {
            return ajax_json('1', '编辑成功');
        } else {
            return ajax_json('0', '编辑失败');
        }
    }

    /**
     * 删除
     */
    public function prDelete()
    {
        $pr_model = new PrModel();
        $res = $pr_model->prDelete();
        if ($res) {
            return ajax_json('1', '删除成功');
        } else {
            return ajax_json('0', '删除失败');
        }
    }
}