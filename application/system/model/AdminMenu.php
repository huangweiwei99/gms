<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/4
 * Time: 17:55
 */

namespace app\system\model;

use app\common\model\SystemBase as SystemBaseModel;


class AdminMenu extends SystemBaseModel
{

    public function deleteData($map){
        $count=$this
            ->where(array('pid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $result=$this->where($map)->delete();
        return $result;
    }

    public function getTreeData($type='tree',$order='', $name = 'name', $child = 'id', $parent = 'pid'){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order('order_number is null,'.$order)->select();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\org\nx\Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=\org\nx\Data::channelLevel($data,0,'&nbsp;','id');
//            // 显示有权限的菜单
//            $auth=new TpAuth();
//            foreach ($data as $k => $v) {
//                if ($auth->check($v['mca'],Session::get('user')['id'])) {
//                    foreach ($v['_data'] as $m => $n) {
//                        if(!$auth->check($n['mca'],Session::get('user')['id'])){
//                            unset($data[$k]['_data'][$m]);
//                        }
//                    }
//                }else{
//                    // 删除无权限的菜单
//                    unset($data[$k]);
//                }
//            }
        }
        // p($data);die;
        return $data;
    }
}