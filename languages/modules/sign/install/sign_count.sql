DROP TABLE IF EXISTS `shuyang_sign_count`;
CREATE TABLE `shuyang_sign_count` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(6) unsigned NOT NULL,
  `count` smallint(6) unsigned NOT NULL,
  `getpoint` smallint(6) unsigned NOT NULL,
  `continuous` smallint(4) unsigned NOT NULL,
  `lasttime` int(10) unsigned NOT NULL,
  `siteid` smallint(6) unsigned NOT NULL,
  `weekcount` smallint(6) unsigned NOT NULL,
  `monthcount` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;