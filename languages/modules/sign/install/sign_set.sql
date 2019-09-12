DROP TABLE IF EXISTS `shuyang_sign_set`;
CREATE TABLE `shuyang_sign_set` (
  `siteid` smallint(6) unsigned NOT NULL,
  `starttime` varchar(20) NOT NULL,
  `endtime` varchar(20) NOT NULL,
  `setpoint` smallint(6) unsigned NOT NULL,
  `limit` smallint(6) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`siteid`)
) TYPE=MyISAM;