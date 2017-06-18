<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/19
 * Time: 10:33
 */

namespace app\account\model;

use app\common\model\AccountBase as AccountBaseModel;


class Project extends AccountBaseModel
{
    public function task()
    {
        return $this->hasMany('app\account\model\Task');
    }

    public function profiles()
    {
        return $this->belongsToMany('Profile', '\\app\\account\\model\\ProjectAccess');
    }

}