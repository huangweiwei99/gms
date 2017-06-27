<?php
namespace app\system\controller;

use think\Request;
use app\common\controller\Admin as AdminController;


class Settings extends AdminController
{
    public function index(Request $request)
    {
        $data = $request->post();
        if(!empty($data)){
            $result=$this->systemService()->saveSetting($data);
            if($result['flag']){
                $this->redirect('index');
            }
            return json($result);
        }else{
            $assign=array('settings'=>$this->systemService()->getSettingById(1));
            return view()->assign($assign);
        }
    }

}