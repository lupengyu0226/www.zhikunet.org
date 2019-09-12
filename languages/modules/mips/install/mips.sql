DROP TABLE IF EXISTS `shuyang_mips`;
CREATE TABLE IF NOT EXISTS `shuyang_mips` (
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `sitename` char(30) NOT NULL,
  `logo` char(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `setting` mediumtext,
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`siteid`)
) TYPE=MyISAM;

INSERT INTO `shuyang_mips` (`siteid`, `sitename`, `logo`, `domain`, `setting`, `status`) VALUES(1, '沭阳MIP', '/statics/images/mobile/logo.gif', '', '{"wxname":"\\u4e92\\u52a8\\u6cad\\u9633","wxappid":"wx48a33f79c889d820","wxappsecret":"1e46b044d671f1f65c280732ed6b45af"}', 0);
ALTER TABLE `shuyang_category` ADD `mipssetting` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
update `shuyang_category` set mipssetting = 'array (\n ''template_list'' => ''default'',\n ''index_template'' => ''index'',\n  ''category_template'' => ''category'',\n  ''list_template'' => ''list'',\n  ''show_template'' => ''show'',\n  ''content_ishtml'' => ''0'',\n  ''category_ruleid'' => ''47'',\n  ''show_ruleid'' => ''44'',\n)';