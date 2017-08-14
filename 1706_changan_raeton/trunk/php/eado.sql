/*
Navicat MySQL Data Transfer

Source Server         : 112.74.218.203
Source Server Version : 50544
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2017-03-27 00:27:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for eado_17_addup
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_addup`;
CREATE TABLE `eado_17_addup` (
  `id` int(255) NOT NULL,
  `addup` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of eado_17_addup
-- ----------------------------
INSERT INTO `eado_17_addup` VALUES ('1', '0');

-- ----------------------------
-- Table structure for eado_17_customer
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_customer`;
CREATE TABLE `eado_17_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `intime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid_hash` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=latin1 COMMENT='用户';

-- ----------------------------
-- Records of eado_17_customer
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_customer_msg
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_customer_msg`;
CREATE TABLE `eado_17_customer_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `richtext` text,
  `ctime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of eado_17_customer_msg
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_customer_prize
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_customer_prize`;
CREATE TABLE `eado_17_customer_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid_hash` char(255) NOT NULL,
  `prize` int(10) unsigned NOT NULL DEFAULT '0',
  `creat_time` int(11) NOT NULL DEFAULT '0',
  `creat_date` date NOT NULL DEFAULT '0000-00-00',
  `tel` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `openid_hash` (`openid_hash`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户获奖表';

-- ----------------------------
-- Records of eado_17_customer_prize
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_customer_remainder
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_customer_remainder`;
CREATE TABLE `eado_17_customer_remainder` (
  `openid_hash` char(255) NOT NULL,
  `remainder` int(11) NOT NULL DEFAULT '1' COMMENT ' 剩余抽奖数',
  `dateflag` date NOT NULL DEFAULT '0000-00-00',
  `is_uploadwork` tinyint(1) NOT NULL DEFAULT '0' COMMENT '今天是否上传了作品',
  `is_shear` tinyint(1) NOT NULL DEFAULT '0',
  `is_vote` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`openid_hash`),
  UNIQUE KEY `openid_hash` (`openid_hash`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='每日抽奖次数';

-- ----------------------------
-- Records of eado_17_customer_remainder
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_prize
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_prize`;
CREATE TABLE `eado_17_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '奖品标识',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `probability` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '抽中的概率',
  `category` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总量',
  `remainder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '剩余',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='奖品列表';

-- ----------------------------
-- Records of eado_17_prize
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_testdrive
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_testdrive`;
CREATE TABLE `eado_17_testdrive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `sex` varchar(255) DEFAULT '男',
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `dealer` varchar(255) DEFAULT NULL,
  `cartype` varchar(50) DEFAULT NULL,
  `create_date` int(10) unsigned DEFAULT NULL,
  `drive_date` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `from_usergent` varchar(100) DEFAULT NULL COMMENT '终端设备',
  `create_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  KEY `raffle_code` (`drive_date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COMMENT='预约试驾';

-- ----------------------------
-- Records of eado_17_testdrive
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_total
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_total`;
CREATE TABLE `eado_17_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateflag` date NOT NULL DEFAULT '0000-00-00',
  `type` int(10) unsigned DEFAULT '1' COMMENT '类型',
  PRIMARY KEY (`id`),
  KEY `dateflag` (`dateflag`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分项统计';

-- ----------------------------
-- Records of eado_17_total
-- ----------------------------

-- ----------------------------
-- Table structure for eado_17_user
-- ----------------------------
DROP TABLE IF EXISTS `eado_17_user`;
CREATE TABLE `eado_17_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户';

-- ----------------------------
-- Records of eado_17_user
-- ----------------------------
INSERT INTO `eado_17_user` VALUES ('1', 'admin', '82cc921c6a5c6707e1d6e6862ba3201a');
