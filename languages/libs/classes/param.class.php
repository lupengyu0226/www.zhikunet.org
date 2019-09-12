<?php
/**
 *  param.class.php	飞天系统参数处理类
 *
 * @copyright			(C) 2005-2014 EDI
 * @license				http://www.05273.cn/index.php?app=license
 * @lastmodify			2014-5-16
 */
class param {

	//路由配置
	private $route_config = '';
	
	public function __construct() {
		if(!get_magic_quotes_gpc()) {
			$_POST = new_addslashes($_POST);
			$_GET = new_addslashes($_GET);
			$_REQUEST = new_addslashes($_REQUEST);
			$_COOKIE = new_addslashes($_COOKIE);
		}

		$this->route_config = shy_base::load_config('route', SITE_URL) ? shy_base::load_config('route', SITE_URL) : shy_base::load_config('route', 'default');

		if(isset($this->route_config['data']['POST']) && is_array($this->route_config['data']['POST'])) {
			foreach($this->route_config['data']['POST'] as $_key => $_value) {
				if(!isset($_POST[$_key])) $_POST[$_key] = $_value;
			}
		}
		if(isset($this->route_config['data']['GET']) && is_array($this->route_config['data']['GET'])) {
			foreach($this->route_config['data']['GET'] as $_key => $_value) {
				if(!isset($_GET[$_key])) $_GET[$_key] = $_value;
			}
		}
		if(isset($_GET['page'])) {
			$_GET['page'] = max(intval($_GET['page']),1);
			$_GET['page'] = min($_GET['page'],1000000000);
		}
		return true;
	}

	/**
	 * 获取模型
	 */
	public function route_m() {
		$m = isset($_GET['app']) && !empty($_GET['app']) ? $_GET['app'] : (isset($_POST['app']) && !empty($_POST['app']) ? $_POST['app'] : '');
		$m = $this->safe_deal($m);
		if (empty($m)) {
			return $this->route_config['app'];
		} else {
			if(is_string($m)) return $m;
		}
	}

	/**
	 * 获取控制器
	 */
	public function route_c() {
		$c = isset($_GET['controller']) && !empty($_GET['controller']) ? $_GET['controller'] : (isset($_POST['controller']) && !empty($_POST['controller']) ? $_POST['controller'] : '');
		$c = $this->safe_deal($c);
		if (empty($c)) {
			return $this->route_config['controller'];
		} else {
			if(is_string($c)) return $c;
		}
	}

	/**
	 * 获取事件
	 */
	public function route_a() {
		$a = isset($_GET['view']) && !empty($_GET['view']) ? $_GET['view'] : (isset($_POST['view']) && !empty($_POST['view']) ? $_POST['view'] : '');
		$a = $this->safe_deal($a);
		if (empty($a)) {
			return $this->route_config['view'];
		} else {
			if(is_string($a)) return $a;
		}
	}

	/**
	 * 设置 cookie
	 * @param string $var     变量名
	 * @param string $value   变量值
	 * @param int $time    过期时间
	 */
	public static function set_cookie($var, $value = '', $time = 0) {
		$var_base = $var;
		$time = $time > 0 ? $time : ($value == '' ? SYS_TIME - 3600 : 0);
		//V($time);
		$s = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')|| ( isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 1 : 0;
		$httponly = ($var=='userid'||$var=='auth')?true:false;
		$var = shy_base::load_config('system','cookie_pre').$var;
        //$_COOKIE[$var] = $value;
        $_COOKIE[$var] = sys_auth($value, 'ENCODE', md5(SHY_PATH . 'cookie' . $var) . shy_base::load_config('system', 'auth_key'));
        if (is_array($value)) {
			foreach($value as $k=>$v) {
				setcookie($var.'['.$k.']', sys_auth($v, 'ENCODE', md5(SHY_PATH.'cookie'.$var).shy_base::load_config('system','auth_key')), $time, shy_base::load_config('system','cookie_path'), shy_base::load_config('system','cookie_domain'),$s,$httponly);
			}
			return true;
		} else {
        	if(in_array($var_base,['nickname','_nickname','_avatar'])){ //输出明文
		        return setcookie($var, $value, $time, shy_base::load_config('system','cookie_path'), shy_base::load_config('system','cookie_domain'), $s,$httponly);
	        }else{
		       return setcookie($var, sys_auth($value, 'ENCODE', md5(SHY_PATH.'cookie'.$var).shy_base::load_config('system','auth_key')), $time, shy_base::load_config('system','cookie_path'), shy_base::load_config('system','cookie_domain'), $s,$httponly);
	        }
		}
        //二次复制使之立即生效
	}

	/**
	 * 获取通过 set_cookie 设置的 cookie 变量 
	 * @param string $var 变量名
	 * @param string $default 默认值 
	 * @return mixed 成功则返回cookie 值，否则返回 false
	 */
	public static function get_cookie($var, $default = '') {
        $var_base = $var;
        $var = shy_base::load_config('system', 'cookie_pre') . $var;
        $value = isset($_COOKIE[$var]) ? sys_auth($_COOKIE[$var], 'DECODE', md5(SHY_PATH . 'cookie' . $var) . shy_base::load_config('system', 'auth_key')) : $default;
		if(in_array( $var_base,[ '_userid','userid','siteid','_groupid','_uid','_roleid' ] )) {
			$value = intval( $value );
		} elseif(in_array( $var_base,[ '_username','username','_email','_connectid','_from','admin_username','sys_lang' ] )) { //  site_model auth
			$value = safe_replace( $value );
		} elseif(in_array( $var_base,[ '_nickname','nickname','_avatar' ] )) {
			$value = safe_replace( isset( $_COOKIE[ $var ] ) ? $_COOKIE[ $var ] : $default );
		}
		return $value;
	}
	/**
	 * 安全处理函数
	 * 处理m,a,c
	 */
	private function safe_deal($str) {
		return str_replace(array('/', '.'), '', $str);
	}

}
?>