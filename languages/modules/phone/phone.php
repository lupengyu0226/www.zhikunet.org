<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class phone extends admin {
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('phone', 'commons'));
		$this->db = shy_base::load_model('phone_model');
		$this->db2 = shy_base::load_model('type_model');
	}

	public function init() {
		if($_GET['typeid']!=''){
			$where = array('typeid'=>intval($_GET['typeid']),'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,phoneid DESC',$page, $pages = '15');
		$pages = $this->db->pages;
		$types = $this->db2->listinfo(array('module'=>ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
		$types = new_html_special_chars($types);
 		$type_arr = array ();
 		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=phone&controller=phone&view=add\', title:\''.L('phone_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('phone_add'));
		include $this->admin_tpl('phone_list');
	}

	/*
	 *判断标题重复和验证 
	 */
	public function public_name() {
		$phone_title = isset($_GET['phone_name']) && trim($_GET['phone_name']) ? (shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['phone_name'])) : trim($_GET['phone_name'])) : exit('0');
			
		$phoneid = isset($_GET['phoneid']) && intval($_GET['phoneid']) ? intval($_GET['phoneid']) : '';
		$data = array();
		if ($phoneid) {

			$data = $this->db->get_one(array('phoneid'=>$phoneid), 'name');
			if (!empty($data) && $data['name'] == $phone_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$phone_title), 'phoneid')) {
			exit('0');
		} else {
			exit('1');
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
	 
	//添加友情链接
 	public function add() {
 		if(isset($_POST['dosubmit'])) {
			$_POST['phone']['addtime'] = SYS_TIME;
			$_POST['phone']['siteid'] = $this->get_siteid();
			if(empty($_POST['phone']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['phone']['name'] = safe_replace($_POST['phone']['name']);
			}
			if ($_POST['phone']['logo']) {
				$_POST['phone']['logo'] = safe_replace($_POST['phone']['logo']);
			}
			$data = new_addslashes($_POST['phone']);
			$phoneid = $this->db->insert($data,true);
			if(!$phoneid) return FALSE; 
 			$siteid = $this->get_siteid();
	 		//更新附件状态
			if(shy_base::load_config('system','attachment_stat') & $_POST['phone']['logo']) {
				$this->attachment_db = shy_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['phone']['logo'],'phone-'.$phoneid,1);
			}
			showmessage(L('operation_success'),HTTP_REFERER,'', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			shy_base::load_sys_class('form', '', 0);
 			$siteid = $this->get_siteid();
			$types = $this->db2->get_types($siteid);
			
			//print_r($types);exit;
 			include $this->admin_tpl('phone_add');
		}

	}
	
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('phoneid'=>$_GET['phoneid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $phoneid => $listorder) {
				$phoneid = intval($phoneid);
				$this->db->update(array('listorder'=>$listorder),array('phoneid'=>$phoneid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	
	//添加友情链接分类
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
			$show_validator = $show_scroll = true;
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=phone&controller=phone&view=add\', title:\''.L('phone_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('phone_add'));
 			include $this->admin_tpl('phone_type_add');
		}

	}
	
	/**
	 * 删除分类
	 */
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
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=phone&controller=phone&view=add\', title:\''.L('phone_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('phone_add'));
		$pages = $this->db2->pages;
		include $this->admin_tpl('phone_list_type');
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$phoneid = intval($_GET['phoneid']);
			if($phoneid < 1) return false;
			if(!is_array($_POST['phone']) || empty($_POST['phone'])) return false;
			if((!$_POST['phone']['name']) || empty($_POST['phone']['name'])) return false;
			$this->db->update($_POST['phone'],array('phoneid'=>$phoneid));
			//更新附件状态
			//if(shy_base::load_config('system','attachment_stat') & $_POST['phone']['logo']) {
			//	$this->attachment_db = shy_base::load_model('attachment_model');
			//	$this->attachment_db->api_update($_POST['phone']['logo'],'phone-'.$phoneid,1);
			//}
			showmessage(L('operation_success'),'?app=phone&controller=phone&view=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			shy_base::load_sys_class('form', '', 0);
			$types = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
 			$type_arr = array ();
			foreach($types as $typeid=>$type){
				$type_arr[$type['typeid']] = $type['name'];
			}
			//解出链接内容
			$info = $this->db->get_one(array('phoneid'=>$_GET['phoneid']));
			if(!$info) showmessage(L('phone_exit'));
			extract($info); 
 			include $this->admin_tpl('phone_edit');
		}

	}
	
	/**
	 * 修改友情链接 分类
	 */
	public function edit_type() {
		if(isset($_POST['dosubmit'])){ 
			$typeid = intval($_GET['typeid']); 
			if($typeid < 1) return false;
			if(!is_array($_POST['type']) || empty($_POST['type'])) return false;
			if((!$_POST['type']['name']) || empty($_POST['type']['name'])) return false;
			$this->db2->update($_POST['type'],array('typeid'=>$typeid));
			showmessage(L('operation_success'),'?app=phone&controller=phone&view=list_type','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			//解出分类内容
			$info = $this->db2->get_one(array('typeid'=>$_GET['typeid']));
			if(!$info) showmessage(L('phonetype_exit'));
			extract($info);
			include $this->admin_tpl('phone_type_edit');
		}

	}

	/**
	 * 删除友情链接  
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['phoneid']) || empty($_GET['phoneid'])) && (!isset($_POST['phoneid']) || empty($_POST['phoneid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['phoneid'])){
				foreach($_POST['phoneid'] as $phoneid_arr) {
 					//批量删除友情链接
					$this->db->delete(array('phoneid'=>$phoneid_arr));
					//更新附件状态
					if(shy_base::load_config('system','attachment_stat')) {
						$this->attachment_db = shy_base::load_model('attachment_model');
						$this->attachment_db->api_delete('phone-'.$phoneid_arr);
					}
				}
				showmessage(L('operation_success'),'?app=phone&controller=phone');
			}else{
				$phoneid = intval($_GET['phoneid']);
				if($phoneid < 1) return false;
				//删除友情链接
				$result = $this->db->delete(array('phoneid'=>$phoneid));
				//更新附件状态
				if(shy_base::load_config('system','attachment_stat')) {
					$this->attachment_db = shy_base::load_model('attachment_model');
					$this->attachment_db->api_delete('phone-'.$phoneid);
				}
				if($result){
					showmessage(L('operation_success'),'?app=phone&controller=phone');
				}else {
					showmessage(L("operation_failure"),'?app=phone&controller=phone');
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	 
	/**
	 * 投票模块配置
	 */
	public function setting() {
		//读取配置文件
		$data = array();
 		$siteid = $this->get_siteid();//当前站点 
		//更新模型数据库,重设setting 数据. 
		$m_db = shy_base::load_model('module_model');
		$data = $m_db->select(array('module'=>'phone'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; //当前站点配置
		if(isset($_POST['dosubmit'])) {
			//多站点存储配置文件
 			$setting[$siteid] = $_POST['setting'];
  			setcache('phone', $setting, 'commons');  
			//更新模型数据库,重设setting 数据. 
  			$m_db = shy_base::load_model('module_model'); //调用模块数据模型
			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			showmessage(L('setting_updates_successful'), '?app=phone&controller=phone&view=init');
		} else {
			@extract($now_seting);
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=phone&controller=phone&view=add\', title:\''.L('phone_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('phone_add'));
 			include $this->admin_tpl('setting');
		}
	}
	
  	//批量审核申请 ...
 	public function check_register(){
		if(isset($_POST['dosubmit'])) {
			if((!isset($_GET['phoneid']) || empty($_GET['phoneid'])) && (!isset($_POST['phoneid']) || empty($_POST['phoneid']))) {
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			} else {
				if(is_array($_POST['phoneid'])){//批量审核
					foreach($_POST['phoneid'] as $phoneid_arr) {
						$this->db->update(array('passed'=>1),array('phoneid'=>$phoneid_arr));
					}
					showmessage(L('operation_success'),'?app=phone&controller=phone');
				}else{//单个审核
					$phoneid = intval($_GET['phoneid']);
					if($phoneid < 1) return false;
					$result = $this->db->update(array('passed'=>1),array('phoneid'=>$phoneid));
					if($result){
						showmessage(L('operation_success'),'?app=phone&controller=phone');
					}else {
						showmessage(L("operation_failure"),'?app=phone&controller=phone');
					}
				}
			}
		}else {//读取未审核列表
			$where = array('siteid'=>$this->get_siteid(),'passed'=>0);
			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$infos = $this->db->listinfo($where,'phoneid DESC',$page, $pages = '20');
			$pages = $this->db->pages;
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=phone&controller=phone&view=add\', title:\''.L('phone_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('phone_add'));
			include $this->admin_tpl('check_register_list');
		}
		
	}
	
 	//单个审核申请
 	public function check(){
		if((!isset($_GET['phoneid']) || empty($_GET['phoneid'])) && (!isset($_POST['phoneid']) || empty($_POST['phoneid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else { 
			$phoneid = intval($_GET['phoneid']);
			if($phoneid < 1) return false;
			//删除友情链接
			$result = $this->db->update(array('passed'=>1),array('phoneid'=>$phoneid));
			if($result){
				showmessage(L('operation_success'),'?app=phone&controller=phone');
			}else {
				showmessage(L("operation_failure"),'?app=phone&controller=phone');
			}
			 
		}
	}

    
	
	/**
	 * 说明:对字符串进行处理
	 * @param $string 待处理的字符串
	 * @param $isjs 是否生成JS代码
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
 
 
	
}
?>
