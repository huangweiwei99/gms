<?php
namespace app\account\validate;

use app\common\validate\Base as BaseValidate;

class User extends BaseValidate
{
    protected $rule = [
        ['username', 'require|min:2|token','用户名不能为空|用户名至少5个字符|令牌无效请刷新再试'],
        ['phone', 'require|length:11','手机号码不能为空|手机号码是11位'],
        ['email','require|email','电子邮箱不能为空|请填写正确的电邮格式'],
        ['password','require','密码不能为空']
    ];

    protected $scene = [
        'edit'  =>  ['username','email','phone'],
        'add'   => ['username','email','phone','password'],
        'updatepw'=>['password']
    ];
}