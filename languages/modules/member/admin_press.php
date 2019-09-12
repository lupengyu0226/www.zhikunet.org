<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class admin_press extends admin {
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('press_model');
	}
	public function init() {
		$where = array('siteid'=>$this->get_siteid());
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'id DESC',$page, $pages = '9');
		$pages = $this->db->pages;
		$big_menu = array('javascript:;', L('处理列表'));
		include $this->admin_tpl('press_list');
	}

	function public_status() {
		 $passed = intval($_GET['passed']) && intval($_GET['passed'])== 1 ? '1' : '0';
		 $id = intval($_GET['id']) ? intval($_GET['id']) : showmessage(L('内容不存在'),HTTP_REFERER);
		 $this->db->update(array('passed'=>$passed), array('id'=>$id));
		 showmessage(L('处理成功'),HTTP_REFERER);
	}
	public function view() {
			$_GET['id'] = intval($_GET['id']);
			$where = array('id' => $_GET['id']);
			$infos = $this->db->get_one($where);
 			include $this->admin_tpl('press_view');
	}
	
	/**
	 * 删除片  
	 * @param	intval	$id
	 */
	public function delete($id = 0) {
		if((!isset($_POST['id']) || empty($_POST['id'])) && !$id) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['id']) && !$id) {
				array_map(array($this, 'delete'), $_POST['id']);
				showmessage(L('删除成功'), HTTP_REFERER);
			} elseif($id) {
				$aid = intval($aid);
				$this->db->delete(array('id' => $id));
			}
		}
	}
	 
 
	
}
?>