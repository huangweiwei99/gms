<?php
namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use app\account\model\Role as RoleModel;
use app\account\model\Auth as AuthModel;
use think\Request;


class Role extends AdminController
{

    public function index()
    {
        $assign=array('list'=>$this->accountService()->getRoles());
        return view()->assign($assign);
    }

    public function create($id=null)
    {
        $assign=array(
            'auth_list'=>$this->accountService()->getAuthLevel(),
            'role_permission'=>array()
        );
       
        return view('form')->assign($assign);
    }
    
    public function save(Request $request)
    {
        $data = $request->param();
        $result=$this->accountService()->saveRole($data);
        return json($result);
    }

    public function read($id)
    {
        $role = $this->accountService()->getRoleById($id);
        $assign=array('role'=>$role,
            'auth_list'=>$this->accountService()->getAuthLevel(),
            'role_permission'=>explode(',', $role->permission)
        );
        return view('form')->assign($assign);
    }

    public function delete($id)
    {
        $this->accountService()->deleteRole(['id'=>$id]);
        $this->redirect('index');
        
    }
}
