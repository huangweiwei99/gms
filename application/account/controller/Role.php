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
        //
        $list = RoleModel::all();
        $auth_list=model('Auth')->getTreeData('level','id','title');
        //dump($auth_list);
        $assign=array('list'=>$list,
            'rule_data'=>$auth_list,
            );
        return view()->assign($assign);
    }

    public function create($id=null)
    {
        $auth_list=model('Auth')->getTreeData('level','id','title');
        if(isset($id)){
            $role=RoleModel::get($id);
            $assign=array('role'=>$role);
            return view('form')->assign($assign);
        }else{
            $assign=array(
                'auth_list'=>$auth_list,
                'role_permission'=>array()
            );
            return view('form')->assign($assign);
        }
    }

    public function save(Request $request)
    {
        $data = $request->param();
        if(isset($data['auth_ids'])){
            $data['permission']=implode(',', $data['auth_ids']);
        }
        if ($data['id']) {
            $id = $data['id'];
            $role = RoleModel::get($id);
            $map = array(
                'id' => $id
            );
            if ($role->allowField(true)->validate(true)->editData($map, $data)) {
                $array=array('flag'=>true,'message'=>'修改成功','level'=>'success');
                return json($array);
            } else {
                $array=array('flag'=>false,'message'=>$role->getErrors(),'level'=>'error');
                return json($array);
            }
        } else {
            $role = new RoleModel();

            if ($role->allowField(true)
                ->validate(true)
                ->addData($data)) {
                $array=array('flag'=>true,'message'=>'添加成功','level'=>'success');
                return json($array);
            } else {
                $array=array('flag'=>false,'message'=>$role->getErrors(),'level'=>'error');
                return json($array);
            }
        }
    }

    public function read($id)
    {
        //获取权限数据
        $auth=new AuthModel();
        $auth_list=$auth->getTreeData('level','id','title');

        //获取角色权限
        $role = RoleModel::get($id);
        $role_permission=explode(',', $role->permission);
        $assign=array('role'=>$role,
            'auth_list'=>$auth_list,
            'role_permission'=>$role_permission
        );
        return view('form')->assign($assign);
    }

    public function delete($id)
    {
        $map = array(
            'id' => $id
        );
        $role=RoleModel::get($id);//先找到实体，同时删除多对多关系
        if ($role->deleteData($map)) {
            $this->redirect('index');
        } else {
            $array=array('flag'=>false,'message'=>$role->getErrors(),'level'=>'error');
            return json($array);
        }
    }
}
