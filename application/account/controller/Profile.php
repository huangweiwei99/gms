<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/8
 * Time: 15:27
 */

namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use app\account\model\User as UserModel;
use app\account\model\Profile as ProfileModel;
use think\Request;
use think\Session;

class Profile extends AdminController
{
        public function index()
        {
            $user_id=Session::get('user')['id'];
            $user=UserModel::get($user_id);
            $assign=array('user'=>$user);
            return view()->assign($assign);
        }

        public function save(Request $request)
        {
            $data = $request->param();
            $user_id=$data['user_id'];
            $user=UserModel::get($user_id);
            $selected_profile=ProfileModel::get(array('user_id'=>$data['user_id']));//$user->profile()->select();
            $profile=new ProfileModel();

            if(empty($selected_profile)){

                if($profile->allowField(true)->addData($data)){
                     $this->redirect('index');
                }else{
                    $this->error('出错了');
                }
            }else{

                $id=$user->profile->id;
                $map=array('id'=>$id);
                if(empty($data['new_password'])){

                    if( $profile->allowField(true)->validate(true)->editData($map, $data)){
                        $this->redirect('index');
                    }else{
                        $this->error($profile->getErrors());
                    }
                }else{
                    $user=UserModel::get(['password'=>md5($data['current_password']),'id'=>$data['user_id']]);
                    if($user){
                        $map = array(
                            'id' => $data['user_id']
                        );

                        if($user->editData($map,array('password'=>$data['new_password'])))
                        {
                            $this->redirect('index');
                        }else{
                            $this->error('修改密码出错误了');
                        }
                    }else{
                        $this->error('请先填入当前正确的密码再修改');
                    }
                }



            }
        }
}