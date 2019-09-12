<?php
/*
应用市场管理类
*/
defined('IN_SHUYANG') or exit('The resource access forbidden.');
shy_base::load_app_class('module_api','admin',0);

class zhuanlan_api extends module_api {
	
	private $db;	
	public function __construct() {
		$this->db = shy_base::load_model('zhuanlan_model');
		parent::__construct();
	}
	/**
	 * 检查安装目录
	 * @param string $module 模块名
	 */
	public function check($module = '') {
		define('INSTALL', true);
		if ($module) $this->module = $module;
		if(!$this->module) {
			$this->error_msg = L('no_module');
			return false;
		}
		$r = $this->db->get_one(array('module'=>$this->module));
		if ($r) {
			$this->error_msg = L('this_module_installed');
			return true;
		}
		return false;
	}
		
	
}
?>	