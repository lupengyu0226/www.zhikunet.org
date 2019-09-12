DROP TABLE IF EXISTS `shuyang_fanghu`;
CREATE TABLE IF NOT EXISTS `shuyang_fanghu` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) DEFAULT NULL,
  `wangzhi` mediumtext,
  `ttime` varchar(50) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `rkey` varchar(255) DEFAULT NULL,
  `rdata` mediumtext,
  `user_agent` varchar(255) DEFAULT NULL,
  `request_url` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;