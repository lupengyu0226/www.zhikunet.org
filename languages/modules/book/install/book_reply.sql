DROP TABLE IF EXISTS `shuyang_book_reply`;
CREATE TABLE IF NOT EXISTS `shuyang_book_reply` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `gid` mediumint(6) unsigned NOT NULL,
  `reply` mediumtext,
  `role` tinyint(1) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
