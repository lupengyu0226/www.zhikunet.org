DROP TABLE IF EXISTS `shuyang_cron`;
CREATE TABLE IF NOT EXISTS `shuyang_cron` (
  `cronid` smallint(5) unsigned NOT NULL auto_increment,
  `cronon` smallint(5) unsigned NOT NULL default '0',
  `cronwitch` smallint(5) unsigned NOT NULL default '0',
  `cronname` varchar(20) NOT NULL default '',
  `start_time` int(10) NOT NULL,
  `end_time` int(10) NOT NULL,
  `mode` smallint(5) NOT NULL,
  `crontype` varchar(30) NOT NULL default '',
  `crontime` smallint(5) unsigned NOT NULL default '60',
  `parm` varchar(100) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `cronflag` int(10) unsigned NOT NULL default '0',
  `info` varchar(50) NOT NULL default '',
  `excutetime` int(10) NOT NULL,
  PRIMARY KEY  (`cronid`)
) ENGINE=MyISAM;
