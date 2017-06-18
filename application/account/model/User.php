<?php

namespace app\account\model;

use app\common\model\AccountBase as AccountBaseModel;
use Exception;

class User extends AccountBaseModel
{

    public  $createTime  = 'register_time';

    public  $type = [
        'register_time' => 'timestamp:Y/m/d H:i:s',
        'update_time'=> 'timestamp:Y/m/d H:i:s',
        'last_login_time' => 'timestamp:Y/m/d H:i:s',
    ];

    public function roles()
    {
        return $this->belongsToMany('Role', '\\app\\account\\model\\Access');
    }

    public function profile()
    {
        return $this->hasOne('\\app\\account\\model\\Profile');
    }

    protected  function setPasswordAttr($value, $data)
   {
       if(empty($value)){
           unset($data['password']);
           return $data;
       }else{
           return md5($value);
       }
   }

    public function addData($data)
    {
        $this->trimData($data);
        if (!empty($data['password'])) {
            $data['password']=md5($data['password']);
        }
        $result = $this->save($data);
        if(isset($data['role_ids'])&$result){
            $this->roles()->saveAll($data['role_ids']);
        }
        return $result;
    }

    public function editData($map,$data)
    {
        $this->trimData($data);
        try{
            $result = $this->save($data,$map);
        }catch  (Exception $e) {
            $this->modelMessge = $e->getMessage();
            return false;
        }
        if($result){
            $permission_delete=model('Access')->deleteData(array('user_id'=>$this->id));//删除原有权限
            if(isset($data['role_ids'])){
                $this->roles()->saveAll($data['role_ids']);
            }
        }

        return $result;
    }

    public function deleteData($map)
    {
        if (empty($map)) {
            die('where为空的危险操作');
        }
        $result = $this->where($map)->delete();
        if($result){
            model('Access')->deleteData(array('user_id'=>$this->id));//删除原有权限
        }
        return $result;
    }
    
}
