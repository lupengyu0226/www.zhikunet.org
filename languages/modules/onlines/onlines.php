<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);

class onlines extends admin {

	private $db; public $username;
	public function __construct() {
		parent::__construct();
		$this->username = param::get_cookie('admin_username');
		$this->db = shy_base::load_model('onlines_model');
	}
	
	public function init() {
		//在线用户列表
		if($_GET['m']=='member'){
			$where = array('m'=>'member');
		}elseif($_GET['m']=='waplogin'){
			$where = array('m'=>'waplogin');
		}else{
			//$where = "m <> 'cron'";
			$where = "`m` != 'admin' AND `m` != 'cron'";
		}
		$page = max(intval($_GET['page']), 1);
		$data = $this->db->listinfo($where, '`lastvisit` DESC', $page);
		$big_menu = array('javascript:;', L('onlines_list'));
		$ip_area = shy_base::load_sys_class('ip_area');
		include $this->admin_tpl('onlines_list');
	}
	/**
	 * 批量踢掉在线用户
	 */
	public function delete($sessionid = 0) {
		if((!isset($_POST['sessionid']) || empty($_POST['sessionid'])) && !$sessionid) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['sessionid']) && !$sessionid) {
				array_map(array($this, 'delete'), $_POST['sessionid']);
				showmessage(L('onlines_deleted'), HTTP_REFERER);
			} elseif($sessionid) {
				$aid = intval($aid);
				$this->db->delete(array('sessionid' => $sessionid));
			}
		}
	}
}
?>
