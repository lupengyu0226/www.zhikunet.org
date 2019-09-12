DROP TABLE IF EXISTS `shuyang_c_stats`;
CREATE TABLE IF NOT EXISTS `shuyang_c_stats` (
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `hits` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '点击次数',
  `adddate` date NOT NULL COMMENT '日期',
  KEY `adddate` (`adddate`,`catid`)
) ENGINE=MyISAM;
