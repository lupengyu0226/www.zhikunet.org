<?php
/**
 *  feitian.php 飞天系统框架入口文件
 *
 * @copyright			(C) 2005-2014 EDI
 * @license				http://www.zhikunet.org/index.php?app=license
 * @lastmodify			2014-5-16
 * @edi 2014-04-07 增加passport_path，so_path，TPL_IMAGES_PATH and safe.php
 */

define('IN_SHUYANG', true);
// 注意文件路径
//飞天系统框架路径
define('SHY_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
if(!defined('SHUYANG_PATH')) define('SHUYANG_PATH', SHY_PATH.'..'.DIRECTORY_SEPARATOR);
define('SYS_START_TIME', microtime());
define('IS_CGI',(0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);
//缓存文件夹地址
define('CACHE_PATH', SHUYANG_PATH.'caches'.DIRECTORY_SEPARATOR);
//主机协议
define('PROTOCOL', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https:' : 'http:');
define('SITE_PROTOCOL',PROTOCOL.'//');
//当前访问的主机名
define('SITE_URL', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));
//来源
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
//系统开始时间
if(!defined('CRON_PATH')){
	define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
	define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
	define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
	define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
	define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
}
//加载公用函数库
shy_base::load_sys_func('global');
shy_base::load_sys_func('extention');
shy_base::auto_load_func();
shy_base::load_config('system','errorlog') ? set_error_handler('my_error_handler') : error_reporting(E_ERROR | E_WARNING | E_PARSE);
//设置本地时差
function_exists('date_default_timezone_set') && date_default_timezone_set(shy_base::load_config('system','timezone'));
define('CHARSET' ,shy_base::load_config('system','charset'));
//输出页面字符集
header('Content-type: text/html; charset='.CHARSET);
define('SYS_TIME', time());
//定义网站根路径
define('WEB_PATH',shy_base::load_config('system','web_path'));
//js 路径
define('JS_PATH',shy_base::load_config('system','js_path'));
//css 路径
define('CSS_PATH',shy_base::load_config('system','css_path'));
//关闭调试模式
define('APP_DEBUG',shy_base::load_config('system','debug'));
//js版本控制
define('JS_VERSION',shy_base::load_config('version','js_version'));
//css版本控制
define('CSS_VERSION',shy_base::load_config('version','css_version'));
//计划任务结束ID默认值
define('PAGECOUNT_CRON',shy_base::load_config('version','pagecount_cron'));
//img 路径
define('IMG_PATH',shy_base::load_config('system','img_path'));
//通行证路径
define('PASSPORT_PATH',shy_base::load_config('system','passport_path'));
//搜索路径
define('SO_PATH',shy_base::load_config('system','so_path'));
//手机站路径
define('MOBILE_PATH',shy_base::load_config('system','mobile_path'));
//ipad站路径
define('MIP_PATH',shy_base::load_config('system','mip_path'));
//节日开关
define('FESTIVAL_OFF',shy_base::load_config('system','festival_off'));
//节日素材
define('FESTIVAL_URL',shy_base::load_config('system','festival_url'));
//动态程序路径
define('APP_PATH',shy_base::load_config('system','app_path'));
//LOGO路径
define('LOGO_MODEL',shy_base::load_config('system','logo_model'));
/**定义模版图像全局函数-2014/04/07/edi**/
define('TPL_IMAGES_PATH',WEB_PATH.'languages/templates/');
//网站防御模式
define('SAFE_MODEL',shy_base::load_config('system','safe_model'));
//应用静态文件路径
define('PLUGIN_STATICS_PATH','//statics.zhikunet.org/statics/plugin/');
//飞天系统防御框架开始
define('FEITIAN_KEY',shy_base::load_config('system','safe_key'));//用户唯一key
define('FEITIAN_PASSWORD',shy_base::load_config('system','auth_key'));
//数据回调统计地址
define('FEITIAN_API', 'https://www.zhikunet.org/api/anquanfanghu.php?key='.FEITIAN_KEY.'&domain='.APP_PATH.'&pwd='.FEITIAN_PASSWORD);
define('SAFE_NO',shy_base::load_config('system','safe_off'));
$feitian_switch=SAFE_NO;//拦截开关(1为开启，0关闭)
//提交方式拦截(1开启拦截,0关闭拦截,post,get,cookie,referre选择需要拦截的方式)
$feitian_post=1;
$feitian_get=1;
$feitian_cookie=1;
$feitian_referre=1;
//后台白名单,后台操作将不会拦截,添加"|"隔开白名单目录下面默认是网址带 admin  /dede/ 放行
$feitian_white_directory='admin|\/dede\/';
//url白名单,可以自定义添加url白名单,默认是对shuyang的后台url放行
//写法：比如phpcms 后台操作url index.php?app=admin php168的文章提交链接post.php?job=postnew&step=post ,dedecms 空间设置edit_space_info.php
$feitian_white_url = array('index.php' => 'app=admin','post.php' => 'job=postnew&step=post','edit_space_info.php'=>'');
if(shy_base::load_config('system','safe_off') == 1) {
	if(is_file($_SERVER['DOCUMENT_ROOT'].'/languages/safe.php')){
	    require_once($_SERVER['DOCUMENT_ROOT'].'/languages/safe.php');
	} 
}
//飞天系统防御框架结束
if(shy_base::load_config('system','gzip') && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}
class shy_base {	
	/**
	 * 初始化应用程序
	 */
	public static function creat_app() {
		return self::load_sys_class('application');
	}
	/**
	 * 加载系统类方法
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	public static function app_run($app=null,$controller = null,$view = null,$args = array()) {
		self::load_sys_class('crontab','',0);
		new crontab($app,$controller,$view);
	}	
	public static function load_sys_class($classname, $path = '', $initialize = 1) {
			return self::_load_class($classname, $path, $initialize);
	}
	
	/**
	 * 加载应用类方法
	 * @param string $classname 类名
	 * @param string $m 模块
	 * @param intger $initialize 是否初始化
	 */
	public static function load_app_class($classname, $m = '', $initialize = 1) {
		$m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
		if (empty($m)) return false;
		return self::_load_class($classname, 'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'classes', $initialize);
	}
	/**
	 * 加载数据模型
	 * @param string $classname 类名
	 */
	public static function load_model($classname) {
		return self::_load_class($classname,'model');
	}	
	/**
	 * 加载类文件函数
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	private static function _load_class($classname, $path = '', $initialize = 1) {
		static $classes = array();
		if (empty($path)) $path = 'libs'.DIRECTORY_SEPARATOR.'classes';
		$key = md5($path.$classname);
		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}
		if (file_exists(SHY_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php')) {
			include SHY_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php';
			$name = $classname;
			if ($my_path = self::my_path(SHY_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php')) {
				include $my_path;
				$name = 'EDI_'.$classname;
			}
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			return $classes[$key];
		} else {
			//return false;
			halt("无法加载模块:$classname");
		}
	}
	/**
	 * 加载系统的函数库
	 * @param string $func 函数库名
	 */
	public static function load_sys_func($func) {
		return self::_load_func($func);
	}
	
	/**
	 * 自动加载autoload目录下函数库
	 * @param string $func 函数库名
	 */
	public static function auto_load_func($path='') {
		return self::_auto_load_func($path);
	}
	
	/**
	 * 加载应用函数库
	 * @param string $func 函数库名
	 * @param string $m 模型名
	 */
	public static function load_app_func($func, $m = '') {
		$m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
		if (empty($m)) return false;
		return self::_load_func($func, 'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'functions');
	}
	
	/**
	 * 加载插件类库
	 */
	public static function load_plugin_class($classname, $identification = '' ,$initialize = 1) {
		$identification = empty($identification) && defined('PLUGIN_ID') ? PLUGIN_ID : $identification;
		if (empty($identification)) return false;
		return shy_base::load_sys_class($classname, 'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'classes', $initialize);
	}
	
	/**
	 * 加载插件函数库
	 * @param string $func 函数文件名称
	 * @param string $identification 插件标识
	 */
	public static function load_plugin_func($func,$identification) {
		static $funcs = array();
		$identification = empty($identification) && defined('PLUGIN_ID') ? PLUGIN_ID : $identification;
		if (empty($identification)) return false;
		$path = 'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'functions'.DIRECTORY_SEPARATOR.$func.'.func.php';
		$key = md5($path);
		if (isset($funcs[$key])) return true;
		if (file_exists(SHY_PATH.$path)) {
			include SHY_PATH.$path;
		} else {
			$funcs[$key] = false;
			return false;
		}
		$funcs[$key] = true;
		return true;
	}
	
	/**
	 * 加载插件数据模型
	 * @param string $classname 类名
	 */
	public static function load_plugin_model($classname,$identification) {
		$identification = empty($identification) && defined('PLUGIN_ID') ? PLUGIN_ID : $identification;
		$path = 'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'model';
		return self::_load_class($classname,$path);
	}
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _load_func($func, $path = '') {
		static $funcs = array();
		if (empty($path)) $path = 'libs'.DIRECTORY_SEPARATOR.'functions';
		$path .= DIRECTORY_SEPARATOR.$func.'.func.php';
		$key = md5($path);
		if (isset($funcs[$key])) return true;
		if (file_exists(SHY_PATH.$path)) {
			include SHY_PATH.$path;
		} else {
			$funcs[$key] = false;
			return false;
		}
		$funcs[$key] = true;
		return true;
	}
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _auto_load_func($path = '') {
		if (empty($path)) $path = 'libs'.DIRECTORY_SEPARATOR.'functions'.DIRECTORY_SEPARATOR.'autoload';
		$path .= DIRECTORY_SEPARATOR.'*.func.php';
		$auto_funcs = glob(SHY_PATH.DIRECTORY_SEPARATOR.$path);
		if(!empty($auto_funcs) && is_array($auto_funcs)) {
			foreach($auto_funcs as $func_path) {
				include $func_path;
			}
		}
	}
	/**
	 * 是否有自己的扩展文件
	 * @param string $filepath 路径
	 */
	public static function my_path($filepath) {
		$path = pathinfo($filepath);
		if (file_exists($path['dirname'].DIRECTORY_SEPARATOR.'EDI_'.$path['basename'])) {
			return $path['dirname'].DIRECTORY_SEPARATOR.'EDI_'.$path['basename'];
		} else {
			return false;
		}
	}

	/**
	 * 加载配置文件
	 * @param string $file 配置文件
	 * @param string $key  要获取的配置荐
	 * @param string $default  默认配置。当获取配置项目失败时该值发生作用。
	 * @param boolean $reload 强制重新加载。
	 */
	public static function load_config($file, $key = '', $default = '', $reload = false) {
		static $configs = array();
		if (!$reload && isset($configs[$file])) {
			if (empty($key)) {
				return $configs[$file];
			} elseif (isset($configs[$file][$key])) {
				return $configs[$file][$key];
			} else {
				return $default;
			}
		}
		$path = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.$file.'.php';
		if (file_exists($path)) {
			$configs[$file] = include $path;
		}
		if (empty($key)) {
			return $configs[$file];
		} elseif (isset($configs[$file][$key])) {
			return $configs[$file][$key];
		} else {
			return $default;
		}
	}	
}