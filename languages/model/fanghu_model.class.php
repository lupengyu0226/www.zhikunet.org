<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('model', '', 0);
class fanghu_model extends model {
	
	public $table_name;
	public function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'fanghu';
		$this->table_name = 'fanghu';
		parent::__construct();
	}
}
?>
