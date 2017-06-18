<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/17
 * Time: 10:16
 */

namespace app\account\validate;

use app\common\validate\Base as BaseValidate;


class Profile extends BaseValidate
{

    protected $rule = [
        ['first_name','chsAlpha','名字只能是数字或者字母'],
        ['last_name','chsAlpha','姓氏只能是数字或者字母'],
        ['qq','number','请输入正确的qq号'],
        ['website','activeUrl','请输入有效的域名或者IP'],
        ['new_password','require|confirm:retype_password','确认密码不相同']
        //['avatar','file|fileSize:1048576','请上传正确的文件|文件只能少于等于1MB'],

    ];

    protected $scene = [
        'editpw'  =>  ['first_name','last_name','qq','website','new_password'],
        'general'=>  ['first_name','last_name','qq','website'],
    ];
}