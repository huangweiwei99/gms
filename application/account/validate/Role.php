<?php
namespace app\account\validate;

use app\common\validate\Base as BaseValidate;

class Role extends BaseValidate
{
    protected $rule = [
        ['title','require|min:5|token','用户组名称不能为空|用户组名称至少是5个字符|令牌无效请刷新再试'],
    ];
}