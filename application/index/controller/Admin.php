<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;

use app\common\controller\Admin as AdminController;

use app\account\model\User as UserModel;


class Admin extends AdminController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        if(Session::get('user')){
            // 临时关闭当前模板的布局功能
            //$this->view->engine->layout(false);
            return  view()->assign('session_user', Session::get('user'));
        }
        $this->error('请正确登陆','login');
    }

    public function login(Request $request){

        $data = $request->post();
        if(!empty($data)){
            $array=array('username'=>$data['username'],'password'=>md5($data['password']));
            $user=UserModel::get($array);
            $captcha=captcha_check($data['captcha']);
            if($user){
                if($captcha){
                    Session::set('user',array(
                        'id'=>$user->id,
                        'username'=>$user->username,
                        'avatar'=>$user->profile->avatar//empty($user->profile->avatar)?null:$user->avatar
                    ));
                    $array=array('flag'=>true,'message'=>'正在登陆','level'=>'success');
                    return json($array);
                   // $this->redirect('index');
                }else{
                    $array=array('flag'=>false,'message'=>'验证码错误','level'=>'error');
                    return json($array);
                }
            }else{
                $array=array('flag'=>false,'message'=>'用户名或者密码错误','level'=>'error');
                return json($array);
            }

        }

        $this->view->engine->layout(false);
        return $this->fetch('login',[],['__PUBLIC__'=>'/public/']);
    }

    public function logout(){
        Session::delete('user');
        $this->redirect('login');

    }


}
