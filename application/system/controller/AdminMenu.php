<?php
namespace app\system\controller;

use app\common\controller\Admin as AdminController;
use app\system\model\AdminMenu as MenuModel;
use app\account\model\Auth as AuthModel;
use think\Request;

class AdminMenu extends AdminController
{
    public function index()
    {
        //print_r(count(explode('/',"aa/bb/cc")));

        $menu=new MenuModel();
        $menus=$menu->getTreeData('tree','order_number,id');
        $assign=array('menus'=>$menus);
        return view()->assign($assign);
    }

    public function create($pid=null)
    {
        $auth_list=AuthModel::all();
        $menu=new MenuModel();
        $menu->mca=null;
        if(isset($pid)){
            $menu->pid=$pid;
        }
        $assign=array('menu'=>$menu,'auth_list'=>$auth_list);
        return view('form')->assign($assign);


    }

    public function read($id)
    {
        $auth_list=AuthModel::all();

        $menu=MenuModel::get($id);
        $assign=array('menu'=>$menu,'auth_list'=>$auth_list);
        return view('form')->assign($assign);
    }

    public function save(Request $request)
    {
        $data = $request->param();
        $id=$data['id'];
        if($id!=0){
            $menus=MenuModel::get($id);
            $map = array(
                'id' => $id
            );
            if ($menus->allowField(true)->validate(true)->editData($map, $data)) {
                $array=array('flag'=>true,'message'=>'修改成功','level'=>'success');
                return json($array);
            } else {
                $array=array('flag'=>false,'message'=>$menus->getErrors(),'level'=>'error');
                return json($array);
            }
        } else{
            $menus=new MenuModel();
            if ($menus->allowField(true)->validate(true)->addData($data)) {
                $array=array('flag'=>true,'message'=>'添加成功','level'=>'success');
                return json($array);
            }else{
                $array=array('flag'=>false,'message'=>$menus->getErrors(),'level'=>'error');
                return json($array);            }
        }

    }

    public function delete($id)
    {
        $map=array(
            'id'=>$id
        );
        $auth=new MenuModel();
        if($auth->deleteData($map)){
            $this->redirect('index');
        }else{
            $array=array('flag'=>false,'message'=>$auth->getErrors(),'level'=>'error');
            return json($array);
        }
    }

    public function order(Request $request){
        $data = $request->post();
        $menu=new MenuModel();
        //dump($data);
        //die();
        $result=$menu->orderData($data);
        if($result){
            $array=array('flag'=>true,'message'=>'排序成功','level'=>'success');
            return json($array);
          //  $this->redirect('index');
        }else{
            $array=array('flag'=>false,'message'=>$menu->getErrors(),'level'=>'error');
            return json($array);
        }
    }

}