DROP TABLE IF EXISTS `shuyang_manage_stats_add`;
CREATE TABLE IF NOT EXISTS `shuyang_manage_stats_add` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `catid` mediumint(8) NOT NULL DEFAULT '0',
  `hitsid` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `inputtime` int(11) DEFAULT '0',
  `username` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
