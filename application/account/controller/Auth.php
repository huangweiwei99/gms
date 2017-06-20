<?php
namespace app\account\controller;

use app\common\controller\Admin as AdminController;
use app\account\model\Auth as AuthModel;
use think\Request;


class Auth extends AdminController
{

    public function index()
    {
        $assign=array(
            'data'=>$this->accountService()->getAuthTree()
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
        }
            return view('form');
        
    }

    public function read($id)
    {
        $assign=array('auth'=>$this->accountService()->getAuthById($id));
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $result=$this->accountService()->saveAuth($data);
        return json($result);
    }
    

    public function delete($id)
    {
        
        $this->accountService()->deleteAuth(['id'=>$id]);
        $this->redirect('index');
    }

    public function data()
    {
        $auth=new AuthModel();
        $auth=$auth->getTreeData('tree','id','title');
        return json($auth);
    }
}
