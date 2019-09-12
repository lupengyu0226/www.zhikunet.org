<?php
defined('IN_SHUYANG') or exit('The resource access forbidden.');
shy_base::load_sys_class('model','', 0);

class weapp_model extends model {
	public function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';//数据库连接池
		$this->table_name = 'weapp';//数据表名称
		
		parent::__construct();
	}
	
}
?>