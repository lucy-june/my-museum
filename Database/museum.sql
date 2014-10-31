/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50168
Source Host           : localhost:3306
Source Database       : museum

Target Server Type    : MYSQL
Target Server Version : 50168
File Encoding         : 65001

Date: 2014-10-19 22:28:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_collection`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_collection`;
CREATE TABLE `tbl_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `exhibitpath` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_collection
-- ----------------------------
INSERT INTO `tbl_collection` VALUES ('1', '2', '展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/清代木雕/');
INSERT INTO `tbl_collection` VALUES ('2', '2', '展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/');

-- ----------------------------
-- Table structure for `tbl_region`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_region`;
CREATE TABLE `tbl_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qrcode` varchar(128) NOT NULL,
  `exhibitpath` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_region
-- ----------------------------
INSERT INTO `tbl_region` VALUES ('1', '20141019234124', '展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/');
INSERT INTO `tbl_region` VALUES ('2', '20141019234124', '展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/清代木雕/');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL COMMENT '用户名',
  `nickname` char(16) DEFAULT NULL,
  `password` char(32) NOT NULL COMMENT 'md5 hash后密码',
  `sex` tinyint(2) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `reg_time` int(10) NOT NULL DEFAULT '0',
  `reg_ip` char(16) DEFAULT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `last_login_ip` char(16) DEFAULT NULL,
  `login` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '0-管理员 1-普通用户',
  `tel` char(11) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '0', '', '0', '0', '0', '1413714775', '0.0.0.0', '7', '1', '0', '15216713389');
INSERT INTO `tbl_user` VALUES ('2', 'user', 'user', 'e10adc3949ba59abbe56e057f20f883e', '1', 'test@qq.com', '0', '0', null, '1413722627', '0.0.0.0', '174', '1', '1', '15216712286');
INSERT INTO `tbl_user` VALUES ('3', 'test', null, 'c81e728d9d4c2f636f067f89cc14862c', null, null, '0', '0', null, null, null, '0', '1', '1', '13839333898');
INSERT INTO `tbl_user` VALUES ('5', 'test2', null, 'c81e728d9d4c2f636f067f89cc14862c', null, null, '0', '0', null, null, null, '0', '1', '1', '13839333898');
INSERT INTO `tbl_user` VALUES ('6', 'test3', null, 'c81e728d9d4c2f636f067f89cc14862c', null, null, '0', '0', null, null, null, '0', '1', '1', '13839333898');
INSERT INTO `tbl_user` VALUES ('7', 'test4', null, 'c81e728d9d4c2f636f067f89cc14862c', null, null, '0', '0', null, null, null, '0', '0', '1', '13839333898');
INSERT INTO `tbl_user` VALUES ('8', 'test5', null, 'c81e728d9d4c2f636f067f89cc14862c', null, null, '0', '0', null, null, null, '0', '0', '1', '13839333898');
INSERT INTO `tbl_user` VALUES ('9', 'test6', null, 'c81e728d9d4c2f636f067f89cc14862c', null, null, '0', '0', null, null, null, '0', '1', '1', '13839333898');
