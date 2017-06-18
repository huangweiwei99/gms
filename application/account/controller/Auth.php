<?php
namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use app\account\model\Auth as AuthModel;
use think\Request;
use think\Db;

class Auth extends AdminController
{

    public function index()
    {
        $data=model('Auth')->getTreeData('tree','id','title');
        $assign=array(
            'data'=>$data
        );
        return view()->assign($assign);
    }

    public function create($pid=null)
    {
        if(isset($pid)){
            $auth=new AuthModel();
            $auth->pid=$pid;
            $assign=array('auth'=>$auth);
            return view('form')->assign($assign);
        }else{
            return view('form');
        }
    }

    public function read($id)
    {
        $auth=AuthModel::get($id);
        $assign=array('auth'=>$auth);
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $id=$data['id'];
        if($id!=0){
            $auth = AuthModel::get($id);
            $map = array(
                'id' => $id
            );
            if ($auth->allowField(true)->validate(true)->editData($map, $data)) {
                $array=array('flag'=>true,'message'=>'修改成功','level'=>'success');
                return json($array);
            } else {
                $array=array('flag'=>false,'message'=>$auth->getErrors(),'level'=>'error');
                return json($array);
            }
        } else{
            $auth=new AuthModel();
            if ($auth->allowField(true)->validate(true)->addData($data)) {
                $array=array('flag'=>true,'message'=>'添加成功','level'=>'success');
                return json($array);
            }else{
                $array=array('flag'=>false,'message'=>$auth->getErrors(),'level'=>'error');
                return json($array);
            }
        }

    }

    public function delete($id)
    {
        $map=array(
            'id'=>$id
        );
        $auth=new AuthModel();
        if($auth->deleteData($map)){
            $this->redirect('index');
        }else{
            $array=array('flag'=>false,'message'=>$auth->getErrors(),'level'=>'error');
            return json($array);
        }
    }

    public function data()
    {
        $auth=new AuthModel();
        $auth=$auth->getTreeData('tree','id','title');
        return json($auth);
    }
}
