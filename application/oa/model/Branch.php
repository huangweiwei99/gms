<?php
namespace app\oa\model;

use app\common\model\OABase as OABaseModel;
use app\account\model\Profile as ProfileModel;
use Exception;

class Branch extends OABaseModel
{
    public function profiles()
    {
        return $this->hasMany('\\app\\account\\model\\Profile')->field('id,first_name,last_name,branch_id');
    }

    public function getStaffAttr()
    {
        $staffs=$this->profiles()->select();
        $name="";$i=0;
        foreach ($staffs as $staff){
            $i++;
            if($i===count($staffs)){
                $name.= $staff->full_name;
            }else{
                $name.= $staff->full_name.' | ';
            }
        }
        return $name;
    }

    public function branchInProfileIdsArray()
    {
        $array=array();
        foreach ($this->profiles()->select() as $profile){
            array_push($array,$profile->branch_id);
        }
        return $array;
    }
    
    public function branchInProfiles()
    {
        if(count($this->profiles()->select())){
            $profiles=ProfileModel::all(function($query){
                $query->where("branch_id='' OR branch_id=".$this->id);
            });
        }else{
            $profiles=ProfileModel::all(['branch_id'=>'']);
        }
        return $profiles;
    }
    
    public function editData($map, $data)
    {
        // 去除键值首位空格
        $this->trimData($data);
        //捕获保存期间的错误
        try{
            $result = $this->save($data,$map);
        }catch  (Exception $e) {
            $this->modelMessge = $e->getMessage();
            return false;
        }
        if($result!==false){
                foreach (ProfileModel::all(['branch_id'=>$data['id']]) as $profile){
                    $profile->save(['branch_id'=>'']);
                }//清除原有记录
                if(isset($data['staff'])){
                    foreach ($data['staff'] as $profile_id){
                        $profile=ProfileModel::get($profile_id);
                        $profile->save(['branch_id'=>$data['id']]);
                    }
                }
        }
        return $result;
    }

    public function addData($data)
    {
        $this->trimData($data);
        try{
            $result = $this->save($data);
        }catch (Exception $e){
            $this->modelMessge = $e->getMessage();
            return false;
        }
        if($result!==false){
            if(isset($data['staff'])){
              //  dump($result);die();
                foreach ($data['staff'] as $profile_id){
                    $profile=ProfileModel::get($profile_id);
                    $profile->save(['branch_id'=>$this->id]);
                }
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
        if($result!==false){
            foreach (ProfileModel::all(['branch_id'=>$this->id]) as $profile){
                $profile->save(['branch_id'=>'']);
            }//清除原有记录
        }
        return $result;
    }
}