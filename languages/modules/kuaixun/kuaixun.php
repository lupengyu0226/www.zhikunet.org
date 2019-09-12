<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class kuaixun extends admin {
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('kuaixun', 'commons'));
		$this->db = shy_base::load_model('kuaixun_model');
	}

	public function init() {
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,kuaixunid DESC',$page, $pages = '10');
		$pages = $this->db->pages;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=kuaixun&controller=kuaixun&view=add\', title:\''.L('kuaixun_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('kuaixun_add'));
		include $this->admin_tpl('kuaixun_list');
	}

	/*
	 *判断标题重复和验证 
	 */
	public function public_name() {
		$kuaixun_title = isset($_GET['kuaixun_name']) && trim($_GET['kuaixun_name']) ? (shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['kuaixun_name'])) : trim($_GET['kuaixun_name'])) : exit('0');
			
		$kuaixunid = isset($_GET['kuaixunid']) && intval($_GET['kuaixunid']) ? intval($_GET['kuaixunid']) : '';
		$data = array();
		if ($kuaixunid) {

			$data = $this->db->get_one(array('kuaixunid'=>$kuaixunid), 'name');
			if (!empty($data) && $data['name'] == $kuaixun_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$kuaixun_title), 'kuaixunid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	//添加快讯
 	public function add() {
 		if(isset($_POST['dosubmit'])) {
			$_POST['kuaixun']['addtime'] = SYS_TIME;
			$_POST['kuaixun']['siteid'] = $this->get_siteid();
			if(empty($_POST['kuaixun']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['kuaixun']['name'] = safe_replace($_POST['kuaixun']['name']);
			}
			$data = new_addslashes($_POST['kuaixun']);
			$kuaixunid = $this->db->insert($data,true);
			if(!$kuaixunid) return FALSE; 
			 $siteid = $this->get_siteid();
			$this->html = shy_base::load_app_class('html','content');
			$size = $this->html->kuaixun_js();
			showmessage(L('operation_success'),HTTP_REFERER,'', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			shy_base::load_sys_class('form', '', 0);
 			$siteid = $this->get_siteid();
			//print_r($types);exit;
 			include $this->admin_tpl('kuaixun_add');
		}

	}
	
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('kuaixunid'=>$_GET['kuaixunid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $kuaixunid => $listorder) {
				$kuaixunid = intval($kuaixunid);
				$this->db->update(array('listorder'=>$listorder),array('kuaixunid'=>$kuaixunid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	} 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$kuaixunid = intval($_GET['kuaixunid']);
			if($kuaixunid < 1) return false;
			if(!is_array($_POST['kuaixun']) || empty($_POST['kuaixun'])) return false;
			if((!$_POST['kuaixun']['name']) || empty($_POST['kuaixun']['name'])) return false;
			$this->db->update($_POST['kuaixun'],array('kuaixunid'=>$kuaixunid));
			$this->html = shy_base::load_app_class('html','content');
			$size = $this->html->kuaixun_js();
			showmessage(L('operation_success'),'?app=kuaixun&controller=kuaixun&view=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			shy_base::load_sys_class('form', '', 0);
			$info = $this->db->get_one(array('kuaixunid'=>$_GET['kuaixunid']));
			if(!$info) showmessage(L('kuaixun_exit'));
			extract($info); 
 			include $this->admin_tpl('kuaixun_edit');
		}

	}

	/**
	 * 删除友情链接  
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['kuaixunid']) || empty($_GET['kuaixunid'])) && (!isset($_POST['kuaixunid']) || empty($_POST['kuaixunid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['kuaixunid'])){
				foreach($_POST['kuaixunid'] as $kuaixunid_arr) {
 					//批量删除快讯
					$this->db->delete(array('kuaixunid'=>$kuaixunid_arr));
				}
				showmessage(L('operation_success'),'?app=kuaixun&controller=kuaixun');
			}else{
				$kuaixunid = intval($_GET['kuaixunid']);
				if($kuaixunid < 1) return false;
				//删除快讯
				$result = $this->db->delete(array('kuaixunid'=>$kuaixunid));
				if($result){
					showmessage(L('operation_success'),'?app=kuaixun&controller=kuaixun');
				}else {
					showmessage(L("operation_failure"),'?app=kuaixun&controller=kuaixun');
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
		$data = $m_db->select(array('module'=>'kuaixun'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; //当前站点配置
		if(isset($_POST['dosubmit'])) {
			//多站点存储配置文件
 			$setting[$siteid] = $_POST['setting'];
  			setcache('kuaixun', $setting, 'commons');  
			//更新模型数据库,重设setting 数据. 
  			$m_db = shy_base::load_model('module_model'); //调用模块数据模型
			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			$this->html = shy_base::load_app_class('html','content');
			$size = $this->html->kuaixun_js();
			showmessage(L('配置更新成功',array('size'=>sizecount($size))));
		} else {
			@extract($now_seting);
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=kuaixun&controller=kuaixun&view=add\', title:\''.L('kuaixu_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('kuaixun_add'));
 			include $this->admin_tpl('setting');
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
