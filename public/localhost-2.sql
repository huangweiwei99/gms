-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: 2017-06-17 20:59:01
-- 服务器版本： 5.5.42
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gms_account`
--
CREATE DATABASE IF NOT EXISTS `gms_account` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gms_account`;

-- --------------------------------------------------------

--
-- 表的结构 `gms_access`
--

DROP TABLE IF EXISTS `gms_access`;
CREATE TABLE `gms_access` (
  `user_id` int(6) unsigned NOT NULL COMMENT '用户ID',
  `role_id` int(5) unsigned NOT NULL COMMENT '角色ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_access`
--

INSERT INTO `gms_access` (`user_id`, `role_id`) VALUES
(2, 2),
(3, 3),
(1, 3),
(1, 2),
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `gms_admin_menu`
--

DROP TABLE IF EXISTS `gms_admin_menu`;
CREATE TABLE `gms_admin_menu` (
  `id` int(11) unsigned NOT NULL COMMENT '菜单表',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `mca` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `ico` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `order_number` int(11) unsigned DEFAULT NULL COMMENT '排序',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_admin_menu`
--

INSERT INTO `gms_admin_menu` (`id`, `pid`, `name`, `mca`, `ico`, `order_number`, `create_time`, `update_time`) VALUES
(1, 0, '数据分析', '', '', NULL, 1493798412, 1493798412),
(2, 0, '我的应用', '', '', NULL, 1493798429, 1493798429),
(3, 0, '系统设置', '', '', NULL, 1493798451, 1493798451),
(4, 0, '功能模块', '', '', NULL, 1493798465, 1493798465),
(5, 3, '设置管理', '', '', NULL, 1493798513, 1493798513),
(6, 3, '权限控制', 'account', '', NULL, 1493798568, 1493798568),
(7, 3, '系统信息', 'setting', '', NULL, 1493798590, 1493798590),
(8, 5, '菜单排序', 'system/adminmenu', '', NULL, 1493798616, 1493911185),
(9, 5, '基本信息', 'system/info', '', NULL, 1493798640, 1493911204),
(10, 6, '权限管理', 'account/auth/index', 'icon-layers', NULL, 1493798671, 1493873157),
(11, 6, '用户组管理', 'account/role/index', 'icon-users', NULL, 1493798716, 1493873118),
(12, 6, '管理员列表', 'account/user/index', 'icon-user', NULL, 1493798744, 1493873006),
(13, 7, '运行信息', 'system/info', '', NULL, 1493799049, 1493799049),
(14, 7, '系统日志', 'system/log', '', NULL, 1493799078, 1493799078),
(15, 1, '仪表板', '', '', NULL, 1493800667, 1493800667),
(16, 15, '数据汇总', '', '', NULL, 1493800694, 1493800694),
(17, 15, '智能分析', '', '', NULL, 1493800713, 1493800713),
(18, 15, '数据导出', '', '', NULL, 1493800726, 1493800726),
(19, 2, '我的通知', '', '', NULL, 1493800745, 1493800745),
(20, 2, '我的信息', '', '', NULL, 1493800756, 1493800756),
(21, 2, '我的任务', '', '', NULL, 1493800769, 1493800769),
(22, 19, '通知列表', '', '', NULL, 1493800797, 1493800797),
(23, 20, '信息列表', '', '', NULL, 1493800814, 1493800814),
(24, 21, '任务列表', '', '', NULL, 1493800857, 1493800857);

-- --------------------------------------------------------

--
-- 表的结构 `gms_auth`
--

DROP TABLE IF EXISTS `gms_auth`;
CREATE TABLE `gms_auth` (
  `id` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `title_explain` varchar(100) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='规则表';

--
-- 转存表中的数据 `gms_auth`
--

INSERT INTO `gms_auth` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`, `title_explain`, `create_time`, `update_time`) VALUES
(1, 0, 'account', '账号控制', 1, 1, '', '', 1493358841, 1494229535),
(2, 1, 'account/auth', '权限管理', 1, 1, '', '', 1493358889, 1493362025),
(3, 1, 'account/role', '用户组管理', 1, 1, '', '', 1493358920, 1493362136),
(4, 1, 'account/user', '管理员列表', 1, 1, '', '', 1493358937, 1493362141),
(5, 2, 'account/auth/create', '添加权限', 1, 1, '', '创建新的权限', 1493359012, 1493359012),
(6, 2, 'account/auth/read', '修改权限', 1, 1, '', '修改原有的权限', 1493359064, 1493360325),
(7, 2, 'account/auth/save', '保存权限', 1, 1, '', '保存添加或修改权限的结果', 1493359156, 1493360369),
(8, 2, 'account/auth/delete', '删除权限', 1, 1, '', '删除原有的权限', 1493359184, 1493360339),
(20, 2, 'account/auth/index', '权限列表', 1, 1, '', '', 1493362122, 1493362122),
(9, 3, 'account/role/index', '用户组列表', 1, 1, '', '', 1493360409, 1493362170),
(10, 3, 'account/role/create', '添加用户组', 1, 1, '', '', 1493361051, 1493551869),
(11, 3, 'account/role/read', '修改用户组', 1, 1, '', '', 1493361091, 1493361091),
(12, 3, 'account/role/save', '保存用户组', 1, 1, '', '', 1493361126, 1493361289),
(13, 4, 'account/user/index', '管理员列表', 1, 1, '', '', 1493361209, 1493361209),
(14, 4, 'account/user/create', '添加管理员', 1, 1, '', '', 1493361228, 1493361228),
(15, 4, 'account/user/read', '修改管理员', 1, 1, '', '', 1493361253, 1493361253),
(16, 3, 'account/role/delete', '删除用户组', 1, 1, '', '', 1493361329, 1493361329),
(17, 4, 'account/user/save', '保存管理员', 1, 1, '', '', 1493361351, 1493361351),
(18, 4, 'account/user/delete', '删除管理员', 1, 1, '', '', 1493361373, 1493361373),
(30, 28, 'system/adminmenu/index', '菜单列表', 1, 1, '', '', 1493912127, 1493912127),
(31, 26, 'system/info/index', '运行状态', 1, 1, '', '', 1494068969, 1494068969),
(25, 0, 'system', '系统设置', 1, 1, '', '', 1493798917, 1493908827),
(26, 25, 'system/info', '运行信息', 1, 1, '', '', 1493798968, 1493798968),
(27, 25, 'system/log', '系统日志', 1, 1, '', '', 1493799008, 1493799008),
(28, 25, 'system/adminmenu', '后台菜单', 1, 1, '', '', 1493908935, 1493909513),
(29, 25, 'system/settings', '基本设置', 1, 1, '', '', 1493909017, 1493910793),
(32, 27, 'system/log/index', '日志管理', 1, 1, '', '', 1494068994, 1494068994),
(33, 29, 'system/settings/index', '设置面板', 1, 1, '', '', 1494069071, 1494069071),
(34, 1, 'account/profile', '我的通知', 1, 1, '', '', 1494229693, 1494229693),
(35, 1, 'account/inbox', '我的信息', 1, 1, '', '', 1494229718, 1494229718),
(36, 1, 'account/todo', '我的任务', 1, 1, '', '', 1494229746, 1494229746),
(37, 34, 'account/profile/index', '通知列表', 1, 1, '', '', 1494229783, 1494229783),
(38, 35, 'account/inbox/index', '信息列表', 1, 1, '', '', 1494229825, 1494229825),
(39, 36, 'account/todo/index', '任务列表', 1, 1, '', '', 1494229849, 1494229849),
(43, 0, 'feature', '功能模块', 1, 1, '', '', 1495865634, 1495865634),
(44, 43, ' oa', 'OA管理', 1, 1, '', '', 1495865701, 1495865701),
(45, 44, 'oa/branch', ' 部门设置', 1, 1, '', '', 1495865765, 1495865900),
(46, 45, 'oa/branch/index', '部门管理', 1, 1, '', '管理各个部门', 1495865929, 1495865929);

-- --------------------------------------------------------

--
-- 表的结构 `gms_profile`
--

DROP TABLE IF EXISTS `gms_profile`;
CREATE TABLE `gms_profile` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `interest` varchar(10000) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `position` varchar(50) NOT NULL,
  `about` varchar(1000) NOT NULL,
  `qq` int(11) DEFAULT NULL,
  `wechat` varchar(50) NOT NULL,
  `weibo` varchar(50) NOT NULL,
  `website` varchar(500) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_profile`
--

INSERT INTO `gms_profile` (`id`, `first_name`, `user_id`, `branch_id`, `last_name`, `interest`, `avatar`, `position`, `about`, `qq`, `wechat`, `weibo`, `website`, `create_time`, `update_time`) VALUES
(1, '玄源', 1, 1, '黄', '足球', '', '项目主管', '这是我的自我介绍', 1234567, '你好大大泡泡糖', '你好大大泡泡糖', 'http://www.web.vip', 1494898448, 1494910930),
(2, '旋风', 2, 9, '陆', '踢足球', '591bf1f343e53.jpg', '运营COO', '关于我的自我介绍', 12345676, '飞翔的非洲人', '飞翔的非洲人', 'www.baidu.com', 1494918013, 1497066397),
(3, '杰克', 11, 9, '李', '', '', '', '', NULL, '', '', '', 1494918054, 1497066397);

-- --------------------------------------------------------

--
-- 表的结构 `gms_project`
--

DROP TABLE IF EXISTS `gms_project`;
CREATE TABLE `gms_project` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_project`
--

INSERT INTO `gms_project` (`id`, `title`, `content`, `create_time`, `update_time`) VALUES
(1, '物流信息系统建设1', '1.物流信息系统建设\r\n2.物流信息系统建设\r\n                                    ', 1495602563, 1495602563),
(2, '物流信息系统建设', '1.物流信息系统建设\r\n2.物流信息系统建设\r\n                                    ', 1495615727, 1495615727);

-- --------------------------------------------------------

--
-- 表的结构 `gms_project_access`
--

DROP TABLE IF EXISTS `gms_project_access`;
CREATE TABLE `gms_project_access` (
  `project_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_project_access`
--

INSERT INTO `gms_project_access` (`project_id`, `profile_id`) VALUES
(1, 2),
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `gms_role`
--

DROP TABLE IF EXISTS `gms_role`;
CREATE TABLE `gms_role` (
  `id` int(11) unsigned NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) DEFAULT '2',
  `permission` text COMMENT '权限id',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户组表';

--
-- 转存表中的数据 `gms_role`
--

INSERT INTO `gms_role` (`id`, `title`, `status`, `permission`, `create_time`, `update_time`) VALUES
(1, '超级管理员', 1, '1,2,5,6,7,8,20,3,9,10,11,12,16,4,13,14,15,17,18,25,26,27,28,30,29', 1493440897, 1493912283),
(2, '测试管理员', 1, '1,4,13,14,15,17,18', 1493552177, 1493552177),
(3, '编辑管理员', 1, '1,2,5,6,7,8,20', 1493560237, 1493560237),
(5, '销售管理员', 1, NULL, 1495680479, 1495680479),
(6, '财务管理员', 1, NULL, 1495680490, 1495680490),
(7, '行政管理员', 1, NULL, 1495680505, 1495680505);

-- --------------------------------------------------------

--
-- 表的结构 `gms_task`
--

DROP TABLE IF EXISTS `gms_task`;
CREATE TABLE `gms_task` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `due` int(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_task`
--

INSERT INTO `gms_task` (`id`, `project_id`, `profile_id`, `title`, `content`, `attachment_id`, `chat_id`, `due`, `create_time`, `update_time`) VALUES
(1, 2, 1, '召集人员', '召集人员', 0, 0, 1496246400, 1497426147, 1497426147),
(2, 1, 2, '功能设置', '功能设置', 0, 0, 1496246400, 1497441834, 1497441834);

-- --------------------------------------------------------

--
-- 表的结构 `gms_task_access`
--

DROP TABLE IF EXISTS `gms_task_access`;
CREATE TABLE `gms_task_access` (
  `task_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gms_user`
--

DROP TABLE IF EXISTS `gms_user`;
CREATE TABLE `gms_user` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '登录密码；mb_password加密',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `email_code` varchar(60) DEFAULT NULL COMMENT '激活码',
  `phone` bigint(11) unsigned DEFAULT NULL COMMENT '手机号',
  `branch_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '最后登录时间',
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_user`
--

INSERT INTO `gms_user` (`id`, `username`, `password`, `email`, `email_code`, `phone`, `branch_id`, `status`, `register_time`, `last_login_ip`, `last_login_time`, `update_time`) VALUES
(1, 'admin', 'ec7073d280a71af2c9bce3538bd478e3', 'vson.mail@gmail.com', NULL, 18927705761, 1, 1, 1493443218, '0.0.0.0', 0, 1494984721),
(2, 'test01', 'ec7073d280a71af2c9bce3538bd478e3', 'vson.mail@gmail.com', NULL, 18927705761, 9, 2, 1493552213, '0.0.0.0', 0, 1496887297),
(3, 'editor', 'ec7073d280a71af2c9bce3538bd478e3', 'vson.mail@gmail.com', NULL, 18927705761, 0, 1, 1493560256, '0.0.0.0', 0, 1493560256),
(11, '杰克', 'c3284d0f94606de1fd2af172aba15bf3', 'vson.mail@gmail.com', NULL, 18927705761, 0, 1, 1495681565, '0.0.0.0', 0, 1495681565),
(12, '汤姆', 'c3284d0f94606de1fd2af172aba15bf3', 'happymama0813@gmail.com', NULL, 13242213341, 0, 1, 1495681610, '0.0.0.0', 0, 1495681610),
(13, '珍妮', 'c3284d0f94606de1fd2af172aba15bf3', '728241771@qq.com', NULL, 14233355563, 0, 1, 1495681665, '0.0.0.0', 0, 1495681665),
(14, '陈湘', 'c3284d0f94606de1fd2af172aba15bf3', 'chengxiang@126.com', NULL, 12323321169, 0, 1, 1495681810, '0.0.0.0', 0, 1495681810),
(15, '郭靖', 'c3284d0f94606de1fd2af172aba15bf3', 'guojing@gmail.com', NULL, 18927705763, 0, 1, 1495681842, '0.0.0.0', 0, 1495681842),
(16, '陈溪石', 'c3284d0f94606de1fd2af172aba15bf3', 'xishicheng@gmail.com', NULL, 18944554321, 0, 1, 1495681935, '0.0.0.0', 0, 1495681935),
(17, '李正', 'c3284d0f94606de1fd2af172aba15bf3', 'lizheng@tom.com', NULL, 18928807891, 0, 1, 1495682078, '0.0.0.0', 0, 1495682078);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gms_admin_menu`
--
ALTER TABLE `gms_admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_auth`
--
ALTER TABLE `gms_auth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `gms_profile`
--
ALTER TABLE `gms_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_project`
--
ALTER TABLE `gms_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_role`
--
ALTER TABLE `gms_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_task`
--
ALTER TABLE `gms_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_user`
--
ALTER TABLE `gms_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_key` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gms_admin_menu`
--
ALTER TABLE `gms_admin_menu`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `gms_auth`
--
ALTER TABLE `gms_auth`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `gms_profile`
--
ALTER TABLE `gms_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gms_project`
--
ALTER TABLE `gms_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gms_role`
--
ALTER TABLE `gms_role`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `gms_task`
--
ALTER TABLE `gms_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gms_user`
--
ALTER TABLE `gms_user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;--
-- Database: `gms_oa`
--
CREATE DATABASE IF NOT EXISTS `gms_oa` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gms_oa`;

-- --------------------------------------------------------

--
-- 表的结构 `gms_branch`
--

DROP TABLE IF EXISTS `gms_branch`;
CREATE TABLE `gms_branch` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `pid` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_branch`
--

INSERT INTO `gms_branch` (`id`, `name`, `description`, `pid`, `create_time`, `update_time`) VALUES
(1, '销售部', '销售部', 0, 1496217512, 1496217512),
(2, '财务部', '财务部', 0, 1496217778, 1496645846),
(3, '行政部', '行政部', 0, 1496217791, 1496217791),
(8, '测试部', '测试部', 0, 1496645255, 1496645255),
(9, '工程部', '工程部', 0, 1496645287, 1496905661),
(10, '物流部', '物流部', 0, 1496645641, 1496645641);

-- --------------------------------------------------------

--
-- 表的结构 `gms_staff`
--

DROP TABLE IF EXISTS `gms_staff`;
CREATE TABLE `gms_staff` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gms_branch`
--
ALTER TABLE `gms_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_staff`
--
ALTER TABLE `gms_staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gms_branch`
--
ALTER TABLE `gms_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `gms_staff`
--
ALTER TABLE `gms_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;--
-- Database: `gms_system`
--
CREATE DATABASE IF NOT EXISTS `gms_system` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gms_system`;

-- --------------------------------------------------------

--
-- 表的结构 `gms_admin_menu`
--

DROP TABLE IF EXISTS `gms_admin_menu`;
CREATE TABLE `gms_admin_menu` (
  `id` int(11) unsigned NOT NULL COMMENT '菜单表',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `mca` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `ico` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `order_number` int(11) unsigned DEFAULT NULL COMMENT '排序',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_admin_menu`
--

INSERT INTO `gms_admin_menu` (`id`, `pid`, `name`, `mca`, `ico`, `order_number`, `create_time`, `update_time`) VALUES
(1, 0, '数据分析', '', 'dashboard', 1, 1493798412, 1494312135),
(2, 0, '我的应用', '', '', 2, 1493798429, 1494312135),
(3, 0, '系统设置', '', '', 3, 1493798451, 1494312135),
(4, 0, '功能模块', '', '', 4, 1493798465, 1494312135),
(30, 29, ' 运行信息', 'system/info', 'fa fa-info-circle', 1, 1494068574, 1494312135),
(6, 3, '权限控制', '', 'fa fa-bookmark', 1, 1493798568, 1494312135),
(31, 29, '系统日志', 'system/log/index', 'fa fa-sticky-note-o', 2, 1494068590, 1494312135),
(10, 6, '权限管理', 'account/auth/index', 'icon-layers', 1, 1493798671, 1494312135),
(11, 6, '用户组管理', 'account/role/index', 'icon-users', 2, 1493798716, 1494312135),
(12, 6, '管理员列表', 'account/user/index', 'icon-user', 3, 1493798744, 1494312135),
(13, 7, '运行信息', 'system/info', '', NULL, 1493799049, 1494301060),
(15, 1, '仪表板', '', 'fa fa-dashboard', 1, 1493800667, 1494312135),
(16, 15, '数据汇总', '', 'fa fa-area-chart', 1, 1493800694, 1494312135),
(17, 15, '智能分析', '', 'fa fa-bolt', 2, 1493800713, 1494312135),
(18, 15, '数据导出', '', 'fa fa-random', 3, 1493800726, 1494312135),
(19, 2, '我的通知', '', 'fa fa-bell', 1, 1493800745, 1494312135),
(20, 2, '我的信息', '', 'icon-envelope', 2, 1493800756, 1494312135),
(33, 29, '基本设置', 'system/settings/index', 'icon-settings', 4, 1494068694, 1494312135),
(22, 19, '通知列表', 'account/profile/index', 'fa fa-bullhorn', 1, 1493800797, 1494312135),
(32, 29, '后台菜单', 'system/adminmenu/index', 'fa fa-navicon', 3, 1494068673, 1494312135),
(29, 3, '系统信息', 'system/info/index', 'fa fa-info', 2, 1494068540, 1494312135),
(34, 20, '信息列表', 'account/inbox/index', 'fa fa-inbox', 1, 1494077856, 1494312135),
(35, 2, '我的任务', '', 'icon-clock', 3, 1494077865, 1494312135),
(36, 35, '任务列表', 'account/todo/index', 'icon-check', 1, 1494077875, 1494312135);

-- --------------------------------------------------------

--
-- 表的结构 `gms_audit_log`
--

DROP TABLE IF EXISTS `gms_audit_log`;
CREATE TABLE `gms_audit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module` varchar(40) NOT NULL,
  `controller` varchar(40) NOT NULL,
  `action` varchar(40) NOT NULL,
  `value` longtext,
  `log_time` int(10) NOT NULL,
  `ip` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gms_audit_log`
--

INSERT INTO `gms_audit_log` (`id`, `user_id`, `module`, `controller`, `action`, `value`, `log_time`, `ip`) VALUES
(1, NULL, 'account', 'Role', 'read', '{"id":"1"}', 1494399744, '0.0.0.0'),
(2, NULL, 'account', 'Role', 'read', '{"id":"1"}', 1494399835, '0.0.0.0'),
(3, NULL, 'account', 'Role', 'read', '{"id":"1"}', 1494401201, '0.0.0.0'),
(4, NULL, 'account', 'Auth', 'index', NULL, 1494401366, '0.0.0.0'),
(5, NULL, 'account', 'Auth', 'index', NULL, 1494401405, '0.0.0.0'),
(6, NULL, 'account', 'Role', 'index', NULL, 1494401412, '0.0.0.0'),
(7, NULL, 'account', 'User', 'index', NULL, 1494401413, '0.0.0.0'),
(8, NULL, 'account', 'Auth', 'index', NULL, 1494401554, '0.0.0.0'),
(9, NULL, 'system', 'Log', 'index', NULL, 1494401557, '0.0.0.0'),
(10, NULL, 'system', 'Adminmenu', 'index', NULL, 1494401561, '0.0.0.0'),
(11, NULL, 'system', 'Settings', 'index', NULL, 1494401568, '0.0.0.0'),
(12, NULL, 'system', 'Adminmenu', 'index', NULL, 1494401640, '0.0.0.0'),
(13, NULL, 'system', 'Log', 'index', NULL, 1494401642, '0.0.0.0'),
(14, NULL, 'system', 'Info', 'index', NULL, 1494401644, '0.0.0.0'),
(15, NULL, 'system', 'Log', 'index', NULL, 1494401647, '0.0.0.0');

-- --------------------------------------------------------

--
-- 表的结构 `gms_chat`
--

DROP TABLE IF EXISTS `gms_chat`;
CREATE TABLE `gms_chat` (
  `id` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gms_log`
--

DROP TABLE IF EXISTS `gms_log`;
CREATE TABLE `gms_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `gms_settings`
--

DROP TABLE IF EXISTS `gms_settings`;
CREATE TABLE `gms_settings` (
  `id` int(11) unsigned NOT NULL,
  `system_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `page_description` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `page_author` varchar(100) CHARACTER SET utf8 NOT NULL,
  `logo` varchar(1000) DEFAULT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `gms_settings`
--

INSERT INTO `gms_settings` (`id`, `system_name`, `page_description`, `page_author`, `logo`, `create_time`, `update_time`) VALUES
(1, '通用管理系统GMS', '企业管理系统,数据分析，用户应用，系统设置，功能模块', '超级管理员', '20170512/62a33125d0a25f686d7ae98c3b179dd7.jpg', 0, 1494556525);

-- --------------------------------------------------------

--
-- 表的结构 `gms_upload`
--

DROP TABLE IF EXISTS `gms_upload`;
CREATE TABLE `gms_upload` (
  `id` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gms_admin_menu`
--
ALTER TABLE `gms_admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_audit_log`
--
ALTER TABLE `gms_audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gms_settings`
--
ALTER TABLE `gms_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gms_admin_menu`
--
ALTER TABLE `gms_admin_menu`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `gms_audit_log`
--
ALTER TABLE `gms_audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `gms_settings`
--
ALTER TABLE `gms_settings`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
