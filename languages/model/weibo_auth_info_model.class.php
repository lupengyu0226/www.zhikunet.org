<?php
defined('IN_SHUYANG') or exit('The resource access forbidden.');
shy_base::load_sys_class('model', '', 0);
class weibo_auth_info_model extends model {
	function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'weibo_auth_info';
		parent::__construct();
	}
}
?>