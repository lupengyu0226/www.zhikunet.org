<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_app_class('code', 'license', 0);
class admin_license extends admin {

	private $db; public $username;
	public function __construct() {
		parent::__construct();
		//if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
		$this->username = param::get_cookie('admin_username');
		$this->db = shy_base::load_model('license_model');
		$this->db2 = shy_base::load_model('type_model');
		$this->db3 = shy_base::load_model('license_notice_model');
	}
	
	public function init() {
		$sql = '';
		$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;
		$sql = '`siteid`=\''.$this->get_siteid().'\'';
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,aid DESC',$page, $pages = '9');
		if($_GET['typeid']!=''){
			$where = array('typeid'=>intval($_GET['typeid']),'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
		switch($_GET['s']) {
			case '1': $sql .= ' AND `passed`=\'1\' AND (`shouquanend` >= \''.date('Y-m-d').'\' or `shouquanend`=\'0000-00-00\') AND (`endtime` >= \''.date('Y-m-d').'\' or `endtime`=\'0000-00-00\')'; break;
			case '2': $sql .= ' AND `passed`=\'0\''; break;
			case '3': $sql .= ' AND `passed`=\'1\' AND `shouquanend`!=\'0000-00-00\' AND `shouquanend` <\''.date('Y-m-d').'\''; break;
			case '4': $sql .= ' AND `passed`=\'1\' AND `endtime`!=\'0000-00-00\' AND `endtime` <\''.date('Y-m-d').'\''; break;
		}

		$types = $this->db2->listinfo(array('module'=>ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
		$types = new_html_special_chars($types);
 		$type_arr = array ();
 		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}
		$page = max(intval($_GET['page']), 1);
		$data = $this->db->listinfo($sql, '`aid` DESC', $page);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=license&controller=admin_license&view=add\', domain:\''.L('license_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('license_add'));
		include $this->admin_tpl('license_list');

	}
	public function icd() {
		$sql = '';
		$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;
		$sql = '`siteid`=\''.$this->get_siteid().'\'';
		$infos = $this->db->listinfo($where,$order = 'icd DESC',$page, $pages = '9');
		$page = max(intval($_GET['page']), 1);
		$data = $this->db->listinfo($sql, '`aid` DESC', $page);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=license&controller=admin_license&view=add\', domain:\''.L('license_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('license_add'));
		include $this->admin_tpl('license_icd');

	}
	/**
	 * 添加授权
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['license'] = $this->check($_POST['license']);
			if($this->db->insert($_POST['license'])) showmessage(L('licensement_successful_added'), HTTP_REFERER, '', 'add');
		} else {
			//获取站点模板信息
			shy_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$types = $this->db2->get_types($siteid);
			$template_list = template_list($siteid, 0);
			$site = shy_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$show_header = $show_validator = $show_scroll = 1;
			shy_base::load_sys_class('form', '', 0);
			include $this->admin_tpl('license_add');
		}
	}
	

	
	/**
	 * ajax检测授权标题是否重复
	 */
	public function public_check_domain() {
		if (!$_GET['domain']) exit(0);
		if (CHARSET=='gbk') {
			$_GET['domain'] = iconv('UTF-8', 'GBK', $_GET['domain']);
		}
		$domain = $_GET['domain'];
		if ($_GET['aid']) {
			$r = $this->db->get_one(array('aid' => $_GET['aid']));
			if ($r['domain'] == $domain) {
				exit('1');
			}
		} 
		$r = $this->db->get_one(array('siteid' => $this->get_siteid(), 'domain' => $domain), 'aid');
		if($r['aid']) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * 批量修改授权状态 使其成为审核、未审核状态
	 */
	public function public_approval($aid = 0) {
		if((!isset($_POST['aid']) || empty($_POST['aid'])) && !$aid) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['aid']) && !$aid) {
				array_map(array($this, 'public_approval'), $_POST['aid']);
				showmessage(L('license_passed'), HTTP_REFERER);
			} elseif($aid) {
				$aid = intval($aid);
				$this->db->update(array('passed' => $_GET['passed']), array('aid' => $aid));
				return true;
			}
		}
	}
	
	/**
	 * 批量删除授权
	 */
	public function delete($aid = 0) {
		if((!isset($_POST['aid']) || empty($_POST['aid'])) && !$aid) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['aid']) && !$aid) {
				array_map(array($this, 'delete'), $_POST['aid']);
				showmessage(L('license_deleted'), HTTP_REFERER);
			} elseif($aid) {
				$aid = intval($aid);
				$this->db->delete(array('aid' => $aid));
			}
		}
	}
	
	//添加分类时，验证分类名是否已存在
	public function public_check_name() {
		$type_name = isset($_GET['type_name']) && trim($_GET['type_name']) ? (shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['type_name'])) : trim($_GET['type_name'])) : exit('0');
		$type_name = safe_replace($type_name);
 		$typeid = isset($_GET['typeid']) && intval($_GET['typeid']) ? intval($_GET['typeid']) : '';
 		$data = array();
		if ($typeid) {
 			$data = $this->db2->get_one(array('typeid'=>$typeid), 'name');
			if (!empty($data) && $data['name'] == $type_name) {
				exit('1');
			}
		}
		if ($this->db2->get_one(array('name'=>$type_name), 'typeid')) {
			exit('0');
		} else {
			exit('1');
		}
	}

 	public function add_type() {
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['type']['name'])) {
				showmessage(L('typename_noempty'),HTTP_REFERER);
			}
			$_POST['type']['siteid'] = $this->get_siteid(); 
			$_POST['type']['module'] = ROUTE_M;
 			$this->db2 = shy_base::load_model('type_model');
			$typeid = $this->db2->insert($_POST['type'],true);
			if(!$typeid) return FALSE;
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_header = $show_validator = $show_scroll = 1;
 			include $this->admin_tpl('license_type_add');
		}

	}

	public function delete_type() {
		if((!isset($_GET['typeid']) || empty($_GET['typeid'])) && (!isset($_POST['typeid']) || empty($_POST['typeid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['typeid'])){
				foreach($_POST['typeid'] as $typeid_arr) {
 					$this->db2->delete(array('typeid'=>$typeid_arr));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				$typeid = intval($_GET['typeid']);
				if($typeid < 1) return false;
				$result = $this->db2->delete(array('typeid'=>$typeid));
				if($result)
				{
					showmessage(L('operation_success'),HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"),HTTP_REFERER);
				}
			}
		}
	}
	//:分类管理
 	public function list_type() {
		$this->db2 = shy_base::load_model('type_model');
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'listorder DESC',$page, $pages = '10');
		$pages = $this->db2->pages;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=license&controller=admin_license&view=add_type\', domain:\''.L('add_type').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_type'));
		include $this->admin_tpl('license_list_type');
	}


	public function edit() {
		$_GET['aid'] = intval($_GET['aid']);
		if(!$_GET['aid']) showmessage(L('illegal_operation'));
		if(isset($_POST['dosubmit'])) {
			$_POST['license'] = $this->check($_POST['license'], 'edit');
			if($this->db->update($_POST['license'], array('aid' => $_GET['aid']))) showmessage(L('licensed_a'), HTTP_REFERER, '', 'edit');
		} else {
			$where = array('aid' => $_GET['aid']);
			$an_info = $this->db->get_one($where);
			shy_base::load_sys_class('form', '', 0);
			$types = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
 			$type_arr = array ();
			foreach($types as $typeid=>$type){
				$type_arr[$type['typeid']] = $type['name'];
			}
			//获取站点模板信息
	        	shy_base::load_app_func('global', 'admin');
			$template_list = template_list($this->siteid, 0);
			$show_header = $show_validator = $show_scroll = 1;
			$info = $this->db->get_one(array('aid'=>$_GET['aid']));
			extract($info); 

			include $this->admin_tpl('license_edit');
		}
	}
	public function edit_type() {
		if(isset($_POST['dosubmit'])){ 
			$typeid = intval($_GET['typeid']); 
			if($typeid < 1) return false;
			if(!is_array($_POST['type']) || empty($_POST['type'])) return false;
			if((!$_POST['type']['name']) || empty($_POST['type']['name'])) return false;
			$this->db2->update($_POST['type'],array('typeid'=>$typeid));
			showmessage(L('operation_success'),'?app=license&controller=admin_license&view=list_type','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			//解出分类内容
			$info = $this->db2->get_one(array('typeid'=>$_GET['typeid']));
			if(!$info) showmessage(L('licensetype_exit'));
			extract($info);
			include $this->admin_tpl('license_type_edit');
		}

	}
    //远程公告首页
	public function notice_init() {
		$sql = '';
		$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;
		$sql = '`siteid`=\''.$this->get_siteid().'\'';
		$infos = $this->db3->listinfo($where,$order = 'listorder DESC,aid DESC',$page, $pages = '9');
		switch($_GET['s']) {
			case '1': $sql .= ' AND `passed`=\'1\' AND (`endtime` >= \''.date('Y-m-d').'\' or `endtime`=\'0000-00-00\')'; break;
			case '2': $sql .= ' AND `passed`=\'0\''; break;
			case '3': $sql .= ' AND `passed`=\'1\' AND `endtime`!=\'0000-00-00\' AND `endtime` <\''.date('Y-m-d').'\' '; break;
		}
		$page = max(intval($_GET['page']), 1);
		$data = $this->db3->listinfo($sql, '`aid` DESC', $page);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=license&controller=admin_license&view=notice_add\', domain:\''.L('notice_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('notice_add'));
		include $this->admin_tpl('license_notice_init');

	}
    //远程公告添加页
	public function notice_add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['notice'] = $this->noticecheck($_POST['notice']);
			if($this->db3->insert($_POST['notice'])) showmessage(L('licensement_successful_added'), HTTP_REFERER, '', 'add');
		} else {
			//获取站点模板信息
			shy_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$site = shy_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			shy_base::load_sys_class('form', '', 0);
		include $this->admin_tpl('license_notice_add');
		}

	}
	public function notice_edit() {
		$_GET['aid'] = intval($_GET['aid']);
		if(!$_GET['aid']) showmessage(L('illegal_operation'));
		if(isset($_POST['dosubmit'])) {
			$_POST['notice'] = $this->noticecheck($_POST['notice'], 'edit');
			if($this->db3->update($_POST['notice'], array('aid' => $_GET['aid']))) showmessage(L('licensed_a'), HTTP_REFERER, '', 'edit');
		} else {
			$where = array('aid' => $_GET['aid']);
			$an_info = $this->db3->get_one($where);
			shy_base::load_sys_class('form', '', 0);
	        shy_base::load_app_func('global', 'admin');
			$info = $this->db3->get_one(array('aid'=>$_GET['aid']));
			extract($info); 
			include $this->admin_tpl('license_notice_edit');
		}
	}
	public function notice_delete($aid = 0) {
		if((!isset($_POST['aid']) || empty($_POST['aid'])) && !$aid) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['aid']) && !$aid) {
				array_map(array($this, 'notice_delete'), $_POST['aid']);
				showmessage(L('license_deleted'), HTTP_REFERER);
			} elseif($aid) {
				$aid = intval($aid);
				$this->db3->delete(array('aid' => $aid));
			}
		}
	}
	//更新排序
 	public function notice_listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $aid => $listorder) {
				$aid = intval($aid);
				$this->db3->update(array('listorder'=>$listorder),array('aid'=>$aid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	/**
	 * 批量修改远程公告状态 使其成为审核、未审核状态
	 */
	public function public_passed($aid = 0) {
		if((!isset($_POST['aid']) || empty($_POST['aid'])) && !$aid) {
			showmessage(L('illegal_operation'));
		} else {
			if(is_array($_POST['aid']) && !$aid) {
				array_map(array($this, 'public_passed'), $_POST['aid']);
				showmessage(L('license_passed'), HTTP_REFERER);
			} elseif($aid) {
				$aid = intval($aid);
				$this->db3->update(array('passed' => $_GET['passed']), array('aid' => $aid));
				return true;
			}
		}
	}
	/**
	 * ajax检测公告标题是否重复
	 */
	public function public_check_notice() {
		if (!$_GET['title']) exit(0);
		if (CHARSET=='gbk') {
			$_GET['title'] = iconv('UTF-8', 'GBK', $_GET['title']);
		}
		$domain = $_GET['title'];
		if ($_GET['aid']) {
			$r = $this->db3->get_one(array('aid' => $_GET['aid']));
			if ($r['title'] == $title) {
				exit('1');
			}
		} 
		$r = $this->db3->get_one(array('siteid' => $this->get_siteid(), 'title' => $title), 'aid');
		if($r['aid']) {
			exit('0');
		} else {
			exit('1');
		}
	}
	/**
	 *验证公告表单数据完整性
	 */
	private function noticecheck($data = array(), $a = 'add') {
		if($data['title']=='') showmessage(L('title_cannot_empty'));
		if($data['content']=='') showmessage(L('licensements_cannot_be_empty'));
		$r = $this->db3->get_one(array('title' => $data['title']));
		if ($a=='add') {
			if (is_array($r) && !empty($r)) {
				showmessage(L('license_exist'), HTTP_REFERER);
			}
			$data['siteid'] = $this->get_siteid();
			$data['addtime'] = SYS_TIME;
			$data['username'] = $this->username;
			if ($r['aid'] && ($r['aid']!=$_GET['aid'])) {
				showmessage(L('license_exist'), HTTP_REFERER);
			}
		}
		return $data;
	}
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('aid'=>$_GET['aid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $aid => $listorder) {
				$aid = intval($aid);
				$this->db->update(array('listorder'=>$listorder),array('aid'=>$aid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	/**
	 * 验证表单数据
	 * @param  		array 		$data 表单数组数据
	 * @param  		string 		$a 当表单为添加数据时，自动补上缺失的数据。
	 * @return 		array 		验证后的数据
	 */
	private function check($data = array(), $a = 'add') {
		if($data['domain']=='') showmessage(L('domain_cannot_empty'));
		if($data['content']=='') showmessage(L('licensements_cannot_be_empty'));
		$r = $this->db->get_one(array('domain' => $data['domain']));
		if (strtotime($data['endtime'])<strtotime($data['starttime'])) {
			$data['endtime'] = '';
		}
		if ($a=='add') {
			if (is_array($r) && !empty($r)) {
				showmessage(L('license_exist'), HTTP_REFERER);
			}
			$data['siteid'] = $this->get_siteid();
			$data['addtime'] = SYS_TIME;
			$data['username'] = $this->username;
			if ($data['starttime'] == '') $license['starttime'] = date('Y-m-d');
		} else {
			if ($r['aid'] && ($r['aid']!=$_GET['aid'])) {
				showmessage(L('license_exist'), HTTP_REFERER);
			}
		}
		return $data;
	}
}
?>
