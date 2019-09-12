<?php
/**
 *  application.class.php 飞天系统应用程序创建类
 *
 * @copyright			(C) 2005-2014 EDI
 * @license				http://www.05273.cn/index.php?app=license
 * @lastmodify			2014-5-16
 */
class application {
	
	/**
	 * 构造函数
	 */
	public function __construct($app=null,$controller = null,$view = null,$args = array()) {
		!is_object($param)?$param = shy_base::load_sys_class('param'):null;
		define('ROUTE_M', !is_null($app)?$app:$param->route_m());
		define('ROUTE_C', !is_null($controller)?$controller:$param->route_c());
		define('ROUTE_A', !is_null($view)?$view:$param->route_a());
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
				exit('你正在访问的内容受到隐私保护！');
			} else {
				call_user_func(array($controller, ROUTE_A));
			}
		} else {
			halt("无法加载方法:$a");
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
		//先检测模块是否存在
		$M = array_keys(getcache('modules', 'commons'));	
		if (!in_array($m,$M) || @opendir(SHY_PATH.'modules'.DIRECTORY_SEPARATOR.$m)=== false) halt("无法加载模块:$m");	
		$filepath = SHY_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.$filename.'.php';
		if (file_exists($filepath)) {
			$classname = $filename;
			include $filepath;
			if ($mypath = shy_base::my_path($filepath)) {
				$classname = 'EDI_'.$filename;
				include $mypath;
			}
			if(class_exists($classname)){
				return new $classname;
			}else{
				halt("无法加载控制器:$filename");
 			}			
		} else {
			halt("无法加载控制器:$filename");
		}
	}
}
