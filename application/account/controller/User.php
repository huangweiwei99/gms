<?php
namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use app\account\model\User as UserModel;
use app\account\model\Role as RoleModel;
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
        if ($data['id'] != 0) {
            $id = $data['id'];
            $user = UserModel::get($id);
            $map = array(
                'id' => $id
            );

            if ($user->allowField(true)->validate('User.edit')->editData($map, $data)) {
                $array=array('flag'=>true,'message'=>'用户[ ' . $user->username . ':' . $user->id . ' ]修改成功','level'=>'success');
                return json($array);
            } else {
                $array=array('flag'=>false,'message'=>$user->getErrors(),'level'=>'error');
                return json($array);
            }
        } else {
            $user = new UserModel();
            $data["last_login_ip"] = $request->ip();

            if ($user->allowField(true)
                ->validate(true)
                ->addData($data)) {
                $array=array('flag'=>true,'message'=>'用户[ ' . $data['username'] .  ' ]新增成功','level'=>'success');
                return json($array);

            } else {
                $array=array('flag'=>false,'message'=>$user->getErrors(),'level'=>'error');
                return json($array);
            }
        }
    }

    public function read($id)
    {
        $user = $this->accountService()->getUserById($id);
        $roles=$this->accountService()->getRoles();
        $selected_roles=$user->selectRolesIdArray();
        
        $assign=array('user'=>$user,
            'roles'=>$roles,
            'selected_roles'=>$selected_roles
            );
        
        return view('form')->assign($assign);
    }

    public function delete($id)
    {
        $map = array(
            'id' => $id
        );
        $user=UserModel::get($id);
        $result = $user->deleteData($map);
        if ($result) {
            $this->redirect('index');
        } else {
            $array=array('flag'=>false,'message'=>$user->getErrors(),'level'=>'error');
            return json($array);
        }
    }
}
