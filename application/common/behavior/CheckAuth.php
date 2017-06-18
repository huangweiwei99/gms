<?php
namespace app\common\behavior;
use think\Session;
use tpauth\Auth as TpAuth;
use app\system\model\AuditLog as AuditLogModel;
use ReflectionMethod;

class CheckAuth
{
    public function run($controller, $request)
    {
        if($request){
            return  $this->getAuth($request);
        }
    }

    private function getAuth($request)
    {
        $module=$request->module();
        $controller=$request->controller();
        $action=$request->action();
        if($module=='index'&&$controller=='Admin'&&$action=='login'){
            return true;
        }elseif($module=='index'&&$controller=='Admin'&&$action=='index'){
            return true;
        }elseif($module=='index'&&$controller=='Admin'&&$action=='logout'){
            return true;
        }else{
            $name = $module.'/'.$controller.'/'.$action;
            $auth =new TpAuth();
            $result=$auth->check($name,Session::get('user')['id']);
           // return $result?true:false;
            return true;
        }

    }

     private function writeAuditLog($request)
     {
         $module=$request->module();
         $controller=$request->controller();
         $action=$request->action();

         $audit_log=new AuditLogModel();
         $data=array(
             'user_id'=>empty(Session::get('user')['id'])?null:Session::get('user')['id'],
             'module'=>$module,
             'controller'=>$controller,
             'action'=>$action,
             'value'=>empty($request->param())?null:json_encode($request->param()),
             'log_time'=>time(),
             'ip'=>$request->ip()
             );
         $result = $audit_log->addData($data);
         if($result){
             return true;
         }else{
             return false;
         }
     }
}