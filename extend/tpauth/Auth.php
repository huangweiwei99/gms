<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: luofei614 <weibo.com/luofei614>
// +----------------------------------------------------------------------
// | 修改者: anuo (本权限类在原3.2.3的基础上修改过来的)
// +----------------------------------------------------------------------
namespace tpauth;

use think\Db;
use think\Config;
use think\Session;
use think\Request;
use think\Loader;

/**
 * 权限认证类
 * 功能特性：
 * 1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      $auth=new Auth();  $auth->check('规则名称','用户id')
 * 2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth=new Auth();  $auth->check('规则1,规则2','用户id','and')
 *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限。 当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
 * 3，一个用户可以属于多个用户组(think_auth_group_access表 定义了用户所属用户组)。我们需要设置每个用户组拥有哪些规则(think_auth_group 定义了用户组权限)
 * 4，支持规则表达式。
 *      在think_auth_rule 表中定义一条规则时，如果type为1， condition字段就可以定义规则表达式。 如定义{score}>5  and {score}<100
 * 表示用户的分数在5-100之间时这条规则才会通过。
 */
//数据库
/*
-- ----------------------------
-- think_auth_rule，规则表，
-- id:主键，name：规则唯一标识, title：规则中文名称 status 状态：为1正常，为0禁用，condition：规则表达式，为空表示存在就验证，不为空表示按照条件验证
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_rule`;
CREATE TABLE `think_auth_rule` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name` char(80) NOT NULL DEFAULT '',
    `title` char(20) NOT NULL DEFAULT '',
    `type` tinyint(1) NOT NULL DEFAULT '1',
    `status` tinyint(1) NOT NULL DEFAULT '1',
    `condition` char(100) NOT NULL DEFAULT '',  # 规则附件条件,满足附加条件的规则,才认为是有效的规则
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- ----------------------------
-- think_auth_group 用户组表，
-- id：主键， title:用户组中文名称， rules：用户组拥有的规则id， 多个规则","隔开，status 状态：为1正常，为0禁用
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group`;
    CREATE TABLE `think_auth_group` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `title` char(100) NOT NULL DEFAULT '',
    `status` tinyint(1) NOT NULL DEFAULT '1',
    `permission` char(80) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- ----------------------------
-- think_auth_group_access 用户组明细表
-- user_id:用户id，role_id：用户组id
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group_access`;
    CREATE TABLE `think_auth_group_access` (
    `user_id` mediumint(8) unsigned NOT NULL,
    `role_id` mediumint(8) unsigned NOT NULL,
    UNIQUE KEY `user_id_role_id` (`user_id`,`role_id`),
    KEY `user_id` (`user_id`),
    KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */

class Auth
{
    /**
     * @var object 对象实例
     */
    protected static $instance;
    /**
     * 当前请求实例
     * @var Request
     */
    protected $request;

    //默认配置
    protected $config = [
        /******数据库连接******/

        // 数据库类型
        'type'            => 'mysql',
        // 服务器地址
        'hostname'        => 'localhost',
        // 数据库名
        'database'        => 'gms_account',
        // 用户名
        'username'        => 'root',
        // 密码
        'password'        => 'root',
        // 端口
        'hostport'        => '8888',
        // 连接dsn
        'dsn'             => '',
        // 数据库连接参数
        'params'          => [],
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => 'gms_',
        // 数据库调试模式
        'debug'           => true,
        // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'deploy'          => 0,
        // 数据库读写是否分离 主从式有效
        'rw_separate'     => false,
        // 读写分离后 主服务器数量
        'master_num'      => 1,
        // 指定从服务器序号
        'slave_no'        => '',
        // 是否严格检查字段是否存在
        'fields_strict'   => true,
        // 数据集返回类型
        'resultset_type'  => 'array',
        // 自动写入时间戳字段
        'auto_timestamp'  => false,
        // 时间字段取出后的默认时间格式
        'datetime_format' => 'Y-m-d H:i:s',
        // 是否需要进行SQL性能分析
        'sql_explain'     => false,

        /******权限认证******/
        // 权限开关
        'auth_on'           => 1,
        // 认证方式，1为实时认证；2为登录认证。
        'auth_type'         => 1,
        // 用户组数据表名
        'auth_group'        => 'role',//'auth_group',
        // 用户-用户组关系表
        'auth_group_access' => 'user_role',//'auth_group_access',
        // 权限规则表
        'auth_rule'         => 'auth',//'auth_rule',
        // 用户信息表
        'auth_user'         => 'user'//'member',
    ];

    /**
     * 类架构函数
     * Auth constructor.
     */
    public function __construct()
    {
        //可设置配置项 auth, 此配置项为数组。
        if ($auth = Config::get('auth')) {
            $this->config = array_merge($this->config, $auth);
        }
        // 初始化request
        $this->request = Request::instance();

    }

    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return \think\Request
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }

        return self::$instance;
    }

    /**
     * 检查权限
     * @param        $name     string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param        $user_id     int           认证用户的id
     * @param int    $type     认证类型
     * @param string $mode     执行check的模式
     * @param string $relation 如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return bool               通过验证返回true;失败返回false
     */
    public function check($name, $user_id, $type = 1, $mode = 'url', $relation = 'or')
    {
        if (!$this->config['auth_on']) {
            return true;
        }
        // 获取用户需要验证的所有有效规则列表
        $authList = $this->getAuthList($user_id, $type);

        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = [$name];
            }
        }
        $list = []; //保存验证通过的规则名
        if ('url' == $mode) {
            $REQUEST = unserialize(strtolower(serialize($this->request->param())));
        }
        foreach ($authList as $auth) {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ('url' == $mode && $query != $auth) {
                parse_str($query, $param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST, $param);
                $auth      = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $name) && $intersect == $param) {
                    //如果节点相符且url参数满足
                    $list[] = $auth;
                }
            } else {
                if (in_array($auth, $name)) {
                    $list[] = $auth;
                }
            }
        }
        if ('or' == $relation && !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ('and' == $relation && empty($diff)) {
            return true;
        }

        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param  $user_id int     用户id
     * @return array       用户所属的用户组 array(
     *              array('user_id'=>'用户id','role_id'=>'用户组id','title'=>'用户组名称','permission'=>'用户组拥有的规则id,多个,号隔开'),
     *              ...)
     */
    public function getGroups($user_id)
    {
        static $groups = [];
        if (isset($groups[$user_id])) {
            return $groups[$user_id];
        }
        // 转换表名
        $auth_group_access = Loader::parseName($this->config['auth_group_access'], 1);
        $auth_group        = Loader::parseName($this->config['auth_group'], 1);
        // 执行查询
        $user_groups  = Db::connect($this->config)->view($auth_group_access, 'user_id,role_id')
            ->view($auth_group, 'title,permission', "{$auth_group_access}.role_id={$auth_group}.id", 'LEFT')
            ->where("{$auth_group_access}.user_id='{$user_id}' and {$auth_group}.status='1'")
            ->select();

        $groups[$user_id] = $user_groups ?: [];

        return $groups[$user_id];
    }

    /**
     * 获得权限列表
     * @param integer $user_id 用户id
     * @param integer $type
     * @return array
     */
    protected function getAuthList($user_id, $type)
    {
        static $_authList = []; //保存用户验证通过的权限列表
        $t = implode(',', (array)$type);
        if (isset($_authList[$user_id . $t])) {
            return $_authList[$user_id . $t];
        }
        if (2 == $this->config['auth_type'] && Session::has('_auth_list_' . $user_id . $t)) {
            return Session::get('_auth_list_' . $user_id . $t);
        }
        //读取用户所属用户组
        $groups = $this->getGroups($user_id);

        $ids    = []; //保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['permission'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$user_id . $t] = [];

            return [];
        }
        $map = [
            'id'   => ['in', $ids],
            'type' => $type
        ];
        //读取用户组所有权限规则
        $permission = Db::connect($this->config)->name($this->config['auth_rule'])->where($map)->field('condition,name')->select();
        //循环规则，判断结果。
        $authList = []; //
        foreach ($permission as $rule) {
            if (!empty($rule['condition'])) {
                //根据condition进行验证
                $user    = $this->getUserInfo($user_id); //获取用户信息,一维数组
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $authList[] = strtolower($rule['name']);
                }
            } else {
                //只要存在就记录
                $authList[] = strtolower($rule['name']);
            }
        }
        $_authList[$user_id . $t] = $authList;
        if (2 == $this->config['auth_type']) {
            //规则列表结果保存到session
            Session::set('_auth_list_' . $user_id . $t, $authList);
        }

        return array_unique($authList);
    }

    /**
     * 获得用户资料
     * @param $user_id
     * @return mixed
     */
    protected function getUserInfo($user_id)
    {
        static $user_info = [];

        $user = Db::connect($this->config)->name($this->config['auth_user']);
        // 获取用户表主键
        $_pk = is_string($user->getPk()) ? $user->getPk() : 'user_id';
        if (!isset($user_info[$user_id])) {
            $user_info[$user_id] = $user->where($_pk, $user_id)->find();
        }

        return $user_info[$user_id];
    }
}
