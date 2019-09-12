DROP TABLE IF EXISTS `shuyang_mobile`;
CREATE TABLE IF NOT EXISTS `shuyang_mobile` (
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `sitename` char(30) NOT NULL,
  `logo` char(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `setting` mediumtext,
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`siteid`)
) TYPE=MyISAM;

INSERT INTO `shuyang_mobile` (`siteid`, `sitename`, `logo`, `domain`, `setting`, `status`) VALUES(1, '手机门户', '/statics/images/wap/wlogo.gif', '', 'array ()', 0);
ALTER TABLE `shuyang_category` ADD `mobilesetting` LONGTEXT CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL ;