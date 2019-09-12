CREATE TABLE IF NOT EXISTS `shuyang_user_search_word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_word` varchar(50) NOT NULL COMMENT '搜索词',
  `search_times` int(11) NOT NULL DEFAULT '1' COMMENT '搜索次数',
  `search_from` varchar(10) NOT NULL COMMENT '搜索来源',
  `last_search_time` int(11) NOT NULL COMMENT '最后一次搜索时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='记录用户搜索关键词表' AUTO_INCREMENT=1 ;