<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form','',0);
shy_base::load_app_func('global');
class mip extends admin {
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('mip_model');
		$this->siteid = $this->get_siteid();
		$this->category_db = shy_base::load_model('category_model');
	}
	
	public function init () {
		$ispc = $_GET['ispc'];
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$where = '';
		$start_time = $_GET['start_time'];
		$end_time = $_GET['end_time'];
		if($start_time && preg_match('/^20([0-9]{2}-[0-9]{2}-[0-9]{2})/',$start_time)) {
			$where = "addtime>='$start_time' AND ispc='$ispc'";
		}
		if($end_time && preg_match('/^20([0-9]{2}-[0-9]{2}-[0-9]{2})/',$end_time)) {
			if($where) {
				$where .= " AND addtime<='$end_time' AND ispc='$ispc'";
			} else {
				$where = "WHERE addtime<='$end_time' AND ispc='$ispc'";
			}
		}              
		$query = $this->db->listinfo($where, '`id` DESC',$page,20);
		$datas = $query;
		$pages = $this->db->edi_pages;
		include $this->admin_tpl('mip_list');
	}
}
