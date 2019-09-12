<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('hook','','0');
class baoliao extends hook{
	Final static function admin_top_left_menu(){
		$sql = '';
		$siteid = get_siteid();

		$content_check_db = shy_base::load_model('baoliao_model');
		$num = $content_check_db->count($sql);
		$num = $num <= 1000 ? $num : '1000+';
		if($num > 0 ) {
			include template('plugin/baoliao','index');
		} else {
			return '';
		}
	}

}
?>
