<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('hook','','0');
class pinglun extends hook{
	Final static function admin_top_left_menu(){
		$sql = '';
		$siteid = get_siteid();

		$content_check_db = shy_base::load_model('comment_check_model');
		$num = $content_check_db->count($sql);
		$num = $num <= 100 ? $num : '100+';
		if($num > 0 ) {
			include template('plugin/pinglun','index');
		} else {
			return '';
		}
	}

}
?>
