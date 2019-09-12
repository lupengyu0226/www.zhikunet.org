DROP TABLE IF EXISTS `shuyang_xihuan`;
CREATE TABLE IF NOT EXISTS `shuyang_xihuan` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `catid` int(10) unsigned NOT NULL default '0' COMMENT '栏目id',
  `siteid` mediumint(6) unsigned NOT NULL default '0' COMMENT '站点ID',
  `contentid` int(10) unsigned NOT NULL default '0' COMMENT '文章id',
  `total` int(10) unsigned NOT NULL default '0' COMMENT '总数',
  `n1` int(10) unsigned NOT NULL default '0',
  `lastupdate` int(10) unsigned NOT NULL default '0' COMMENT '最后更新时间',
  PRIMARY KEY  (`id`),
  KEY `total` (`total`),
  KEY `lastupdate` (`lastupdate`),
  KEY `catid` (`catid`,`siteid`,`contentid`)
) TYPE=MyISAM;
