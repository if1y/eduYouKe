/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : fastedu

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-26 18:19:16
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of edu_admin_menu
-- ----------------------------
INSERT INTO `edu_admin_menu` VALUES ('1', '0', '0', '0', '1', '20', 'admin/menu/default', '权限管理', 'cogs', '模块管理', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('2', '1', '1', '0', '1', '21', 'admin/menu/menulist', '模块列表', 'cog', '模块列表', '0', '0');
INSERT INTO `edu_admin_menu` VALUES ('3', '1', '1', '0', '1', '0', 'admin/adminuser/adminuserlist', '管理员列表', 'user-plus', '11', '1581490040', '0');
INSERT INTO `edu_admin_menu` VALUES ('4', '1', '1', '1', '1', '0', '123123', '模块管理12111', 'user-cog', '角色列表', '1581491348', '0');
INSERT INTO `edu_admin_menu` VALUES ('5', '1', '1', '0', '1', '0', 'admin/adminrole/adminrolelist', '角色组', 'users', '', '1581493975', '0');
INSERT INTO `edu_admin_menu` VALUES ('6', '0', '0', '0', '1', '0', 'admin/setting/default', '网站管理', 'laptop', '', '1581834849', '0');
INSERT INTO `edu_admin_menu` VALUES ('7', '6', '1', '0', '1', '0', 'admin/setting/website', '基础配置', 'cog', '', '1581834952', '0');
INSERT INTO `edu_admin_menu` VALUES ('8', '6', '1', '0', '1', '0', 'admin/setting/banner', 'Banner管理', 'picture-o', '轮播图/友情链接', '1581999892', '0');
INSERT INTO `edu_admin_menu` VALUES ('9', '6', '1', '0', '0', '0', 'admin/file/filelist', '附件管理', 'file', '', '1582515985', '0');
INSERT INTO `edu_admin_menu` VALUES ('10', '0', '0', '0', '1', '0', 'admin/course/default', '课程管理', 'graduation-cap', '', '1582517857', '0');
INSERT INTO `edu_admin_menu` VALUES ('11', '10', '1', '0', '1', '0', 'admin/course/courselist', '课程列表', 'television', '', '1582518197', '0');
INSERT INTO `edu_admin_menu` VALUES ('12', '10', '1', '0', '1', '0', 'admin/course/category', '课程分类', 'sliders', '', '1582518489', '0');
INSERT INTO `edu_admin_menu` VALUES ('13', '10', '1', '0', '1', '0', 'admin/coursevideo/coursevideolist', '视频添加', 'file-video-o', '', '1582518574', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色组';

-- ----------------------------
-- Records of edu_admin_role
-- ----------------------------
INSERT INTO `edu_admin_role` VALUES ('1', '超级管理员', '1,2,3,5,6,7', '拥有后台所有权限', '1', '0', '1581830431', '0');
INSERT INTO `edu_admin_role` VALUES ('2', '测试', '', '', '1', '1', '1582529680', '0');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='轮播图/友情链接表';

-- ----------------------------
-- Records of edu_banner
-- ----------------------------

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
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='课程章节表';

-- ----------------------------
-- Records of edu_chapter
-- ----------------------------
INSERT INTO `edu_chapter` VALUES ('1', '1', '第一章1', '第一章的简介1', '备注1', '1', '0', '1582705623', '0');
INSERT INTO `edu_chapter` VALUES ('2', '1', '第二张', '第二张也是', '123123 ', '1', '1', '1582706899', '0');

-- ----------------------------
-- Table structure for edu_course
-- ----------------------------
DROP TABLE IF EXISTS `edu_course`;
CREATE TABLE `edu_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '课程名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '课程简介',
  `cource_image_url` varchar(64) NOT NULL DEFAULT '' COMMENT '课程封面图片',
  `sell_price` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '售卖价格',
  `content` text COMMENT '课程简介内容',
  `cource_tag` varchar(64) NOT NULL DEFAULT '' COMMENT '课程tag',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `sell_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '收费状态;0:免费,1:收费',
  `level_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '难度级别;1:初级,2:中级,3:高级,4:炼狱',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='课程列表';

-- ----------------------------
-- Records of edu_course
-- ----------------------------
INSERT INTO `edu_course` VALUES ('1', '69', '课程名称1', '课程简介1', '', '1100', '&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;测试文本123213213123&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;img src=&quot;/storage/topic/20200225\\46563ca972e6e684157bd270f2f11272.png&quot; style=&quot;max-width: 100%;&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '测试,标签,1', '备注', '1', '1', '1', '0', '1582617516', '0');
INSERT INTO `edu_course` VALUES ('2', '0', '课程名称122', '课程简介1222', '', '100', '&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;测试文本 123123123123&amp;nbsp; &amp;nbsp;&lt;img src=&quot;/storage/topic/20200225\\cf0caf3dc2233c23c70584580cd3489c.jpg&quot; style=&quot;max-width: 100%;&quot;&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '测试,标签', '备注', '0', '1', '1', '0', '1582619043', '0');
INSERT INTO `edu_course` VALUES ('5', '69', '测试课程1', '测试简介1', '', '0', '&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;欢迎使用 &lt;b&gt;wangEditor&lt;/b&gt; 富文本编辑器&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 'faltui,这是一个标签', '', '0', '1', '1', '0', '1582619759', '0');
INSERT INTO `edu_course` VALUES ('6', '69', '测试课程', '测试简介', 'topic/20200225\\0f01f8ca4c5271a461bc9ee5a5da7707.jpg', '0', '&lt;p&gt;欢迎使用 &lt;b&gt;wangEditor&lt;/b&gt; 富文本编辑器&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 'faltui,这是一个标签', '', '0', '1', '1', '0', '1582619795', '0');
INSERT INTO `edu_course` VALUES ('7', '69', '23123123123', '', '', '0', '&lt;p&gt;欢迎使用 &lt;b&gt;wangEditor&lt;/b&gt; 富文本编辑器&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 'faltui,这是一个标签', '', '0', '1', '1', '1', '1582620210', '0');

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
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COMMENT='课程分类';

-- ----------------------------
-- Records of edu_course_category
-- ----------------------------
INSERT INTO `edu_course_category` VALUES ('69', '0', '测试分类', '测试SEO标题', '测试SEO关键字', '测试SEO描述', '0', '测试备注', '1', '0', '1582524281', '0');

-- ----------------------------
-- Table structure for edu_course_video
-- ----------------------------
DROP TABLE IF EXISTS `edu_course_video`;
CREATE TABLE `edu_course_video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的章节id',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '视频名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '视频简介',
  `seoTitle` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `seoKeywords` varchar(255) DEFAULT NULL COMMENT 'SEO关键字',
  `seoDescription` varchar(255) DEFAULT NULL COMMENT 'SEO描述',
  `vide_url` varchar(255) NOT NULL DEFAULT '' COMMENT '视频地址',
  `image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `video_type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '视频类型;1:阿里云,2:其他',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='课程视频表';

-- ----------------------------
-- Records of edu_course_video
-- ----------------------------

-- ----------------------------
-- Table structure for edu_setting
-- ----------------------------
DROP TABLE IF EXISTS `edu_setting`;
CREATE TABLE `edu_setting` (
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
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

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
INSERT INTO `edu_setting` VALUES ('45', '播放器Key', 'aliConfig', 'aliPlayerKey', '播放器Key', null, null, '播放器Key', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('46', '播放器Secret', 'aliConfig', 'aliPlayerSecret', '1111', null, null, '播放器Secret', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('47', 'ossKey', 'aliConfig', 'aliossKey', '0000', null, null, 'ossKey', '1', '0', '0', '0');
INSERT INTO `edu_setting` VALUES ('48', 'ossSecret', 'aliConfig', 'aliossSecret', '213213213', null, null, 'ossSecret', '1', '0', '0', '0');
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
INSERT INTO `edu_setting` VALUES ('68', '网站logo', 'baseConfig', 'logoImage', 'topic/20200222\\eca55246b07fb6bd39d0edc6811e2380.png', null, null, '网站logo', '1', '0', '0', '0');











alter table ad_browse_log add ostype tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT 'Android;1:Ios,2:Win'
alter table ad_browse_log add distinguishability varchar(255) DEFAULT NULL COMMENT '分辨率'
alter table ad_browse_log add area varchar(255) DEFAULT NULL COMMENT '地区'
alter table ad_browse_log add battery varchar(255) DEFAULT NULL COMMENT '电量'
alter table ad_browse_log add effectivity tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0:无效;1:有效'
alter table ad_browse_log add test varchar(255) DEFAULT NULL COMMENT 'test'



CREATE TABLE `edu_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `source_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论内容 id',
  `table_name` varchar(255) DEFAULT NULL COMMENT '数据库名称',
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `dislike_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '不喜欢数',
  `floor` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '楼层数',
  `show_status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常',
  `delete_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '删除状态;1:已删除,0:未删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `url` text COMMENT '原文地址',
  `content` text CHARACTER SET utf8mb4 COMMENT '评论内容',
  `more` text CHARACTER SET utf8mb4 COMMENT '扩展属性',
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`) USING BTREE,
  KEY `show_status` (`show_status`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';
