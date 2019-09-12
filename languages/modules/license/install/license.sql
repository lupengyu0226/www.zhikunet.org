DROP TABLE IF EXISTS `shuyang_license`;
CREATE TABLE IF NOT EXISTS `shuyang_license` (
  `aid` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `domain` char(80) NOT NULL,
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `webname` text NOT NULL,
  `shouquanstart` date NOT NULL DEFAULT '0000-00-00',
  `shouquanend` date NOT NULL DEFAULT '0000-00-00',
  `starttime` date NOT NULL DEFAULT '0000-00-00',
  `endtime` date NOT NULL DEFAULT '0000-00-00',
  `username` varchar(40) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `style` char(15) NOT NULL ,
  `show_template` char(30) NOT NULL,
  `icd` char(80) NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `siteid` (`typeid`,`siteid`,`passed`,`endtime`)
) TYPE=MyISAM ;
