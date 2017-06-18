<?php
/**
 * Created by PhpStorm.
 * User: huangweiwei
 * Date: 2017/5/26
 * Time: 13:23
 */

namespace app\common\model;


class OABase extends Base
{
    protected $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => 'localhost',
        // 数据库名
        'database'    => 'gms_oa',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => 'root',
        // 端口
        'hostport'        => '8889',
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => 'gms_',
        // 数据库调试模式
        'debug'       => false,
    ];
}