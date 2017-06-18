<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/8
 * Time: 10:49
 */

namespace app\system\model;

use app\common\model\SystemBase as SystemBaseModel;


class Settings extends SystemBaseModel
{
    public function addData($data)
    {
        $file = request()->file('logo');
        if($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            $data['logo']=$info->getSaveName();
        }
        $this->trimData($data);
        try { //捕获保存期间的错误
            $data['logo']=$info->getSaveName();
            $result = $this->save($data);
            return $result;
        } catch (Exception $e) {
            $this->modelMessge = $e->getMessage();
            //记录到数据库
            return false;
        }

    }

    public  function editData($map, $data)
    {
        $file = request()->file('logo');
        if($file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            $data['logo']=$info->getSaveName();
        }
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
}