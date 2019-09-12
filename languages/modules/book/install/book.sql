DROP TABLE IF EXISTS `shuyang_book`;
CREATE TABLE IF NOT EXISTS `shuyang_book` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `realname` varchar(20) DEFAULT NULL,
  `userid` mediumint(6) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `content` mediumtext,
  `view_password` varchar(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `is_check` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
