<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('model', '', 0);
class search_keyword_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'search_keyword';
		parent::__construct();
	}
}
?>
