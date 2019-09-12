<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied'); 
$tanmu_table_db = shy_base::load_model('tanmu_table_model');
$tablelist = $tanmu_table_db->select('', 'tableid');
	foreach($tablelist as $k=>$v) {
		$tanmu_table_db->query("DROP TABLE IF EXISTS `".$tanmu_table_db->db_tablepre."tanmu_data_".$v['tableid']."`;");
	}
return array('tanmu', 'tanmu_check', 'tanmu_setting', 'tanmu_table');
?>
