<?php

namespace app\common\model;

use Exception;
use think\Model;

class Base extends Model
{
    /*******************属性*******************/
    // 指定自动写入时间戳的类型为dateTime类型
    public $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    public $createTime = 'create_time';
    public $updateTime = 'update_time';

    // 定义类型转换
    public $type = [
        'create_time' => 'timestamp:Y/m/d H:i:s',
        'update_time' => 'timestamp:Y/m/d H:i:s',
    ];

    protected $modelMessge;//模型信息反馈


        /**
     * @param $data 数组
     * @return mixed 数组
     */
    public function trimData($data){
        foreach ($data as $k => $v) {
            if(!is_array($v)){
                $data[$k] = trim($v);
            }
        }
        return $data;
    }

    // 定义自动完成的属性
    // public $insert = ['status'];


    // status读取器
    /* public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    } */

    // status属性修改器
    /* public function setStatusAttr($value, $data)
    {
        return 2;//'admin' == $data['username'] ? 1 : 2;
    } */

    /*******************方法*******************/


    public function getErrors()
    {
        return $this->modelMessge . $this->getError();
    }
    
    public function getMessage($result)
    {
       if ($result!==false) {
           return array('flag'=>true,'message'=>'操作成功','level'=>'success');
       }else{
           return array('flag'=>false,'message'=>$this->getErrors(),'level'=>'error');
       }
    }

    /**
     * 添加数据
     * @param $data 添加的数据
     * @return bool|false|int布尔值或者新增的数据id
     */
    public function addData($data)
    {
        // 去除键值首尾的空格
        $this->trimData($data);
        
        try { //捕获保存期间的错误
            $result = $this->save($data);
            return $result;
        } catch (Exception $e) {
            $this->modelMessge = $e->getMessage();
            //记录到数据库
            return false;
        }
    }

    /**
     * 修改单一对象数据
     *
     * @param array $map
     *            where语句数组形式
     * @param array $data
     *            数据
     * @return boolean 操作是否成功
     */
    public function editData($map, $data)
    {

        // 去除键值首位空格
        $this->trimData($data);
        //捕获保存期间的错误

        try{
            $result = $this->save($data,$map);
            return $result;
        }catch  (Exception $e) {
            $this->modelMessge = $e->getMessage();

            //记录到数据库
            return false;
        }
    }

    /**
     * 删除数据
     *
     * @param array $map
     *            where语句数组形式
     * @return boolean 操作是否成功
     */
    public function deleteData($map)
    {
        if (empty($map)) {
            die('where为空的危险操作');
        }
        $result = $this->where($map)->delete();
        return $result;
    }

    /**
     * 数据排序
     *
     * @param array $data
     *            数据源
     * @param string $id
     *            主键
     * @param string $order
     *            排序字段
     * @return boolean 操作是否成功
     */
    public function orderData($data, $id = 'id', $order = 'order_number')
    {
        $array=array();
        foreach ($data as $k => $v) {
            $v = empty($v) ? null : $v;
            $a=array([$order => $v,$id => $k]);
            $array=array_merge($array,$a);
        }
        $this->saveAll($array);
        return true;
    }

    /**
     * 获取全部数据
     * @param  string $type tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式
     * @return array         结构数据
     */
    public function getTreeData($type = 'tree', $order = '', $name = 'name', $child = 'id', $parent = 'pid')
    {
        // 判断是否需要排序
        if (empty($order)) {
            $data = $this->select();
        } else {
            $data = $this->order($order . ' is null,' . $order)->select();
        }
        // 获取树形或者结构数据
        if ($type == 'tree') {
            $data = \org\nx\Data::tree($data, $name, $child, $parent);
        } elseif ($type == "level") {
            $data = \org\nx\Data::channelLevel($data, 0, '&nbsp;', $child);
        }
        return $data;
    }

    /**
     * 获取分页数据
     *
     * @param subject $model
     *            model对象
     * @param array $map
     *            where条件
     * @param string $order
     *            排序规则
     * @param integer $limit
     *            每页数量
     * @param integer $field
     *            $field
     * @return array 分页数据
     */
    /*
     * public function getPage($model, $map, $order = '', $limit = 10, $field = '')
     * {
     * $count = $model->where($map)->count();
     * $page = new_page($count, $limit);
     * // 获取分页数据
     * if (empty($field)) {
     * $list = $model->where($map)
     * ->order($order)
     * ->limit($page->firstRow . ',' . $page->listRows)
     * ->select();
     * } else {
     * $list = $model->field($field)
     * ->where($map)
     * ->order($order)
     * ->limit($page->firstRow.','.$page->listRows)
     * ->select();
     * }
     * $data=array(
     * 'data'=>$list,
     * 'page'=>$page->show()
     * );
     * return $data;
     * }
     */


}