<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);

class admin_zhufu extends admin {

	private $db; public $username;
	public function __construct() {
		parent::__construct();
		//if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
		$this->username = param::get_cookie('admin_username');
		$this->db = shy_base::load_model('zhufu_model');
	}
	
	public function init() {
		//公告列表
		$sql = '';
		$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;

		$page = max(intval($_GET['page']), 1);
		$data = $this->db->listinfo($sql, '`edi_id` DESC', $page);
		$big_menu = array('javascript:;', L('zhufu_list'));
		include $this->admin_tpl('zhufu_list');
	}
	
	/**
	 * 添加公告
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['zhufu'] = $this->check($_POST['zhufu']);
			if($this->db->insert($_POST['zhufu'])) showmessage(L('zhufument_successful_added'), HTTP_REFERER, '', 'add');
		} else {
			//获取站点模板信息
			shy_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$template_list = template_list($siteid, 0);
			$site = shy_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$show_header = $show_validator = $show_scroll = 1;
			shy_base::load_sys_class('form', '', 0);
			include $this->admin_tpl('zhufu_add');
		}
	}
	
	/**
	 * 修改公告
	 */
	public function edit() {
		$_GET['edi_id'] = intval($_GET['edi_id']);
		if(!$_GET['edi_id']) showmessage(L('illegal_operation'));
		if(isset($_POST['dosubmit'])) {
			$_POST['zhufu'] = $this->check($_POST['zhufu'], 'edit');
			if($this->db->update($_POST['zhufu'], array('edi_id' => $_GET['edi_id']))) showmessage(L('zhufud_a'), HTTP_REFERER, '', 'edit');
		} else {
			$where = array('edi_id' => $_GET['edi_id']);
			$an_info = $this->db->get_one($where);
			shy_base::load_sys_class('form', '', 0);
			//获取站点模板信息
			shy_base::load_app_func('global', 'admin');
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$show_header = $show_validator = $show_scroll = 1;
			include $this->admin_tpl('zhufu_edit');
		}
	}
	
	/**
	 * ajax检测公告标题是否重复
	 */
	public function public_check_title() {
		if (!$_GET['edi_lr']) exit(0);
		if (CHARSET=='gbk') {
			$_GET['edi_lr'] = iconv('UTF-8', 'GBK', $_GET['edi_lr']);
		}
		$title = $_GET['edi_lr'];
		if ($_GET['edi_id']) {
			$r = $this->db->get_one(array('edi_id' => $_GET['edi_id']));
			if ($r['edi_lr'] == $edi_lr) {
				exit('1');
			}
		} 
		$r = $this->db->get_one(array('siteid' => $this->get_siteid(), 'edi_lr' => $edi_lr), 'edi_id');
		if($r['edi_id']) {
			exit('0');
		} else {
			exit('1');
		}
	}
	/**
	 * 批量删除公告
	 */
	public function delete($edi_id = 0) {
		if((!isset($_POST['edi_id']) || empty($_POST['edi_id'])) && !$edi_id) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['edi_id']) && !$edi_id) {
				array_map(array($this, 'delete'), $_POST['edi_id']);
				showmessage(L('zhufu_deleted'), HTTP_REFERER);
			} elseif($edi_id) {
				$aid = intval($aid);
				$this->db->delete(array('edi_id' => $edi_id));
			}
		}
	}
}
?>
