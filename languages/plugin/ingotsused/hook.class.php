<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('hook','','0');
class ingotsused extends hook{
	Final static function member_glogal_header(){
			include template('plugin/ingotsused','index');
	}
	Final static function index_glogal_ssi(){
			include template('plugin/ingotsused','index');
	}
}
?>