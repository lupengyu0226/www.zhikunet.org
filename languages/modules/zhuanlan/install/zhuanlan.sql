DROP TABLE IF EXISTS `shuyang_zhuanlan`;
/*------- CREATE SQL---------*/
CREATE TABLE `shuyang_zhuanlan` (
  `id` int(10) NOT NULL auto_increment COMMENT 'ID',
  `username` char(32) COMMENT '用户名',
  `name` char(32) COMMENT '专栏名称',
  `domain` char(60) COMMENT '自定义域名',
  `thumb` varchar(100) COMMENT '作家头像',
  `authors` mediumtext COMMENT '专栏作家介绍',
  `status` tinyint(1) COMMENT '专栏状态',
  `total` int(10) unsigned default '0' COMMENT '用户名',
  `creat_at` int(10) default '0' COMMENT '创建时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;