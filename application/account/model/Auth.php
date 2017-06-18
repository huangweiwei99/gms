<?php

namespace app\account\model;

use app\common\model\AccountBase as AccountBaseModel;

class Auth extends AccountBaseModel
{
    public function deleteData($map){
        $count=$this
            ->where(array('pid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $result=$this->where($map)->delete();
        return $result;
    }

}
