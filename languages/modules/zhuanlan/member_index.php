<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
$session_storage = 'session_'.shy_base::load_config('system','session_storage');
shy_base::load_sys_class($session_storage);
shy_base::load_app_class('foreground','member');
shy_base::load_sys_class('format', '', 0);
shy_base::load_sys_class('form', '', 0);
shy_base::load_app_func('global');
	class member_index extends foreground {
		private $member_db,$siteid,$urlrules,$setting;
		function __construct() {
			parent::__construct();
			$this->db =shy_base::load_model('zhuanlan_model');
			$this->member_db = shy_base::load_model('member_model');
			$this->urlrules = getcache('urlrules','commons');
			$this->_username = param::get_cookie('_username');
			$this->_userid = intval(param::get_cookie('_userid'));
			$this->siteid = $GLOBALS['siteid'] = max($this->siteid,1);
			$this->setting=getcache('zhuanlan_setting','zhuanlan');
			$this->zhuanlan_caches = shy_base::load_app_class('zhuanlan_cache','zhuanlan');
			if($this->setting[$this->siteid]['status']!=1) showmessage('zhuanlan_close_status');
		}
	public function init() {
		$memberinfo = $this->memberinfo;
		$this->_session_start();
		$_SESSION['userid'] = $this->_userid;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		$zhuanlan_info = $this->db->get_one(array('username'=>$this->_username));
			if ($memberinfo['point'] > 99){
				include template('zhuanlan','member_index');
				}else{
				include template('member', 'mp_yuebuzu');
			}
		}
	 /**
	 *	申请专栏 
	 */
	public function register() { 
		$memberinfo = $this->memberinfo;
		$this->_session_start();
		$_SESSION['userid'] = $this->_userid;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		$zhuanlan_info = $this->db->get_one(array('username'=>$this->_username));
		if($zhuanlan_info['status']=='0') showmessage('你申请的沭阳号尚未通过审核');
		if($zhuanlan_info['status']=='2') showmessage('你的沭阳号被拒绝通过，详情联系管理员');
		if($zhuanlan_info['username']==$this->_username) showmessage('你已经申请过沭阳号');
 		if(isset($_POST['dosubmit'])){
			$name = safe_replace(strip_tags($_POST['name']));
			$domain = safe_replace(strip_tags($_POST['domain']));
			$thumb = safe_replace(strip_tags($_POST['thumb']));
			$thumb = trim_script($thumb);
			$username = $this->_username;
			$authors = safe_replace(strip_tags($_POST['authors']));
			$creat_at = SYS_TIME;
 			$sql = array('name'=>$name,'domain'=>$domain,'thumb'=>$thumb,'authors'=>$authors,'username'=>$username,'status'=>'0','creat_at'=>$creat_at);
 			$this->db->insert($sql);
 			showmessage(L('沭阳号申请成功，请等待审核！'), PASSPORT_PATH.'mp-init.html');
 		} else {
 			$username = $this->_username;
			if ($memberinfo['point'] > 99){
   			    include template('zhuanlan','member_register');
				}else{
				include template('member', 'mp_yuebuzu');
			}
 		}
	} 
	 /**
	 *	编辑专栏 
	 */
	public function edit() { 
		$memberinfo = $this->memberinfo;
		$this->_session_start();
		$_SESSION['userid'] = $this->_userid;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		$zhuanlan_info = $this->db->get_one(array('username'=>$this->_username));
		if($zhuanlan_info['username']!==$this->_username) showmessage('你还没申请过沭阳号');
    	if(isset($_GET['id'])) $id=intval($_GET['id']);
    	if($zhuanlan_info['id']!==$_GET['id']) showmessage('沭阳号ID不合法');
    	if(isset($_POST['dosubmit'])) {
			$info=array();
			$info=$_POST['info'];
			$this->db->update($info,array('id'=>$id));
			$this->zhuanlan_caches->_cache();
			showmessage(L('operation_success'), PASSPORT_PATH.'mp-init.html');
		}else{
			$zhuanlan_info = $this->db->get_one(array('id'=>$id));
			if(!empty($zhuanlan_info)){
				include template('zhuanlan','member_edit');
			}
		}
	}
	 /**
	 *	复审 
	 */
	public function fushen() { 
		$memberinfo = $this->memberinfo;
		$this->_session_start();
		$_SESSION['userid'] = $this->_userid;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		$zhuanlan_info = $this->db->get_one(array('username'=>$this->_username));
		if($zhuanlan_info['status']=='1') showmessage('你的沭阳号已经通过审核!');
		if($zhuanlan_info['username']!==$this->_username) showmessage('你还没申请过沭阳号');
    	if(isset($_GET['id'])) $id=intval($_GET['id']);
    	if($zhuanlan_info[id]!==$_GET['id']) showmessage('沭阳号ID不合法');
    	if(isset($_POST['dosubmit'])) {
			$info=array();
			$info=$_POST['info'];
			$info[status]='0';
			$this->db->update($info,array('id'=>$id));
			$this->zhuanlan_caches->_cache();
			showmessage(L('operation_success'), PASSPORT_PATH.'mp-init.html');
		}else{
			$zhuanlan_info = $this->db->get_one(array('id'=>$id));
			if(!empty($zhuanlan_info)){
				include template('zhuanlan','member_fushen');
			}
		}
	}  
	/**
	 * 检查专栏名称是否重复修改端
	 * @param string $ name	专栏名称
	 * @return $status {0:专栏名称已经存在 ;1:成功}
	 */
	public function public_checkname_ajax() {
	    $name = isset($_GET['name']) && trim($_GET['name']) && is_username(trim($_GET['name'])) ? trim($_GET['name']) : exit('0');
		if(CHARSET != 'utf-8') {
			$name = iconv('utf-8', CHARSET, $name);
			$name = addslashes($name);
		} 

		if(isset($_GET['id'])) {
			$id = intval($_GET['id']);
			//如果是会员修改，而且name和原来优质一致返回1，否则返回0
			$info = $this->db->get_one(array('id'=>$id));
			if($info['name'] == $name){//未改变
				exit('1');
			}else{//已改变，判断是否已有此名
				$where = array('name'=>$name);
				$res = $this->db->get_one($where);
				if($res) {
					exit('0');
				} else {
					exit('1');
				}
			}
 		} else {
			$where = array('name'=>$name);
			$res = $this->db->get_one($where);
			if($res) {
				exit('0');
			} else {
				exit('1');
			}
		} 
	}
	/**
	 * 检查专栏名称是否重复注册端
	 * @param string $ name	专栏名称
	 * @return $status {0:专栏名称已经存在 ;1:成功}
	 */
	public function public_checkname_reg() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? trim($_GET['name']) : exit(0);
		if(CHARSET != 'utf-8') {
			$name = iconv('utf-8', CHARSET, $name);
			$name = addslashes($name);
		}
		$name = safe_replace($name);
		if($this->db->get_one(array('name'=>$name))) {
			exit('0');
		} else {
			exit('1');
		}
	}
	/**
	 * 检查专栏域名是否重复
	 * @param string $domain	自定义域名
	 * @return $status {0:自定义域名已经存在 ;1:成功}
	 */
	public function public_check_domain() {
		$domain = isset($_GET['domain']) && trim($_GET['domain']) ? trim($_GET['domain']) : exit(0);
		if(CHARSET != 'utf-8') {
			$domain = iconv('utf-8', CHARSET, $domain);
			$domain = addslashes($domain);
		}
		$domain = safe_replace($domain);
		if($this->db->get_one(array('domain'=>$domain))) {
			exit('0');
		} else {
			exit('1');
		}
	}
	public function public_checkcode() {
		$code = $_GET['code'];
		if($_SESSION['code'] != strtolower($code)) {
			exit('0');
		} else {
			exit('1');
		}
	}
	private function _session_start() {
		$session_storage = 'session_'.shy_base::load_config('system','session_storage');
		shy_base::load_sys_class($session_storage);
	}
}
?>