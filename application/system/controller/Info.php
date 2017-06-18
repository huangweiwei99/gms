<?php

namespace app\system\controller;


use think\Request;
use app\common\controller\Admin as AdminController;

class Info extends AdminController
{

    public function index()
    {
        
        $sysinfo   = \plugin\SysinfoPlugin::getinfo();
        $os        = explode(' ', php_uname());
        $net_state = null; //网络使用状况
        
        if ($sysinfo['sysReShow'] == 'show' && false !== ($strs = @file("/proc/net/dev"))) {
            for ($i = 2; $i < count($strs); $i++) {
                preg_match_all("/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info);
                $net_state.="{$info[1][0]} : 已接收 : <font color=\"#CC0000\"><span id=\"NetInput{$i}\">" . $sysinfo['NetInput' . $i] . "</span></font> GB &nbsp;&nbsp;&nbsp;&nbsp;已发送 : <font color=\"#CC0000\"><span id=\"NetOut{$i}\">" . $sysinfo['NetOut' . $i] . "</span></font> GB <br />";
            }
        }
        $assign=array(
            'os'=>$os,
            'sysinfo'=>$sysinfo,
            'net_state'=>$net_state
        );
        //dump($net_state);
       return view()->assign($assign);
    }

    public function create()
    {
        //
    }

    public function save(Request $request)
    {
        //
    }

    public function read($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
