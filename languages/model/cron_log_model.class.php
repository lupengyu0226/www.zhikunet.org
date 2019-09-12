<?php
defined('IN_SHUYANG') or exit('No permission resources.');

shy_base::load_sys_class('model', '', 0);
class cron_log_model extends model {
	public function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'fanghu';
		$this->table_name = 'cron_log';
		parent::__construct();
	}

}
?>
