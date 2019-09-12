<?php 
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	function __construct() {		
		$this->db = shy_base::load_model('shuyangtoday_model');
	}
	
	public function init() {
		$re = array();
		$page = max(intval($_GET['page']), 1);
		$data = $this->db->listinfo(array(), '`id` DESC', $page,2);
		include template('shuyangtoday','index',$default_style);
		
	}
}
?>
