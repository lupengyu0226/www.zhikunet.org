<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class setting extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('module_model');
		shy_base::load_app_func('global');
	}
	
	/**
	 * 配置信息
	 */
	public function init() {
		$show_validator = true;
		$this->ssidb = shy_base::load_model('ssi_model');
		$setconfig = shy_base::load_config('system');	
		$setversion = shy_base::load_config('version');//load版本信息
		extract($setconfig);
		extract($setversion);
		if(!function_exists('ob_gzhandler')) $gzip = 0;
		$info = $this->db->get_one(array('module'=>'admin'));
		extract(string2array($info['setting']));
		$tougaoinfo = $this->db->get_one(array('module'=>'email'));
		$tougao = string2array($tougaoinfo['setting']);
		$show_header = true;
		$show_validator = 1;
		$where = array('typeid'=>'154');
		$ssi = $this->ssidb->listinfo($where,$order = 'id DESC',$page, $pages = '100');
		include $this->admin_tpl('setting');
	}
	
	/**
	 * 保存配置信息
	 */
	public function save() {
		
		$setting = array();
		$setting['admin_email'] = is_email($_POST['setting']['admin_email']) ? trim($_POST['setting']['admin_email']) : showmessage(L('email_illegal'),HTTP_REFERER);
		$setting['maxloginfailedtimes'] = intval($_POST['setting']['maxloginfailedtimes']);
		$setting['minrefreshtime'] = intval($_POST['setting']['minrefreshtime']);
		$setting['mail_type'] = intval($_POST['setting']['mail_type']);		
		$setting['mail_server'] = trim($_POST['setting']['mail_server']);	
		$setting['mail_port'] = intval($_POST['setting']['mail_port']);	
		$setting['category_ajax'] = intval(abs($_POST['setting']['category_ajax']));	
		$setting['mail_user'] = trim($_POST['setting']['mail_user']);
		$setting['mail_auth'] = intval($_POST['setting']['mail_auth']);		
		$setting['mail_from'] = trim($_POST['setting']['mail_from']);		
		$setting['mail_password'] = trim($_POST['setting']['mail_password']);
		$setting['errorlog_size'] = trim($_POST['setting']['errorlog_size']);
		$setting = array2string($setting);
		$savetougao = array2string($_POST['savetougao']);
		$this->db->update(array('setting'=>$setting), array('module'=>'admin')); //存入admin模块setting字段
		set_config($_POST['setconfig']);	 //保存进config文件
		set_config($_POST['setversion'],'version');//保存版本信息
		$this->db->update(array('setting'=>$savetougao), array('module'=>'email')); //存入email模块setting字段
		$this->setcache();
		showmessage(L('setting_succ'), HTTP_REFERER);
	}
	/*
	 * 测试邮件配置
	 */
	public function public_test_mail() {
		shy_base::load_sys_func('mail');
		$subject = '沭阳网邮件测试';
		$message = '这是一封来自沭阳网的邮件测试信件！';
		$mail= Array (
			'mailsend' => 2,
			'maildelimiter' => 1,
			'mailusername' => 1,
			'server' => $_POST['mail_server'],
			'port' => intval($_POST['mail_port']),
			'mail_type' => intval($_POST['mail_type']),
			'auth' => intval($_POST['mail_auth']),
			'from' => $_POST['mail_from'],
			'auth_username' => $_POST['mail_user'],
			'auth_password' => $_POST['mail_password']
		);	
		
		if(sendmail($_GET['mail_to'],$subject,$message,$_POST['mail_from'],$mail)) {
			echo L('test_email_succ').$_GET['mail_to'];
		} else {
			echo L('test_email_faild');
		}	
	}
	
	/**
	 * 设置缓存
	 * Enter description here ...
	 */
	private function setcache() {
		$result = $this->db->get_one(array('module'=>'admin'));
		$setting = string2array($result['setting']);
		setcache('common', $setting,'commons');
		$tougaocache = $this->db->get_one(array('module'=>'email'));
		$tougaocachesetting = string2array($tougaocache['setting']);
		setcache('tougao', $tougaocachesetting,'commons');
	}
}
?>
