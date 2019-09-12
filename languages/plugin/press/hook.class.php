<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('hook','','0');
class press extends hook{
	Final static function admin_top_left_menu(){
		$sql = 'passed=0';
		$siteid = get_siteid();
		$content_check_db = shy_base::load_model('press_model');
		$num = $content_check_db->count($sql);
		$num = $num <= 1000 ? $num : '1000+';
		if($num > 0 ) {
			include template('plugin/press','index');
		} else {
			return '';
		}
	}
}
?>
