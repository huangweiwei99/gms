<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/4/24
 * Time: 10:26
 */

namespace app\account\controller;

use think\Controller;
use think\Request;
use app\account\model\Auth as AuthModel;
use app\account\model\User as UserModel;

class Check extends Controller
{
    public function RuleName(Request $request){
        $data = $request->param();
        $name=$data['name'];
        $result=AuthModel::get(['name'=>$name]);
        if($result){
            return json(false);
        }else{
            return json(true);
        }
    }

    public function UserName(Request $request){
        $data = $request->param();
        $name=$data['username'];
        $result=UserModel::get(['username'=>$name]);
        if($result){
            return json(false);
        }else{
            return json(true);
        }
    }

}