DROP TABLE IF EXISTS `shuyang_sign`;
CREATE TABLE `shuyang_sign` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(6) unsigned NOT NULL,
  `signtime` int(10) NOT NULL,
  `signip` varchar(20) NOT NULL,
  `signpoint` smallint(5) unsigned NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `continuous` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;