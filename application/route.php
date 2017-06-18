<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
        'id' => '\d+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'account/auth/:id' => 'account/auth/read',
    'account/auth/edit/:id' => 'account/auth/edit',
    'account/auth/update/:id' => 'account/auth/update',
    'account/auth/delete/:id' => 'account/auth/delete',

    'account/user/:id' => 'account/user/read',
    'account/user/edit/:id' => 'account/user/edit',
    'account/user/update/:id' => 'account/user/update',
    'account/user/delete/:id' => 'account/user/delete',

   
    'account/role/:id' => 'account/role/read',
    'account/role/edit/:id' => 'account/role/edit',
    'account/role/update/:id' => 'account/role/update',
    'account/role/delete/:id' => 'account/role/delete',

    'account/todo/selectstaff/:id'=>'account/todo/selectstaff',
    'account/todo/readtask/:id'=>'account/todo/readtask',

    'system/adminmenu/:id' => 'system/adminmenu/read',
    'system/adminmenu/edit/:id' => 'system/adminmenu/edit',
    'system/adminmenu/update/:id' => 'system/adminmenu/update',
    'system/adminmenu/delete/:id' => 'system/adminmenu/delete',

    'oa/branch/:id' => 'oa/branch/read',
    'oa/branch/edit:id' => 'oa/branch/edit',
    'oa/branch/update/:id' => 'oa/branch/update',
    'oa/branch/delete/:id' => 'oa/branch/delete',



];
