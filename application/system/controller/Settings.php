<?php
namespace app\system\controller;

use think\Request;
use app\common\controller\Admin as AdminController;
use app\system\model\AdminMenu as MenuModel;
use app\system\model\Settings as SettingsModel;

class Settings extends AdminController
{
    public function index(Request $request)
    {
        $data = $request->post();
        if(!empty($data)){
            $settings=new SettingsModel();
            $count=$settings::get(1);
            if($count){
                $map = array(
                    'id' => 1
                );
                if($settings->editData($map,$data)){
                   // $array=array('flag'=>true,'message'=>'修改成功','level'=>'success');
                   // return json($array);
                    $this->redirect('index');
                }else{
                    $array=array('flag'=>false,'message'=>$settings->getErrors(),'level'=>'error');
                    return json($array);
                }
            }else{


                if($settings->allowField(true)->validate(true)->addData($data)){
                   // $array=array('flag'=>true,'message'=>'添加成功','level'=>'success');
                   // return json($array);
                    $this->redirect('index');
                }else{
                    $array=array('flag'=>false,'message'=>$settings->getErrors(),'level'=>'error');
                    return json($array);
                }
            }

        }else{
            $settings=SettingsModel::get(1);
            $assign=array('settings'=>$settings);
            return view()->assign($assign);
        }
    }

    public function create($pid=null)
    {
        $auth_list=AuthModel::all();
        if(isset($pid)){
            $menu=new MenuModel();
            $menu->pid=$pid;
            $assign=array('menu'=>$menu,'auth_list'=>$auth_list);
        }else{
            $assign=array('auth_list'=>$auth_list);
        }
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
                return json($array);
            }
        }

    }

    public function delete($id)
    {

    }

}