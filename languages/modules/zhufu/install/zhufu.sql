DROP TABLE IF EXISTS `shuyang_zhufu`;
CREATE TABLE IF NOT EXISTS `shuyang_zhufu` (
  `edi_id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `edi_class` int(10) NOT NULL,
  `edi_images` int(15) NOT NULL,
  `edi_head` varchar(16) NOT NULL,
  `edi_sign` varchar(16) NOT NULL,
  `edi_lr` mediumtext NOT NULL,
  `edi_date` varchar(30) NOT NULL,
  `edi_cs` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`edi_id`),
  KEY `edi_id` (`edi_class`,`edi_images`,`edi_date`)
) TYPE=MyISAM ;