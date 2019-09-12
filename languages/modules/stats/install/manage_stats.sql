DROP TABLE IF EXISTS `shuyang_manage_stats`;
CREATE TABLE IF NOT EXISTS `shuyang_manage_stats` (
  `sid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `add` mediumint(8) NOT NULL DEFAULT '0',
  `edit` mediumint(9) NOT NULL DEFAULT '0',
  `delete` mediumint(9) NOT NULL DEFAULT '0',
  `check` mediumint(9) NOT NULL DEFAULT '0',
  `position` mediumint(9) NOT NULL DEFAULT '0',
  `push` mediumint(9) NOT NULL DEFAULT '0',
  `listorder` mediumint(9) NOT NULL DEFAULT '0',
  `check_comment` mediumint(9) NOT NULL DEFAULT '0',
  `delete_comment` int(11) NOT NULL DEFAULT '0',
  `stat_time` int(10) NOT NULL DEFAULT '0' COMMENT '统计周期',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM COMMENT='稿件统计';
