-- ----------------------------
-- 2014.07.24Table structure for `shuyang_weixin_menuevent`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_menuevent`;
CREATE TABLE `shuyang_weixin_menuevent` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(3) NOT NULL,
  `replyid` smallint(4) NOT NULL,
  `path` varchar(50) NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Title` char(80) NOT NULL,
  `menu` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `key` varchar(50) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `PicUrl` char(100) NOT NULL,
  `Url` char(200) NOT NULL,
  `Description` char(255) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `style` char(15) NOT NULL,
  `show_template` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`,`passed`)
) TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_keyword`;
CREATE TABLE `shuyang_weixin_keyword` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `keyword` char(80) NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `description` char(255) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `style` char(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`,`passed`)
) TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_replykeyword`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_replykeyword`;
CREATE TABLE `shuyang_weixin_replykeyword` (
 `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL,
  `keyword` char(80) NOT NULL,
  `content` text NOT NULL,
  `catid` int(6) NOT NULL,
  `type` int(2) NOT NULL,
  `num` tinyint(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `description` char(255) NOT NULL,
  `picurl` varchar(150) NOT NULL,
  `url` varchar(150) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `style` char(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`,`passed`)
) TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_menu`;
CREATE TABLE `shuyang_weixin_menu` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `Title` char(80) NOT NULL,
  `menu` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `key` varchar(50) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `Url` char(200) NOT NULL,
  `Description` char(255) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `style` char(15) NOT NULL,
  `show_template` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`,`passed`)
) TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_article`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_article`;
CREATE TABLE `shuyang_weixin_article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `replyid` int(5) NOT NULL,
  `typeid` smallint(5) unsigned NOT NULL,
  `default` tinyint(1) NOT NULL,
  `title` char(80) NOT NULL DEFAULT '',
  `siteid` smallint(5) NOT NULL,
  `style` char(24) NOT NULL DEFAULT '',
  `thumb` char(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `posids` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `keyword2` varchar(255) NOT NULL DEFAULT '',
  `wxurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `catid` (`id`)
) TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_member`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_member`;
CREATE TABLE `shuyang_weixin_member` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `subscribe` varchar(50) NOT NULL,
  `openid` char(100) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL,
  `sex` tinyint(2) NOT NULL,
  `language` char(20) NOT NULL,
  `nickname` char(20) NOT NULL,
  `city` char(30) NOT NULL DEFAULT '0',
  `province` varchar(30) NOT NULL DEFAULT '0',
  `country` char(30) NOT NULL DEFAULT '',
  `headimgurl` char(150) NOT NULL DEFAULT '',
  `subscribe_time` int(10) unsigned NOT NULL DEFAULT '0',
  `remark` char(150) NOT NULL DEFAULT '',
  `unionid` char(50) NOT NULL DEFAULT '',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`openid`),
  KEY `email` (`remark`(20)),
  KEY `phpssouid` (`subscribe`)
)TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_sent_group_news`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_sent_group_news`;
CREATE TABLE `shuyang_weixin_sent_group_news` (
   `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `catid` smallint(5) NOT NULL,
  `aid` int(6) NOT NULL,
  `digest` varchar(150) NOT NULL,
  `havedsent` tinyint(1) NOT NULL,
  `isselect` tinyint(1) NOT NULL,
  `url` varchar(100) NOT NULL,
  `siteid` smallint(5) NOT NULL,
  `updatetime` int(10) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `content_source_url` varchar(200) NOT NULL,
  `thumb_media_id` varchar(200) NOT NULL,
  `author` varchar(50) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `content` text NOT NULL,
  `show_cover_pic` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
)TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_member_group`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_member_group`;
CREATE TABLE `shuyang_weixin_member_group` (
  `groupid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(3) DEFAULT NULL,
  `name` char(50) NOT NULL,
  `updatetime` int(10) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `count` int(8) unsigned NOT NULL,
  `siteid` smallint(4) NOT NULL,
  PRIMARY KEY (`groupid`)
) TYPE=MyISAM;
-- ----------------------------
-- Table structure for `shuyang_weixin_focusreply`
-- ----------------------------
DROP TABLE IF EXISTS `shuyang_weixin_focusreply`;
CREATE TABLE `shuyang_weixin_focusreply` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `replyid` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
)TYPE=MyISAM;
-- ----------------------------
-- Records of shuyang_weixin_focusreply
-- ----------------------------
alter table shuyang_member add openid varchar(150) not null;
alter table shuyang_member add membertype tinyint(2) not null;
INSERT INTO `shuyang_weixin_focusreply` VALUES ('1', '欢迎关注互动沭阳', '0');

