/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : fastedu

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-16 20:44:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for edu_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `edu_admin_menu`;
CREATE TABLE `edu_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '菜单类型;1:有界面可访问菜单,2:无界面可访问菜单,0:只作为菜单',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态;1:显示,0:不显示',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `url` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '应用路径:app/controller/action',
  `title` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单图标',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `show_status` (`show_status`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of edu_admin_menu
-- ----------------------------
INSERT INTO `edu_admin_menu` VALUES ('1', '0', '0', '0', '1', '20', 'admin/menu/default', '权限管理', 'cogs', '模块管理', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('2', '1', '1', '0', '1', '21', 'admin/menu/menulist', '模块列表', 'cog', '模块列表', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('3', '1', '1', '0', '1', '0', 'admin/adminuser/adminuserlist', '管理员列表', 'users-cog', '11', '1581490040', '0');
INSERT INTO `edu_admin_menu` VALUES ('4', '1', '1', '1', '1', '0', '123123', '模块管理12111', 'user-cog', '角色列表', '1581491348', '0');
INSERT INTO `edu_admin_menu` VALUES ('5', '1', '1', '0', '1', '0', 'admin/adminrole/adminrolelist', '角色组', 'user-cog', '', '1581493975', '0');
INSERT INTO `edu_admin_menu` VALUES ('6', '0', '0', '0', '1', '0', 'admin/setting/default', '网站管理', 'laptop', '', '1581834849', '0');
INSERT INTO `edu_admin_menu` VALUES ('7', '6', '1', '0', '1', '0', 'admin/setting/website', '基础配置', 'cog', '', '1581834952', '0');

-- ----------------------------
-- Table structure for edu_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `edu_admin_role`;
CREATE TABLE `edu_admin_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `role_auth` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限字符串',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色组';

-- ----------------------------
-- Records of edu_admin_role
-- ----------------------------
INSERT INTO `edu_admin_role` VALUES ('1', '超级管理员', '1,2,3,5,6,7', '拥有后台所有权限', '1', '0', '1581830431', '0');

-- ----------------------------
-- Table structure for edu_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `edu_admin_user`;
CREATE TABLE `edu_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联角色id',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '中国手机不带国家代码，国际手机号格式为：国家代码-手机号',
  `avatar_url` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `nickname` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='管理员用户表';

-- ----------------------------
-- Records of edu_admin_user
-- ----------------------------
INSERT INTO `edu_admin_user` VALUES ('1', '1', '13274025222', 'topic/20200216\\8faeb459eb13ee09bb23f7abdd9b9cce.jpg', 'admin', 'd93a5def7511da3d0f2d171d9c344e91', '1', '0', '', '0', '1581576514', '0');

-- ----------------------------
-- Table structure for edu_setting
-- ----------------------------
DROP TABLE IF EXISTS `edu_setting`;
CREATE TABLE `edu_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `category` varchar(20) NOT NULL DEFAULT '' COMMENT '分类',
  `category_name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类别名',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

-- ----------------------------
-- Records of edu_setting
-- ----------------------------
INSERT INTO `edu_setting` VALUES ('31', '基础配置', 'base', 'baseConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('32', '阿里云配置', 'base', 'aliConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('33', '支付配置', 'base', 'payConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('34', '登录配置', 'base', 'loginConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('35', '图片配置', 'base', 'imageConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('36', '邮件配置', 'base', 'emailConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('37', '公众号配置', 'base', 'mpConfig', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('38', '其他配置', 'base', 'otherConfig', 'nav导航', '1', '0', '0', '0');
