<?php
/**
 *  application.class.php SHUYANG应用程序创建类
 *
 * @copyright			(C) 2005-2010 SHUYANG
 * @license				http://www.05273.com/license/
 * @lastmodify			2010-6-7
 */
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class application {
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		$param = shy_base::load_sys_class('param');
		define('ROUTE_M', $param->route_m());
		define('ROUTE_C', $param->route_c());
		define('ROUTE_A', $param->route_a());
		$this->init();
	}
	
	/**
	 * 调用件事
	 */
	private function init() {
		$controller = $this->load_controller();
		if (empty($a)) $a = ROUTE_A;
		if (method_exists($controller, ROUTE_A)) {
			if (preg_match('/^[_]/i', ROUTE_A)) {
				exit('You are visiting the action is to protect the private action');
			} else {
				call_user_func(array($controller, ROUTE_A));
			}
		} else {
			halt("无法加载控制器:$a");
		}
	}
	
	/**
	 * 加载控制器
	 * @param string $filename
	 * @param string $m
	 * @return obj
	 */
	private function load_controller($filename = '', $m = '') {
		if (empty($filename)) $filename = ROUTE_C;
		if (empty($m)) $m = ROUTE_M;
		$filepath = SHY_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.$filename.'.php';
		if (file_exists($filepath)) {
			$classname = $filename;
			include $filepath;
			if ($mypath = shy_base::my_path($filepath)) {
				$classname = 'MY_'.$filename;
				include $mypath;
			}
			return new $classname;
		} else {
		halt("控制器错误！");
		}
	}
}
