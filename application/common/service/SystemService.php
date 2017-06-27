<?php
namespace app\common\service;

use app\common\service\BaseService;
use app\system\model\AdminMenu as MenuModel;
use app\system\model\Settings as SettingsModel;
//use app\account\model\Auth as AuthModel;

class SystemService extends BaseService
{
    
    ////////////////////////AdminMenu////////////////////////
    public function  AdminMenu($pid=null){
        $menu=new MenuModel();
        $menu->mca=null;
        $menu->pid=isset($pid)?$pid:null;
        return $menu;
    }
    
    public function getAdminMenuById($id) {
        $adminmenu=MenuModel::get($id);
        return $adminmenu;
    }
    
    public function getAdminMenu($param) {
        ;
    }
    
    public function getAdminMenuList($param) {
        ;
    }
    
    public function getAdminMenuLevel(){
        $menu=new MenuModel();
        return $menu->getTreeData('level','order_number,id');
        
    }
    
    public function getAdminMenuTree(){
        $menu=new MenuModel();
        return $menu->getTreeData('tree','order_number,id');
    }
    
    public function saveAdminMenu($param) {
        if($param['id']!=0){
            $adminmenu=$this->getAdminMenuById($param['id']);
            $result=$adminmenu->allowField(true)->validate(true)->editData(['id'=>$param['id']], $param);
            return $adminmenu->getMessage($result);
        }else{
            $adminmenu= new MenuModel();
            $result=$adminmenu->allowField(true)->validate(true)->addData($param);
            return $adminmenu->getMessage($result);
        }
    }
    
    public function saveAdminMenList($param) {
        ;
    }
    
    public function orderAdminMenu($param){
        $adminmenu=new MenuModel();
        $result=$adminmenu->orderData($param);
        return $adminmenu->getMessage($result);
    }
    
    public function deleteAdminMenu($param=array()) {
        $adminmenu=$this->getAdminMenuById($param['id']);
        if($adminmenu!=null){
            $result = $adminmenu->deleteData($param);
            return $result;
        }
        return false;
    }
    
    public function deleteAdminMenList($param) {
        ;
    }

    ////////////////////////Settings////////////////////////
    
    public function getSettingById($id) {
        $setting=SettingsModel::get($id);
        return $setting;
    }
    
    public function getSetting($param) {
        $setting=SettingModel::all($param);
        return $setting;
    }
    
    public function getSettings($param=null) {
        if(isset($param)){
            
        }else{
            return SettingModel::all();
        }
    }
    
    public function saveSetting($param) {
        $setting=$this->getSettingById(1);
        if($setting){
            $result=$setting->editData(['id'=>1],$param);
            return $setting->getMessage($result);
        }else{
            $result=$setting->allowField(true)->validate(true)->addData($data);
            return  $setting->getMessage($result);
        }
    }
    
    public function saveSettings($param) {
        ;
    }
    
    public function deleteSetting($param) {
        ;
    }
    
    public function deleteSettings($param) {
        ;
    }
    
    ////////////////////////Info////////////////////////
    
    public function getInfoById($id) {
        ;
    }
    
    public function getInfo($param){
        
    }
    
    public function getInfoList($param){
        
    }
    
    ////////////////////////Log////////////////////////
    
    public function getLogById($id) {
        ;
    }
    
}

