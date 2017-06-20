<?php
namespace app\account\model;

use app\common\model\AccountBase as AccountBaseModel;

class Role extends AccountBaseModel
{
    protected $insert = ['status'];

    public function setPermissionAttr($value,$data)
    {
        return $data['permission']===''?$value:implode(',', $data['permission']);
    }

    
    
    public function setStatusAttr($value, $data)
    {
       return 1;
    }

    public function users()
    {
        return $this->belongsToMany('User');
    }

    public function deleteData($map)
    {
        if (empty($map)) {
            die('where为空的危险操作');
        }
        
        $result = $this->where($map)->delete();
        if ($result) {
            model('Access')->deleteData(array(
                'role_id' => $this->id
            ));
        }
        return $result;
    }
}
