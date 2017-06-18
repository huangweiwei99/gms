<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/19
 * Time: 10:33
 */

namespace app\account\model;

use app\common\model\AccountBase as AccountBaseModel;


class Task extends AccountBaseModel
{
    public function setDueAttr($value)
    {
        return strtotime($value);
    }

    public function getDuetimeAttr()
    {
        return date('Y-m-d', $this->due);
    }

    public function profile()
    {
        return $this->belongsTo('Profile', '\\app\\account\\model\\Profile');
    }
}