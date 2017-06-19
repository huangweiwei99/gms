<?php

namespace app\common\controller;

use app\common\service\AccountService;
use app\system\model\Settings;
use think\Request;
use think\Session;
use think\Hook;
use app\account\model\Auth as AuthModel;
use app\system\model\AdminMenu as MenuModel;
use app\system\model\Settings as SettingsModel;

class Admin extends Base
{

    public function _initialize()
    {

        $request = Request::instance();
        // 添加钩子
        $result = Hook::listen('controller_init', $this, $request, true);
        if ($result) {
            $this->getBreadcrumb();
            $this->getMenu();
            $this->getSettings();
           // Hook::listen('action_begin', $this, $request, true);
           // $result2 = Hook::listen('action_begin', $this, $request, true);
        }else{
            //$this->error('请正确登陆','index/admin/login');
            if(Session::get('user')){
                $this->error('没有授权');
            }else{
                $this->error('非法登录','index/admin/login');
            }

        }
        parent::_initialize();

    }

    private function getBreadcrumb(){

        $request = Request::instance();
        $name = $request->module().'/'.$request->controller().'/'.$request->action();
        $current_auth = AuthModel::get(['name' => strtolower($name)]);//获取当前页面

        $breadcrumb = array();
       // dump(strtolower($name));
        if($current_auth){
            $pid = $current_auth->pid;
            $x = 1;
            while ($pid != 0) {
                if ($x <=2) {//显示二级连接
                    $parent = AuthModel::get($pid);
                    $pid = $parent->pid;
                    $array = array($x => $parent);
                    $breadcrumb = array_merge($breadcrumb, $array);
                    $x++;
                }else{
                    break;
                }
            }
            krsort($breadcrumb);
            $assign=array('breadcrumb'=>$breadcrumb,'current_page'=> $current_auth,'user'=>Session::get('user'));
            $this->assign($assign);
        }else{
            $assign=array('breadcrumb'=>array(),'current_page'=>'错误页','user'=>Session::get('user'));
        }
        $this->assign($assign);
    }

    private function getMenu(){
        $menu=new MenuModel();
        $menus=$menu->getTreeData('level','order_number,id');
       // dump($menus);
        $assign=array('nav'=>$menus);
        $this->assign($assign);

    }

    private function  getSettings(){
        $settings=new SettingsModel();
        $setting=$settings->find(1);
        $assign=array('setting'=>$setting);
        $this->assign($assign);
    }

    public function upload(Request $request,$path=null)
    {
        // 获取表单上传文件
        $file = $request->file('file');
        // 上传文件验证
        $result = $this->validate(['file' => $file], ['file' => 'require|image'], ['file.require' => '请选择上传文件', 'file.image' => '非法图像文件']);
        if (true !== $result) {
            $this->error($result);
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $this->success('文件上传成功：' . $info->getRealPath());
        } else {
        // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }

    public function picture(Request $request)
    {
        // 获取表单上传文件
        $file = $request->file('image');
        if (true !== $this->validate(['image' => $file], ['image' => 'require|image']))
        {
            $this->error('请选择图像文件');
        } else {
            // 读取图片
            $image = Image::open($file);
            // 图片处理
            switch ($request->param('type')) {
                case 1: // 图片裁剪
                    $image->crop(300, 300);
                    break;
                case 2: // 缩略图
                    $image->thumb(150, 150, Image::THUMB_CENTER);
                    break;
                case 3: // 垂直翻转
                    $image->flip();
                    break;
                case 4: // 水平翻转
                    $image->flip(Image::FLIP_Y);
                    break;
                case 5: // 图片旋转
                    $image->rotate();
                    break;
                case 6: // 图片水印
                    $image->water('./logo.png', Image::WATER_NORTHWEST, 50);
                    break;
                case 7: // 文字水印
                    $image->text('ThinkPHP', VENDOR_PATH . 'topthink/think-captcha/assets/ttfs/1.ttf', 20, '#ffffff');
                    break;
            }
            // 保存图片（以当前时间戳）
            $saveName = $request->time() . '.png';
            $image->save(ROOT_PATH . 'public/uploads/' . $saveName);
            $this->success('图片处理完毕...', '/uploads/' . $saveName, 1);
        }
    }

    protected function uploadAvatar(Request $request)
    {
        // 获取表单上传文件
        $file = $request->file('avatar');
        // 上传文件验证
        $result = $this->validate(['avatar' => $file], ['avatar' => 'require|image'], ['avatar.require' => '请选择上传文件', 'avatar.image' => '非法图像文件']);
        if (true !== $result) {
            $this->error($result);
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'. DS .'avatar');
        if ($info) {
            $this->success('文件上传成功：' . $info->getRealPath());
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }
    }
    
    public function accountService($param=null) {
       return new AccountService();
    }
}

