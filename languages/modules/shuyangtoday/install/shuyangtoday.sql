DROP TABLE IF EXISTS `shuyang_shuyangtoday`;
CREATE TABLE IF NOT EXISTS `shuyang_shuyangtoday` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `datas` mediumtext,
  `setting` mediumtext,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;