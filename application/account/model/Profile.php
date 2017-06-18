<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/15
 * Time: 15:03
 */

namespace app\account\model;

use app\common\model\AccountBase as AccountBaseModel;
use think\Session;


class Profile extends AccountBaseModel
{
    public function getFullNameAttr()
    {
        if (preg_match("/^[\x7f-\xff]+$/", $this->first_name)&preg_match("/^[\x7f-\xff]+$/", $this->last_name)){
            return $this->last_name.$this->first_name;
        }else {
            return $this->first_name.$this->last_name;
        }
    }

    public function addData($data)
    {
        $file = request()->file('avatar');
        // dump($file);die();
        if($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>1046576,'ext'=>'jpeg,jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads'.DS .'avatar');

            if($info){
                $data['avatar']=$info->getSaveName();
            }else{
                $this->modelMessge=$file->getError();
                return false;
            }
        }
        try{
            $result = $this->save($data);
            if(!empty($data['avatar'])&$result){
                Session::set('user.avatar',$data['avatar']);
            }
            return $result;
        }catch  (Exception $e) {
            $this->modelMessge = $e->getMessage();
            //记录到数据库
            return false;
        }
    }

    public function editData($map,$data)
    {
        $file = request()->file('avatar');
        if($file){
            $info = $file->validate(['size'=>1046576,'ext'=>'jpeg,jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads'.DS .'avatar');
            if($info){
                $data['avatar']=$info->getSaveName();
            }else{
                $this->modelMessge=$file->getError();
                return false;
            }
        }
        try{
            $result=$this->save($data,$map);
            if(!empty($data['avatar'])&$result){
                Session::set('user.avatar',$data['avatar']);
            }
            return $result;
        }catch  (Exception $e) {
            $this->modelMessge = $e->getMessage();
            //记录到数据库
            return false;
        }
    }

    public function profile()
    {
        return $this->hasMany('Profile');
    }
}