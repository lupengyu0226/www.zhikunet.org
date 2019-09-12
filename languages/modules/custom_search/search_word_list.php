<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('form','',0);
shy_base::load_app_class('admin','admin',0);
class search_word_list extends admin {
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('user_search_word_model');
	}

	 /**
	 *	列表
	 */
	public function init(){
		$ip_area = shy_base::load_sys_class('ip_area');
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$data = $this->db->listinfo($where='',$order='id DESC',$page,$pagesize=15);
		$pages = $this->db->pages;
		$total = $this->db->count();
		include $this->admin_tpl('search_word_list');
	}

	public function search_word_list(){
		$ip_area = shy_base::load_sys_class('ip_area');
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$search_from = !empty($_GET['search_from']) ? $_GET['search_from'] : '';
		$start_time = !empty($_GET['start_time']) ? strtotime($_GET['start_time'].' 00:00:00') : '';
		$end_time = !empty($_GET['end_time']) ? strtotime($_GET['end_time'].' 23:59:59') : '';
		$search_word = !empty($_GET['search_word']) ? $_GET['search_word'] : '';
		$order_by = !empty($_GET['order_by']) ? $_GET['order_by'] : '';
		if(!empty($order_by)){
			$order = $order_by=='desc' ? 'search_times DESC' : 'search_times ASC';
		}else{
			$order = 'asc DESC';
		}
		if(!empty($start_time) && !empty($end_time)){
			if ($end_time < $start_time) {
				showmessage('开始时间不能大于结束时间');
			}
			$where = "`last_search_time` >= $start_time AND `last_search_time` <= $end_time";
			if(!empty($search_from) && $search_from!='all'){
				$where .= " AND `search_from`='$search_from'";
			}

			if(!empty($search_word)){
				$where .= " AND `search_word`='$search_word'";
			}
			$data = $this->db->listinfo($where,$order,$page,$pagesize=15);
			$pages = $this->db->pages;
			$total = $this->db->count($where);
		}else{
			$contidion = array();
			if(!empty($search_from) && $search_from!='all')$contidion['search_from'] = $search_from;
			if(!empty($search_word))$contidion['search_word'] = $search_word;
			$data = $this->db->listinfo($contidion,$order,$page,$pagesize=15);
			$pages = $this->db->pages;
			$total = $this->db->count($contidion);
		}

		include $this->admin_tpl('search_word_list');
	}

	 /**
	 *	删除
	 */
	 public function delete(){
		if(is_array($_POST['ids'])){
			foreach($_POST['ids'] as $id) {
				$this->db->delete(array('id'=>$id));
			}	
			showmessage('删除成功',HTTP_REFERER);
		}

		if(empty($_POST['ids'])){
			showmessage('都没有选择删除什么',HTTP_REFERER);
		}
	 }	 
	
}
?>