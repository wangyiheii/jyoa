<?php


namespace app\index\model;

use think\Db;
use think\Model;

/**
 * 人员需求
 */
class PersonnelRequirements extends Model
{

    public function list($where = [], $paginate = "10", $order = "id desc")
    {
        return $this->where($where)->order($order)->paginate($paginate)->each(function ($item, $key) {
            $item['dname'] = Db::name('organization')->where('id', $item['demand_department'])->value('name');
            $item['related_documents'] = unserialize($item['related_documents']);
            return $item;
        });
    }

    /**
     * 新增
     */
    public function prInsert()
    {
        $post_data = $_POST;
        $post_data['related_documents'] = serialize(explode(',', $post_data['related_documents']));
        $post_data['add_datetime'] = time();
        $res = $this->insertGetId($post_data);
        return $res;
    }

    /**
     * 批量删除
     */
    public function batchRemove()
    {
        $post_data = $_POST;
        $res = $this->where('in', $post_data['del_id'])->delete();
        return $res;
    }

    /**
     * 编辑
     */
    public function prEdit()
    {
        $post_data = $_POST;

        $res = $this->where('id', $post_data['id'])->find()->toArray();
        $res['related_documents'] = unserialize($res['related_documents']);
        $res['dname'] = Db::name('organization')->where('id', $res['demand_department'])->value('name');
        return $res;
    }

    /**
     * 更新
     */
    public function prUpdate()
    {
        $post_data = $_POST;

        $res = $this->save($post_data);
        return $res;
    }

    /**
     * prDelete
     */
    public function prDelete()
    {
        $post_data = $_POST;

        $res = $this->where('id', $post_data['id'])->delete();
        return $res;
    }

}