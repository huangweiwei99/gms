<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/4/22
 * Time: 14:01
 */
namespace app\account\validate;

use app\common\validate\Base as BaseValidate;


class Auth extends BaseValidate
{
    protected $rule = [
        ['title','require|min:2|max:20|token','权限名不能为空|权限名至少2个字符|权限名至多20个字符|令牌无效请刷新再试'],
        ['name','require','权限不能为空']
    ];


}