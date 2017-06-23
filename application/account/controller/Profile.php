<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/8
 * Time: 15:27
 */

namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use think\Request;
use think\Session;

class Profile extends AdminController
{
        public function index()
        {
            $assign=array('user'=>$this->accountService()->getUserById(Session::get('user')['id']));
            return view()->assign($assign);
        }

        public function save(Request $request) {
            $data = $request->param();
            $result=$this->accountService()->saveProfile($data);
            if($result['flag']){
                $this->redirect('index');
            }else{
                $this->error($result['message']);
            }
        }

}