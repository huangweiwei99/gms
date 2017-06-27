<?php
namespace app\system\controller;

use app\common\controller\Admin as AdminController;
use think\Request;

class AdminMenu extends AdminController
{
    public function index()
    {
        $assign=array('menus'=>$this->systemService()->getAdminMenuTree());
        return view()->assign($assign);
    }

    public function create($pid=null)
    {
        $assign=array('menu'=>$this->systemService()->AdminMenu($pid),'auth_list'=>$this->accountService()->getAuthList());
        return view('form')->assign($assign);
    }

    public function read($id)
    {
        $assign=array('menu'=>$this->systemService()->getAdminMenuById($id),'auth_list'=>$this->accountService()->getAuthList());
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $result=$this->systemService()->saveAdminMenu($data);
        return json($result);
    }

    public function delete($id)
    {
        $this->systemService()->deleteAdminMenu(['id'=>$id]);
        $this->redirect('index');
    }

    public function order(Request $request){
        $data = $request->post();
        $result=$this->systemService()->orderAdminMenu($data);
        return json($result);
    }

}