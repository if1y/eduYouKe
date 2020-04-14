/*
Navicat MySQL Data Transfer

Source Server         : edu
Source Server Version : 50644
Source Host           : 58.87.68.152:3306
Source Database       : edu

Target Server Type    : MYSQL
Target Server Version : 50644
File Encoding         : 65001

Date: 2020-04-14 22:18:23
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
  KEY `show_status` (`show_status`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of edu_admin_menu
-- ----------------------------
INSERT INTO `edu_admin_menu` VALUES ('1', '0', '1', '0', '1', '20', 'admin/menu/default', '权限管理', 'cogs', '模块管理', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('2', '1', '2', '0', '1', '21', 'admin/menu/index', '模块列表', 'cog', '模块列表', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('3', '1', '2', '0', '1', '0', 'admin/administrator/index', '管理员列表', 'user-plus', '11', '1581490040', '0');
INSERT INTO `edu_admin_menu` VALUES ('4', '1', '2', '1', '1', '0', '123123', '模块管理12111', 'user-cog', '角色列表', '1581491348', '0');
INSERT INTO `edu_admin_menu` VALUES ('5', '1', '2', '0', '1', '0', 'admin/role/index', '角色组', 'users', '', '1581493975', '0');
INSERT INTO `edu_admin_menu` VALUES ('6', '0', '1', '0', '1', '0', 'admin/setting/default', '网站管理', 'laptop', '', '1581834849', '0');
INSERT INTO `edu_admin_menu` VALUES ('7', '6', '2', '0', '1', '0', 'admin/setting/website', '基础配置', 'cog', '', '1581834952', '0');
INSERT INTO `edu_admin_menu` VALUES ('8', '6', '2', '0', '1', '0', 'admin/banner/index', 'Banner管理', 'picture-o', '轮播图/友情链接', '1581999892', '0');
INSERT INTO `edu_admin_menu` VALUES ('9', '6', '2', '0', '0', '0', 'admin/file/filelist', '附件管理', 'file', '', '1582515985', '0');
INSERT INTO `edu_admin_menu` VALUES ('10', '0', '1', '0', '1', '0', 'admin/course/default', '课程管理', 'graduation-cap', '', '1582517857', '0');
INSERT INTO `edu_admin_menu` VALUES ('11', '10', '2', '0', '1', '0', 'admin/course/index', '课程列表', 'television', '', '1582518197', '0');
INSERT INTO `edu_admin_menu` VALUES ('12', '10', '2', '0', '1', '3', 'admin/CourseCategory/index', '课程分类', 'sliders', '', '1582518489', '0');
INSERT INTO `edu_admin_menu` VALUES ('13', '10', '2', '0', '1', '2', 'admin/CourseVideo/index', '视频添加', 'file-video-o', '', '1582518574', '0');
INSERT INTO `edu_admin_menu` VALUES ('14', '2', '3', '0', '1', '0', 'admin/menu/add', 'add', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('15', '2', '3', '0', '1', '0', 'admin/menu/del', 'del', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('16', '2', '3', '0', '1', '0', 'admin/menu/edit', 'edit', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('17', '2', '3', '0', '1', '0', 'admin/menu/info', 'info', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('18', '11', '3', '0', '1', '0', 'admin/course/add', 'add', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('19', '11', '3', '0', '1', '0', 'admin/course/del', 'del', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('20', '11', '3', '0', '1', '0', 'admin/course/edit', 'edit', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('21', '11', '3', '0', '1', '0', 'admin/course/info', 'info', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('22', '10', '2', '0', '1', '1', 'admin/chapter/index', '章节管理', 'file-text', '', '1585128259', '0');
INSERT INTO `edu_admin_menu` VALUES ('23', '22', '3', '0', '1', '0', 'admin/chapter/add', 'add', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('24', '22', '3', '0', '1', '0', 'admin/chapter/del', 'del', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('25', '22', '3', '0', '1', '0', 'admin/chapter/edit', 'edit', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('26', '22', '3', '0', '1', '0', 'admin/chapter/info', 'info', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('27', '12', '3', '0', '1', '0', 'admin/CourseCategory/add', 'add', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('28', '12', '3', '0', '1', '0', 'admin/CourseCategory/del', 'del', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('29', '12', '3', '0', '1', '0', 'admin/CourseCategory/edit', 'edit', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('30', '12', '3', '0', '1', '0', 'admin/CourseCategory/info', 'info', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('31', '13', '3', '0', '1', '0', 'admin/CourseVideo/add', 'add', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('32', '13', '3', '0', '1', '0', 'admin/CourseVideo/del', 'del', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('33', '13', '3', '0', '1', '0', 'admin/CourseVideo/edit', 'edit', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('34', '13', '3', '0', '1', '0', 'admin/CourseVideo/info', 'info', 'circle', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('35', '6', '2', '0', '0', '0', 'admin/nav/index', '导航管理', 'medium', '', '1586419329', '0');
INSERT INTO `edu_admin_menu` VALUES ('36', '35', '3', '0', '1', '0', 'admin/nav/add', 'add', 'medium', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('37', '35', '3', '0', '1', '0', 'admin/nav/del', 'del', 'medium', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('38', '35', '3', '0', '1', '0', 'admin/nav/edit', 'edit', 'medium', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('39', '35', '3', '0', '1', '0', 'admin/nav/info', 'info', 'medium', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('40', '6', '2', '1', '1', '0', 'admin/banner/index', 'Banner管理', 'circle', '', '1586427699', '0');
INSERT INTO `edu_admin_menu` VALUES ('41', '40', '3', '0', '1', '0', 'admin/banner/add', 'add', 'picture-o', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('42', '40', '3', '0', '1', '0', 'admin/banner/del', 'del', 'picture-o', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('43', '40', '3', '0', '1', '0', 'admin/banner/edit', 'edit', 'picture-o', '', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('44', '40', '3', '0', '1', '0', 'admin/banner/info', 'info', 'picture-o', '', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色组';

-- ----------------------------
-- Records of edu_admin_role
-- ----------------------------
INSERT INTO `edu_admin_role` VALUES ('1', '超级管理员', '1,2,3,5,6,7', '拥有后台所有权限', '1', '0', '1581830431', '0');
INSERT INTO `edu_admin_role` VALUES ('2', '测试', '', '', '1', '1', '1582529680', '0');
INSERT INTO `edu_admin_role` VALUES ('3', '测试', '', '备注', '0', '0', '1585117022', '0');

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
  KEY `nickname` (`nickname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='管理员用户表';

-- ----------------------------
-- Records of edu_admin_user
-- ----------------------------
INSERT INTO `edu_admin_user` VALUES ('1', '1', '13274025222', 'topic/20200216\\8faeb459eb13ee09bb23f7abdd9b9cce.jpg', 'admin', 'd93a5def7511da3d0f2d171d9c344e91', '1', '0', '', '0', '1581576514', '0');
INSERT INTO `edu_admin_user` VALUES ('4', '1', '13274025222', '', 'admin6661', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1', '', '0', '1585052568', '0');
INSERT INTO `edu_admin_user` VALUES ('5', '1', '13274025222', '', 'admin6661', '97fcd64f8a09a99f898773541e548bbb', '1', '1', '', '0', '1585055180', '0');

-- ----------------------------
-- Table structure for edu_banner
-- ----------------------------
DROP TABLE IF EXISTS `edu_banner`;
CREATE TABLE `edu_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(64) NOT NULL DEFAULT '' COMMENT '描述',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接地址',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片地址',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;1:轮播图,1:友情链接',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='轮播图/友情链接表';

-- ----------------------------
-- Records of edu_banner
-- ----------------------------
INSERT INTO `edu_banner` VALUES ('1', '模块管理11', '123213', 'https://www.baidu.com/', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/95a936762332bbda55548b594eac7918.png', '', '1', '1', '0', '1586429024', '0');
INSERT INTO `edu_banner` VALUES ('2', '第二个', '第二个', 'https://www.qq.com/', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/a93492c8adb418907cf4762acee3ab21.png', '', '1', '1', '0', '1586429208', '0');

-- ----------------------------
-- Table structure for edu_chapter
-- ----------------------------
DROP TABLE IF EXISTS `edu_chapter`;
CREATE TABLE `edu_chapter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的课程id',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '章节名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '章节简介',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='课程章节表';

-- ----------------------------
-- Records of edu_chapter
-- ----------------------------
INSERT INTO `edu_chapter` VALUES ('1', '9', '第一章', '光速入门', '', '1', '0', '1586582485', '0');
INSERT INTO `edu_chapter` VALUES ('2', '9', '第二章', '常用函数解析', '', '1', '0', '1586582522', '0');
INSERT INTO `edu_chapter` VALUES ('3', '9', '第三章', 'PHP进阶之路', '', '1', '0', '1586582701', '0');

-- ----------------------------
-- Table structure for edu_comment
-- ----------------------------
DROP TABLE IF EXISTS `edu_comment`;
CREATE TABLE `edu_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `source_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论内容 id',
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `dislike_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '不喜欢数',
  `floor` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '楼层数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `show_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:已审核,0:未审核',
  `delete_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态,1:已审核,0:未审核',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '评论内容所在表，不带表前缀',
  `full_name` varchar(50) NOT NULL DEFAULT '' COMMENT '评论者昵称',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  `url` text COMMENT '原文地址',
  `content` text CHARACTER SET utf8mb4 COMMENT '评论内容',
  `more` text CHARACTER SET utf8mb4 COMMENT '扩展属性',
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of edu_comment
-- ----------------------------
INSERT INTO `edu_comment` VALUES ('1', '0', '6', '0', '9', '0', '0', '0', '1586770141', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=9', '123123213213123', null);
INSERT INTO `edu_comment` VALUES ('2', '0', '6', '0', '9', '0', '0', '0', '1586771088', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=9', '试一下', null);
INSERT INTO `edu_comment` VALUES ('3', '0', '6', '0', '9', '0', '0', '0', '1586771578', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=9', '测试一下', null);
INSERT INTO `edu_comment` VALUES ('4', '0', '6', '0', '9', '0', '0', '0', '1586771853', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=9', '说下问题', null);
INSERT INTO `edu_comment` VALUES ('5', '0', '1', '0', '10', '0', '0', '0', '1586836961', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=10', '试一下', null);
INSERT INTO `edu_comment` VALUES ('6', '0', '1', '0', '9', '0', '0', '0', '1586838932', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=9', '什么？', null);
INSERT INTO `edu_comment` VALUES ('7', '0', '1', '0', '10', '0', '0', '0', '1586839328', '1', '1', 'course', '', '', 'http://edu.com/course/comment.html?id=10', '测试一下 ', null);

-- ----------------------------
-- Table structure for edu_config
-- ----------------------------
DROP TABLE IF EXISTS `edu_config`;
CREATE TABLE `edu_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `category` varchar(20) NOT NULL DEFAULT '' COMMENT '分类',
  `category_name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类别名',
  `content` varchar(255) DEFAULT NULL COMMENT '输入内容',
  `default_content` varchar(255) DEFAULT NULL COMMENT '默认展示内容',
  `small_help` varchar(255) DEFAULT NULL COMMENT '提示文字',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

-- ----------------------------
-- Records of edu_config
-- ----------------------------
INSERT INTO `edu_config` VALUES ('31', '基础配置', 'base', 'baseConfig', null, '', null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('32', '阿里云配置', 'base', 'aliConfig', null, '', '', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('33', '支付配置', 'base', 'payConfig', null, '', null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('34', '登录配置', 'base', 'loginConfig', null, '', null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('35', '图片配置', 'base', 'imageConfig', null, '', null, 'nav导航', '0', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('36', '邮件配置', 'base', 'emailConfig', null, '', null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('37', '公众号配置', 'base', 'mpConfig', null, null, null, 'nav导航', '0', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('38', '其他配置', 'base', 'otherConfig', null, null, null, 'nav导航', '0', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('39', '网站名称', 'baseConfig', 'webSiteName', 'FastEdu教育系统', null, null, '网站名称', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('40', 'SEO标题', 'baseConfig', 'seoTitle', 'FastEdu教育系统', null, null, 'SEO标题', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('41', 'SEO关键字', 'baseConfig', 'seoKeywords', 'FastEdu教育系统', null, null, 'SEO关键字', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('42', 'SEO描述', 'baseConfig', 'seoDescription', '123FastEdu教育系统', null, null, 'SEO描述', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('43', 'ICP备案', 'baseConfig', 'icpString', '123456', null, null, 'ICP备案', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('44', '统计代码', 'baseConfig', 'countCode', '', '', 'https://www.kancloud.cn/manual/think-template/1286419', '统计代码', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('45', '播放器Key', 'aliConfig', 'aliPlayerKey', '播放器Key', null, null, '播放器Key', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('46', '播放器Secret\r\n', 'aliConfig', 'aliPlayerSecret', '', null, null, '播放器Secret\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('47', 'ossKey', 'aliConfig', 'aliossKey', '', null, null, 'ossKey', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('48', 'ossSecret', 'aliConfig', 'aliossKey', '', null, null, 'ossSecret', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('49', '支付宝Key\r\n', 'payConfig', 'aliPayKey', '', null, null, '支付宝Key\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('50', '支付宝Secret\r\n', 'payConfig', 'aliPaySecret', '支付宝Secret', null, null, '支付宝Secret\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('51', '微信支付Key\r\n', 'payConfig', 'wxPayKey', '', null, null, '微信支付Key\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('52', '微信支付Secret', 'payConfig', 'wxPaySecret', '', null, null, '微信支付Secret', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('53', '个人支付Key\r\n', 'payConfig', 'otherPayKey', '', null, null, '个人支付Key\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('54', '个人支付Secret\r\n', 'payConfig', 'otherPaySecret', '', null, null, '个人支付Secret\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('55', '微信登录Key', 'loginConfig', 'wxLoginKey', '', null, null, '微信登录Key', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('56', '微信登录Secret', 'loginConfig', 'wxLoginSecret', '', null, null, '微信登录Secret', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('57', '微博登录Key', 'loginConfig', 'weiboLoginKey', '微博登录Key', null, null, '微博登录Key', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('58', '微博登录Secret', 'loginConfig', 'weiboLoginSecret', '', null, null, '微博登录Secret', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('59', '阿里短信Key', 'aliConfig', 'aliSmsKey', '', null, null, '阿里短信Key', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('60', '阿里短信Secret', 'aliConfig', 'aliSmsSecret', '', null, null, '阿里短信Secret', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('61', '发件人', 'emailConfig', 'sender', '', null, null, '发件人', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('62', '邮箱地址\r\n', 'emailConfig', 'emailAddress', '', null, null, '邮箱地址\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('63', 'SMTP服务器\r\n', 'emailConfig', 'emailServer', '', null, null, 'SMTP服务器\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('64', '连接方式\r\n', 'emailConfig', 'emailConnectionType', '', null, null, '连接方式\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('65', 'SMTP服务端口\r\n', 'emailConfig', 'smtpPort', 'SMTP服务端口', null, null, 'SMTP服务端口\r\n', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('66', '发件箱帐号', 'emailConfig', 'senderAddress', '', null, null, '发件箱帐号', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('67', '发件箱密码', 'emailConfig', 'senderPassword', '', null, null, '发件箱密码', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('68', '输入框', 'testConfig', 'testInput', '', 'string', null, '输入框', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('69', '输入框数字', 'testConfig', 'testNum', null, 'num', null, '输入框数字', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('70', '上传', 'testConfig', 'testFile', null, 'file', null, '文件上传', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('71', '上传2', 'testConfig', 'testFileone', null, 'file', null, '文件上传2', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('72', '文本框', 'testConfig', 'testTextarea', null, 'textarea', null, '文本框', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('73', 'redio单选框', 'testConfig', 'testRedio', null, 'select', null, 'redio单选框', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('74', '复选框', 'testConfig', 'testCheckbox', null, 'redio', null, '复选框', '1', '0', '0', '0');
INSERT INTO `edu_config` VALUES ('75', '测试配置', 'base', 'testConfig', null, '', null, 'testConfig', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for edu_course
-- ----------------------------
DROP TABLE IF EXISTS `edu_course`;
CREATE TABLE `edu_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '课程名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '课程简介',
  `cource_image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '课程封面图片',
  `sell_price` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '售卖价格',
  `content` text COMMENT '课程简介内容',
  `cource_tag` varchar(64) NOT NULL DEFAULT '' COMMENT '课程tag',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `sell_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '收费状态;0:免费,1:收费',
  `level_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '难度级别;1:初级,2:中级,3:高级,4:炼狱',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `views` int(10) unsigned DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COMMENT='课程列表';

-- ----------------------------
-- Records of edu_course
-- ----------------------------
INSERT INTO `edu_course` VALUES ('9', '80', 'php从入门到精通--就业班', 'php开发工程师是非常具有竞争性的岗位，就业前景广阔。php开发工程师主要从事Web/App后端开发工作。使用流行框架快速搭建企业项目架构，完成项目功能接口设计以及后台模块管理，并根据实际需求对项目进', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/ba09bf1f9f31dc996d19ba46c0cd6739.png', '0', '<p><img src=\"http://swechat-img.oss-cn-beijing.aliyuncs.com/7cbb8f411cdca1b6e213a763e997d76f.jpg\" style=\"max-width:100%;\"></p><p><br></p>', 'php,后端', '', '0', '1', '1', '0', '36', '1586488142', '0');
INSERT INTO `edu_course` VALUES ('10', '83', 'Swoole从入门到精通--就业班', 'Swoole: PHP的异步、并行、高性能网络通信引擎,支持TCP长连接,Websocket,Mqtt等协议。广泛用于手机app、手游服务端、网络游戏服务器、聊天室、硬件通讯、智能家居', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/c777582f326274bfdc337e4349f5e5c1.png', '100', '<p><img src=\"http://swechat-img.oss-cn-beijing.aliyuncs.com/7cbb8f411cdca1b6e213a763e997d76f.jpg\" style=\"max-width:100%;\"></p><p><br></p>', 'swoole,PHP,后端', '', '1', '1', '1', '0', '15', '1586488222', '0');
INSERT INTO `edu_course` VALUES ('11', '85', 'Jquery从入门到精通--就业班', 'jQuery是一个快速、简洁的JavaScript框架，是继Prototype之后又一个优秀的JavaScript代码库（或JavaScript框架）', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/1c97bfd4643ee3f1296bc729a220175b.png', '0', '<p><img src=\"http://swechat-img.oss-cn-beijing.aliyuncs.com/7cbb8f411cdca1b6e213a763e997d76f.jpg\" style=\"max-width:100%;\"></p>', 'Jquery, javascript,前端', '', '0', '1', '1', '0', '0', '1586488330', '0');
INSERT INTO `edu_course` VALUES ('12', '98', 'Mysql从入门到精通--就业班', 'MySQL 教程 MySQL 是最流行的关系型数据库管理系统,在 WEB 应用方面 MySQL 是最好的 RDBMS(Relational Database Management System:关系数据库管理系统)', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/5f658d870a46eea30d0379fa1218d31a.png', '0', '<p><img src=\"http://swechat-img.oss-cn-beijing.aliyuncs.com/7cbb8f411cdca1b6e213a763e997d76f.jpg\" style=\"max-width:100%;\"></p>', 'mysql,后端,数据库', '', '0', '1', '1', '0', '0', '1586488563', '0');

-- ----------------------------
-- Table structure for edu_course_category
-- ----------------------------
DROP TABLE IF EXISTS `edu_course_category`;
CREATE TABLE `edu_course_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `seoTitle` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `seoKeywords` varchar(255) DEFAULT NULL COMMENT 'SEO关键字',
  `seoDescription` varchar(255) DEFAULT NULL COMMENT 'SEO描述',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COMMENT='课程分类';

-- ----------------------------
-- Records of edu_course_category
-- ----------------------------
INSERT INTO `edu_course_category` VALUES ('76', '0', '编程开发', '', '', '', '0', '', '1', '0', '1586426486', '0');
INSERT INTO `edu_course_category` VALUES ('77', '76', '后端', '', '', '', '0', '', '1', '0', '1586426494', '0');
INSERT INTO `edu_course_category` VALUES ('78', '76', '前端', '', '', '', '0', '', '1', '0', '1586426502', '0');
INSERT INTO `edu_course_category` VALUES ('79', '76', '运维', '', '', '', '0', '', '1', '0', '1586426511', '0');
INSERT INTO `edu_course_category` VALUES ('80', '77', 'PHP', '', '', '', '0', '', '1', '0', '1586426520', '0');
INSERT INTO `edu_course_category` VALUES ('81', '77', 'Java', '', '', '', '0', '', '1', '0', '1586426530', '0');
INSERT INTO `edu_course_category` VALUES ('82', '77', 'Golang', '', '', '', '0', '', '1', '0', '1586426547', '0');
INSERT INTO `edu_course_category` VALUES ('83', '80', 'Swoole', '', '', '', '0', '', '1', '0', '1586426565', '0');
INSERT INTO `edu_course_category` VALUES ('84', '78', 'Vue', '', '', '', '0', '', '1', '0', '1586426576', '0');
INSERT INTO `edu_course_category` VALUES ('85', '78', 'Jquery', '', '', '', '0', '', '1', '0', '1586426587', '0');
INSERT INTO `edu_course_category` VALUES ('86', '0', '设计', '', '', '', '0', '', '1', '0', '1586426676', '0');
INSERT INTO `edu_course_category` VALUES ('87', '86', '平面设计', '', '', '', '0', '', '1', '0', '1586426687', '0');
INSERT INTO `edu_course_category` VALUES ('88', '86', '室内设计', '', '', '', '0', '', '1', '0', '1586426701', '0');
INSERT INTO `edu_course_category` VALUES ('89', '0', '职场-职业', '', '', '', '0', '', '1', '0', '1586426726', '0');
INSERT INTO `edu_course_category` VALUES ('90', '89', '办公软件', '', '', '', '0', '', '1', '0', '1586426737', '0');
INSERT INTO `edu_course_category` VALUES ('91', '89', '职业素养', '', '', '', '0', '', '1', '0', '1586426749', '0');
INSERT INTO `edu_course_category` VALUES ('92', '0', '视觉', '', '', '', '0', '', '1', '0', '1586426790', '0');
INSERT INTO `edu_course_category` VALUES ('93', '92', '摄影技巧', '', '', '', '0', '', '1', '0', '1586426803', '0');
INSERT INTO `edu_course_category` VALUES ('94', '92', '抖音拍摄', '', '', '', '0', '', '1', '0', '1586426825', '0');
INSERT INTO `edu_course_category` VALUES ('95', '0', '电商', '', '', '', '0', '', '1', '0', '1586426845', '0');
INSERT INTO `edu_course_category` VALUES ('96', '95', '淘宝运营', '', '', '', '0', '', '1', '0', '1586426866', '0');
INSERT INTO `edu_course_category` VALUES ('97', '95', '跨境电商', '', '', '', '0', '', '1', '0', '1586426883', '0');
INSERT INTO `edu_course_category` VALUES ('98', '77', 'Mysql', '', '', '', '0', '', '1', '0', '1586488388', '0');

-- ----------------------------
-- Table structure for edu_course_video
-- ----------------------------
DROP TABLE IF EXISTS `edu_course_video`;
CREATE TABLE `edu_course_video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的章节id',
  `course_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的课程id',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '视频名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '视频简介',
  `seoTitle` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `seoKeywords` varchar(255) DEFAULT NULL COMMENT 'SEO关键字',
  `seoDescription` varchar(255) DEFAULT NULL COMMENT 'SEO描述',
  `video_url` varchar(255) NOT NULL DEFAULT '' COMMENT '视频地址',
  `image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `remark` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `channel` varchar(64) NOT NULL DEFAULT '' COMMENT '视频类型;local:本地',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`chapter_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='课程视频表';

-- ----------------------------
-- Records of edu_course_video
-- ----------------------------
INSERT INTO `edu_course_video` VALUES ('2', '1', '9', '认识PHP', '交个朋友', '交个朋友', '交个朋友', '交个朋友', 'tovideo/20200411\\c6b68d77a860fbf3929d8a728d30dcb1.mp4', '', '', 'local', '1', '0', '1586591410', '0');
INSERT INTO `edu_course_video` VALUES ('3', '1', '9', '函数说明', '函数说明', '函数说明', '函数说明', '函数说明', '1c0450b7f58644f794a845724488885e', '', '', 'alivod', '1', '0', '1586591449', '0');

-- ----------------------------
-- Table structure for edu_record_log
-- ----------------------------
DROP TABLE IF EXISTS `edu_record_log`;
CREATE TABLE `edu_record_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `key` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `category` varchar(20) NOT NULL DEFAULT '' COMMENT '分类',
  `value` varchar(255) DEFAULT NULL COMMENT '输入内容',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `more` text,
  PRIMARY KEY (`id`),
  KEY `category` (`category`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COMMENT='系统Log流水表';

-- ----------------------------
-- Records of edu_record_log
-- ----------------------------
INSERT INTO `edu_record_log` VALUES ('124', '1', '9', 'courseView', null, '1586838919', '0', null);
INSERT INTO `edu_record_log` VALUES ('125', '1', '6', 'comment', 'course', '1586838932', '0', null);
INSERT INTO `edu_record_log` VALUES ('126', '1', '10', 'courseView', null, '1586839129', '0', null);
INSERT INTO `edu_record_log` VALUES ('128', '1', '7', 'comment', 'course', '1586839328', '0', null);
INSERT INTO `edu_record_log` VALUES ('156', '9', '0', 'loginExperience', '0', '1586847478', '0', null);
INSERT INTO `edu_record_log` VALUES ('157', '9', '10', 'courseView', null, '1586847621', '0', null);
INSERT INTO `edu_record_log` VALUES ('158', '9', '9', 'courseView', null, '1586847970', '0', null);
INSERT INTO `edu_record_log` VALUES ('159', '0', '13273025255', 'smsCode', '299182', '1586855827', '0', null);
INSERT INTO `edu_record_log` VALUES ('160', '6', '0', 'loginExperience', '0', '1586855844', '0', null);
INSERT INTO `edu_record_log` VALUES ('161', '6', '10', 'courseView', null, '1586855848', '0', null);
INSERT INTO `edu_record_log` VALUES ('162', '6', '9', 'courseView', null, '1586855871', '0', null);
INSERT INTO `edu_record_log` VALUES ('163', '0', '13273025255', 'smsCode', '486840', '1586858403', '0', null);

-- ----------------------------
-- Table structure for edu_setting
-- ----------------------------
DROP TABLE IF EXISTS `edu_setting`;
CREATE TABLE `edu_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '分类名称',
  `category` varchar(64) NOT NULL DEFAULT '' COMMENT '分类',
  `category_name` varchar(64) NOT NULL DEFAULT '' COMMENT '分类别名',
  `content` varchar(255) DEFAULT NULL COMMENT '输入内容',
  `default_content` varchar(255) DEFAULT NULL COMMENT '默认展示内容',
  `small_help` varchar(255) DEFAULT NULL COMMENT '提示文字',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category` (`category`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

-- ----------------------------
-- Records of edu_setting
-- ----------------------------
INSERT INTO `edu_setting` VALUES ('31', '基础配置', 'base', 'baseConfig', null, null, null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('32', '阿里云配置', 'base', 'aliConfig', null, null, '', 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('33', '支付配置', 'base', 'payConfig', null, null, null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('34', '登录配置', 'base', 'loginConfig', null, null, null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('35', '图片配置', 'base', 'imageConfig', null, null, null, 'nav导航', '0', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('36', '邮件配置', 'base', 'emailConfig', null, null, null, 'nav导航', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('37', '公众号配置', 'base', 'mpConfig', null, null, null, 'nav导航', '0', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('38', '其他配置', 'base', 'otherConfig', null, null, null, 'nav导航', '0', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('39', '网站名称', 'baseConfig', 'webSiteName', 'FastEdu教育系统', null, null, '网站名称', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('40', 'SEO标题', 'baseConfig', 'seoTitle', 'FastEdu教育系统', null, null, 'SEO标题', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('41', 'SEO关键字', 'baseConfig', 'seoKeywords', 'FastEdu教育系统', null, null, 'SEO关键字', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('42', 'SEO描述', 'baseConfig', 'seoDescription', '123FastEdu教育系统', null, null, 'SEO描述', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('43', 'ICP备案', 'baseConfig', 'icpString', '123456', null, null, 'ICP备案', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('44', '统计代码', 'baseConfig', 'countCode', '213213213213213', '', 'https://www.kancloud.cn/manual/think-template/1286419', '统计代码', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('45', '播放器Key', 'aliConfig', 'aliPlayerKey', 'LTAImHXukA9AUfAc', null, null, '播放器Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('46', '播放器Secret', 'aliConfig', 'aliPlayerSecret', 'aHdnjeI2OYhSVhLaeOrisq0GmibgMD', null, null, '播放器Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('47', 'ossKey', 'aliConfig', 'aliossKey', 'LTAIc9QzMqt4UneS', null, null, 'ossKey', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('48', 'ossSecret', 'aliConfig', 'aliossSecret', 'BTxcFrnQw0Q3phgH5lhHkdetEdXANy', null, null, 'ossSecret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('49', '支付宝Key', 'payConfig', 'aliPayKey', '', null, null, '支付宝Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('50', '支付宝Secret', 'payConfig', 'aliPaySecret', '支付宝Secret', null, null, '支付宝Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('51', '微信支付Key', 'payConfig', 'wxPayKey', '111', null, null, '微信支付Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('52', '微信支付Secret', 'payConfig', 'wxPaySecret', '', null, null, '微信支付Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('53', '个人支付Key', 'payConfig', 'otherPayKey', '', null, null, '个人支付Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('54', '个人支付Secret', 'payConfig', 'otherPaySecret', '', null, null, '个人支付Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('55', '微信登录Key', 'loginConfig', 'wxLoginKey', '', null, null, '微信登录Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('56', '微信登录Secret', 'loginConfig', 'wxLoginSecret', '', null, null, '微信登录Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('57', '微博登录Key', 'loginConfig', 'weiboLoginKey', '微博登录Key', null, null, '微博登录Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('58', '微博登录Secret', 'loginConfig', 'weiboLoginSecret', 'DFDD', null, null, '微博登录Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('59', '阿里短信Key', 'aliConfig', 'aliSmsKey', '', null, null, '阿里短信Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('60', '阿里短信Secret', 'aliConfig', 'aliSmsSecret', '', null, null, '阿里短信Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('61', '发件人', 'emailConfig', 'sender', '', null, null, '发件人', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('62', '邮箱地址', 'emailConfig', 'emailAddress', '2222', null, null, '邮箱地址', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('63', 'SMTP服务器', 'emailConfig', 'emailServer', '111', null, null, 'SMTP服务器', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('64', '连接方式', 'emailConfig', 'emailConnectionType', '', null, null, '连接方式', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('65', 'SMTP服务端口', 'emailConfig', 'smtpPort', 'SMTP服务端口', null, null, 'SMTP服务端口', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('66', '发件箱帐号', 'emailConfig', 'senderAddress', '', null, null, '发件箱帐号', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('67', '发件箱密码', 'emailConfig', 'senderPassword', '', null, null, '发件箱密码', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('68', '网站logo', 'baseConfig', 'logoImage', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/eca55246b07fb6bd39d0edc6811e2380.png', null, null, '网站logo', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('69', '上传配置', 'base', 'uploaderConfig', null, null, null, '上传配置', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('70', '图片配置', 'uploaderConfig', 'imageUploader', '1', null, null, '图片配置', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('71', '视频配置', 'uploaderConfig', 'videoUploader', '0', null, null, '视频配置', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('72', 'ossEndpoint', 'aliConfig', 'ossEndpoint', 'http://oss-cn-beijing.aliyuncs.com/', null, null, 'ossEndpoint', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('73', 'ossBucket', 'aliConfig', 'ossBucket', 'swechat-img', null, null, 'ossBucket', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('74', 'smsKey', 'aliConfig', 'smsKey', 'LTAIc9QzMqt4UneS', null, null, '阿里短信Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('75', 'smsSecret', 'aliConfig', 'smsSecret', 'BTxcFrnQw0Q3phgH5lhHkdetEdXANy', null, null, '阿里短信Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('76', 'smsSign', 'aliConfig', 'smsSign', 'eduyouke', null, null, '签名名称', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('77', 'smsLoginTemplateCode', 'aliConfig', 'smsLoginTemplateCode', 'SMS_168822352', null, null, '登录模板', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('78', 'smsForgetTemplateCode', 'aliConfig', 'smsForgetTemplateCode', 'SMS_187935125', null, null, '忘记密码', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for edu_user
-- ----------------------------
DROP TABLE IF EXISTS `edu_user`;
CREATE TABLE `edu_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '中国手机不带国家代码，国际手机号格式为：国家代码-手机号',
  `avatar_url` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `sex` tinyint(2) unsigned DEFAULT '0' COMMENT '0:保密1男:2女',
  `nickname` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码',
  `introduce` varchar(255) DEFAULT NULL COMMENT '简介',
  `empirical` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of edu_user
-- ----------------------------
INSERT INTO `edu_user` VALUES ('1', '13274025222', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/0f26b6c9d7482e5331f0cdd96207d111.jpeg', '1', '总有刁民想害朕', 'd93a5def7511da3d0f2d171d9c344e91', '这个人懒蛋蛋...哈哈哈', '2000', '1', '0', '127.0.0.1', '1586690741', '1586690741', '1586690741');
INSERT INTO `edu_user` VALUES ('6', '13273025255', 'http://swechat-img.oss-cn-beijing.aliyuncs.com/0f26b6c9d7482e5331f0cdd96207d111.jpeg', '0', '昵称_480252', '49273ffa8ee1c08c429a081d984eb7bb', '这个人懒蛋蛋......', '2000', '1', '0', '127.0.0.1', '1586680962', '1586680962', '1586680962');
INSERT INTO `edu_user` VALUES ('8', '13203213212', '', '2', '昵称_292464', '123123123', '哈哈哈哈', '0', '1', '0', '127.0.0.1', '1586691612', '1586691612', '1586691612');
INSERT INTO `edu_user` VALUES ('9', '18612885121', '', '0', '昵称_661815', 'a88369dc888fb4ff6e7225c0442a48f9', null, '1000', '1', '0', '127.0.0.1', '1586761328', '1586761328', '1586761328');
INSERT INTO `edu_user` VALUES ('13', '', '', '0', '123456', 'd93a5def7511da3d0f2d171d9c344e91', null, '0', '1', '0', '127.0.0.1', '1586779226', '1586779226', '1586779226');
INSERT INTO `edu_user` VALUES ('14', '', '', '0', '123', '6116afedcb0bc31083935c1c262ff4c9', null, '0', '1', '0', '127.0.0.1', '1586779437', '1586779437', '1586779437');
INSERT INTO `edu_user` VALUES ('15', '', '', '0', '123123', 'b3360cc45c2819fc1ea9b0f16c15fdee', null, '0', '1', '0', '127.0.0.1', '1586779662', '1586779662', '1586779662');
INSERT INTO `edu_user` VALUES ('16', '', '', '0', '12312312', 'bac5be9173484ac9062d8a75ceb7a6d1', null, '0', '1', '0', '127.0.0.1', '1586779673', '1586779673', '1586779673');
INSERT INTO `edu_user` VALUES ('17', '', '', '0', '123654', 'eb3028ad37e04b17e65b94111d3c437e', null, '0', '1', '0', '127.0.0.1', '1586779953', '1586779953', '1586779953');
INSERT INTO `edu_user` VALUES ('18', '', '', '0', 'admin666', 'eb3028ad37e04b17e65b94111d3c437e', null, '0', '1', '0', '127.0.0.1', '1586779971', '1586779971', '1586779971');
INSERT INTO `edu_user` VALUES ('19', '', '', '0', '13273025255', 'eb3028ad37e04b17e65b94111d3c437e', null, '0', '1', '0', '127.0.0.1', '1586834006', '1586834006', '1586834006');
INSERT INTO `edu_user` VALUES ('20', '13273025222', '', '0', '昵称_445495', '98846036e3a9ba9fdaaaa924d661515e', null, '0', '1', '0', '127.0.0.1', '1586845130', '1586845130', '1586845130');
