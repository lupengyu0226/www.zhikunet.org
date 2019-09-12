<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class mobile_admin extends admin {
	private $db,$type_db;
	function __construct() {
		parent::__construct();
		$this->sites = shy_base::load_app_class('sites','admin');
		$this->db = shy_base::load_model('mobile_model');
	}
	
	function init() {
		shy_base::load_app_func('global','mobile');
		define('SHY_VERSION', shy_base::load_config('version','shy_version'));
		define('SHY_RELEASE', shy_base::load_config('version','shy_release'));
		$infos = $this->db->select();
		$show_dialog = true;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=mobile&controller=mobile_admin&view=add\', title:\''.L('add_site').'\', width:\'440\', height:\'380\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('mobile_add_site'));
		include $this->admin_tpl('m_list');
		license($data);
	}
	
	function edit() {
		if($_POST['dosubmit']) {
			$siteid = intval($_POST['siteid']) ? intval($_POST['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			$sitename = trim(new_addslashes($_POST['sitename']));
			$logo = trim($_POST['logo']);
			$domain = trim($_POST['domain']);
			$setting = array2string($_POST['setting']);
			$this->db->update(array('sitename'=>$sitename,'logo'=>$logo,'domain'=>$domain,'setting'=>$setting), array('siteid'=>$siteid));
			$this->mobile_site_cache();
			showmessage(L('operation_success'), '', '', 'edit');
		} else {
			$siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			$sitelist = $this->sites->get_list();			
			$info = $this->db->get_one(array('siteid'=>$siteid));
			if($info) {
				extract($info);	
				extract(string2array($setting));
			}
			$show_header = true;
			include $this->admin_tpl('m_edit');			
		}
	}
	
	function add() {
		if($_POST['dosubmit']) {
			$siteid = intval($_POST['siteid']) ? intval($_POST['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
			if($this->db->get_one(array('siteid'=>$siteid))) {
				showmessage(L('mobile_add_samesite_error'),HTTP_REFERER);
			}
			$sitename = trim(new_addslashes($_POST['sitename']));
			$logo = trim($_POST['logo']);
			$domain = trim($_POST['domain']);
			$setting = array2string($_POST['setting']);
			$return_id = $this->db->insert(array('siteid'=>$siteid,'sitename'=>$sitename,'logo'=>$logo,'domain'=>$domain,'setting'=>$setting),'1');
			$this->mobile_site_cache();
			showmessage(L('operation_success'), '', '', 'add');
		} else {
			$sitelists = array();
			$current_siteid = get_siteid();
			$sitelists = $this->sites->get_list();
			if($_SESSION['roleid'] == '1') {
				foreach($sitelists as $key=>$v) $sitelist[$key] = $v['name'];
			} else {
				$sitelist[$current_siteid] = $sitelists[$current_siteid]['name'];
			}			
			$show_header = true;
			include $this->admin_tpl('m_add');			
		}		
	}
	
	function delete() {
		$siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		if($siteid == 1) showmessage(L('mobile_permission_denied_del'),HTTP_REFERER);
		$this->db->delete(array('siteid'=>$siteid));
		$this->type_db->delete(array('siteid'=>$siteid));
		$this->mobile_site_cache();
		showmessage(L('mobile_del_succ'),HTTP_REFERER);
	}
	
	function public_status() {
		 $status = intval($_GET['status']) && intval($_GET['status'])== 1 ? '1' : '0';
		 $siteid = intval($_GET['siteid']) ? intval($_GET['siteid']) : showmessage(L('parameter_error'),HTTP_REFERER);
		 $this->db->update(array('status'=>$status), array('siteid'=>$siteid));
		 $this->mobile_site_cache();
		 showmessage(L('mobile_change_status'),HTTP_REFERER);
	}
	public function public_show_cat_ajx() {
		$parentid = intval($_GET['parentid']);
		$siteid = intval($_GET['siteid']);
		echo form::select_category('',0,'name="addcat['.$parentid.'][]"',L('mobile_type_bound'),0,0,0,$siteid);
	}
	
	private function mobile_site_cache() {
		$datas = $this->db->select();
		$array = array();
		foreach ($datas as $r) {
			$array[$r['siteid']] = $r;
		}
		setcache('mobile_site', $array,'mobile');		
	}
	function system_information($data) {

	}
	
}
?>
