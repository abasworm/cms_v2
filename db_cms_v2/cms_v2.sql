/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50173
Source Host           : localhost:3306
Source Database       : cms_v2

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2018-09-14 21:39:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for test_enc
-- ----------------------------
DROP TABLE IF EXISTS `test_enc`;
CREATE TABLE `test_enc` (
  `password` varbinary(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_enc
-- ----------------------------
INSERT INTO `test_enc` VALUES (0x5ABBF7CCD9007DE5DC8CAA8C0C4D0BF9, '7');
INSERT INTO `test_enc` VALUES (0x1FB56183EC18CAB8F66B3308309E83DB, '8');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varbinary(255) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `active_date` datetime DEFAULT NULL,
  `non_active_date` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `last_sign_out_date` datetime DEFAULT NULL,
  `last_ip_address` varchar(100) DEFAULT NULL,
  `count_failed_login` int(11) DEFAULT '0',
  `last_time_action` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'abas', 0x1FB56183EC18CAB8F66B3308309E83DB, 'Aris Baskoro', 'worm.abas2@gmail.com', '+6285880851851', '1', '2018-09-10 23:30:26', '2018-09-10 23:33:27', null, null, null, null, '0', null);
