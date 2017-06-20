<?php
namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use think\Request;


class User extends AdminController
{

    public function index()
    {
        $assign=array(
            'users'=>$this->accountService()->getUsers()
        );
        return view()->assign($assign);
    }

    public function create()
    {
        $assign=array('roles'=>$this->accountService()->getRoles());
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $result=$this->accountService()->saveUser($data);
        return json($result);
    }

    public function read($id)
    {
        $user = $this->accountService()->getUserById($id);
        $roles=$this->accountService()->getRoles();
        $selected_roles=$user->userInRolesIdArray();
        
        $assign=array('user'=>$user,
            'roles'=>$roles,
            'selected_roles'=>$selected_roles
            );
        
        return view('form')->assign($assign);
    }

    public function delete($id)
    {
        $this->accountService()->deleteUser(['id'=>$id]);
        $this->redirect('index');
    }
}
