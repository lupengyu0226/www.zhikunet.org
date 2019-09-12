DROP TABLE IF EXISTS `shuyang_cron_log`;
CREATE TABLE IF NOT EXISTS `shuyang_cron_log` (
  `logid` smallint(5) unsigned NOT NULL auto_increment,
  `logcronid` int(10) unsigned NOT NULL default '0',
  `loginfo` varchar(10) NOT NULL default '',
  `logtime` int(10) unsigned NOT NULL default '0',
  `logsize` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`logid`)
) TYPE=MyISAM;
