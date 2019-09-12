<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
$session_storage = 'session_'.shy_base::load_config('system','session_storage');
shy_base::load_sys_class($session_storage);
shy_base::load_app_func('global', 'phpsso');
class login extends admin {
	
	/**
	 * 初始化页面
	 */
	public function init() {
		include $this->admin_tpl('login');
	}
	
	/**
	 * 登陆
	 */
	public function logind() {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');	
		$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('nameerror'), '?app=admin&view=init&controller=login');
		$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_can_not_be_empty'), '?app=admin&view=init&controller=login');
		$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
		if ($_SESSION['code'] != strtolower($code)) {
			showmessage(L('code_error'), HTTP_REFERER);
		}
		if(!is_username($username)){
			showmessage(L('username_illegal'), HTTP_REFERER);
		}
		if ($this->login($username,$password)) {
			$forward = isset($_POST['forward']) ? urldecode($_POST['forward']) : '';
			showmessage(L('login_succeeded'), '?app=admin&controller=index&view=init&forward='.$forward);
		} else {
			showmessage($this->get_err(), '?app=admin&controller=login&view=init&forward='.$_POST['forward']);
		}
	}
	
	/**
	 * 退出登录
	 */
	public function logout() {
		$this->log_out();
		$forward = isset($_GET['forward']) ? urlencode($_GET['forward']) : '';
		showmessage(L('logout_succeeded'), '?app=admin&controller=login&view=init&forward='.$forward);
	}
}