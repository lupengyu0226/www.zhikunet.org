<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);

class fanghu extends admin {

	private $db; public $username;
	public function __construct() {
		parent::__construct();
		//if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
		$this->username = param::get_cookie('admin_username');
		$this->db = shy_base::load_model('fanghu_model');
	}
	
	public function init() {
		//攻击日志列表
		$sql = '';
		$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;
		$page = max(intval($_GET['page']), 1);
		$ip_area = shy_base::load_sys_class('ip_area');
		$data = $this->db->listinfo($sql, '`id` DESC', $page);
		$big_menu = array('javascript:;', L('fanghu_list'));
		include $this->admin_tpl('fanghu_list');
	}
	public function call() {
		//攻击日志详细日志
		$_GET['id'] = intval($_GET['id']);
		$where = array('id' => $_GET['id']);
		$ip_area = shy_base::load_sys_class('ip_area');
		$an_info = $this->db->get_one($where);
		$big_menu = array('javascript:;', L('fanghu_call'));
		include $this->admin_tpl('fanghu_call');
	}
	
	/**
	 * 批量删除攻击日志
	 */
	public function delete($id = 0) {
		if((!isset($_POST['id']) || empty($_POST['id'])) && !$id) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['id']) && !$id) {
				array_map(array($this, 'delete'), $_POST['id']);
				showmessage(L('fanghu_deleted'), HTTP_REFERER);
			} elseif($id) {
				$aid = intval($aid);
				$this->db->delete(array('id' => $id));
			}
		}
	}
}
?>
