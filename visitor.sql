/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : visitor

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-03-21 17:40:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for share
-- ----------------------------
DROP TABLE IF EXISTS `share`;
CREATE TABLE `share` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `text` longtext,
  `img` varchar(200) DEFAULT NULL,
  `addtime` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of share
-- ----------------------------
INSERT INTO `share` VALUES ('1', '3', '玩儿玩儿', 'MA%253D%253D%7CQzoveGFtcHAvaHRkb2NzL3Zpc2l0b3IvaW1nX3VwZC8zMzMzLmpwZw%253D%253D', '1490060294');
INSERT INTO `share` VALUES ('2', '3', '速度发斯蒂芬', 'MA%253D%253D%7CQzoveGFtcHAvaHRkb2NzL3Zpc2l0b3IvaW1nX3VwZC8zMzMzLmpwZw%253D%253D', '1490060294');
INSERT INTO `share` VALUES ('3', '3', '速度发斯蒂芬', 'MA%253D%253D%7CQzoveGFtcHAvaHRkb2NzL3Zpc2l0b3IvaW1nX3VwZC8zMzMzLmpwZw%253D%253D', '1490060361');
INSERT INTO `share` VALUES ('4', '3', '是的发送到', 'MA%253D%253D%7CQzoveGFtcHAvaHRkb2NzL3Zpc2l0b3IvaW1nX3VwZC8zMzMzLmpwZw%253D%253D%7C%7CMQ%253D%253D%7CQzoveGFtcHAvaHRkb2NzL3Zpc2l0b3IvaW1nX3VwZC8yMjIyMi5qcGc%253D%7C%7CMg%253D%253D%7CXl5e', '1490062906');
INSERT INTO `share` VALUES ('7', '3', 'asdfasdf', 'MA%253D%253D%7CQzoveGFtcHAvaHRkb2NzL3Zpc2l0b3IvaW1nX3VwZC8zMzMzLmpwZw%253D%253D', '1490075005');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `password` varchar(32) DEFAULT NULL COMMENT '用户密码',
  `encrypt` varchar(6) DEFAULT NULL COMMENT '加密',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '哈哈', 'c7e90caa734e8509efa992df7ecc7729', 'JLlFXj');
INSERT INTO `user` VALUES ('3', '2222', 'a6832ee98a32127ff8e07725c72c3c82', 'CR6OPl');
INSERT INTO `user` VALUES ('4', '3333', 'a7e96f850e4dcef2b1863e555576aa21', 'vXebc0');
