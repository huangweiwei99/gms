<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/9
 * Time: 19:13
 */

namespace app\common\behavior;

use ReflectionMethod;


class Test
{
    public function run($controller, $request)
    {
        if($request){
            return  $this->Reflection($request);
        }

    }

    private function Reflection($request)
    {
        $module=$request->module();
        $controller=$request->controller();
        $action=$request->action();

        $method = new ReflectionMethod($controller, $action);
        $params = $method->getParameters();
//            foreach ($params as $param) {
//                $paramName = $param->getName();
//                if (isset($_REQUEST[$paramName])) {
//                    $args[] = $_REQUEST[$paramName];
//                } elseif ($param->isDefaultValueAvailable()) {
//                    $args[] = $param->getDefaultValue();
//                }
//            }
         dump($params);
    }
}