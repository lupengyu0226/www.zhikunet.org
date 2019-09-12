<?php 
	
	/**
	 * 模板风格列表
	 * @param integer $siteid 站点ID，获取单个站点可使用的模板风格列表
	 * @param integer $disable 是否显示停用的{1:是,0:否}
	 */
	function template_list($siteid = '', $disable = 0) {
		$list = glob(SHY_PATH.'templates'.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
		$arr = $template = array();
		if ($siteid) {
			$site = shy_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			if($info['template']) $template = explode(',', $info['template']);
		}
		foreach ($list as $key=>$v) {
			$dirname = basename($v);
			if ($siteid && !in_array($dirname, $template)) continue;
			if (file_exists($v.DIRECTORY_SEPARATOR.'config.php')) {
				$arr[$key] = include $v.DIRECTORY_SEPARATOR.'config.php';
				if (!$disable && isset($arr[$key]['disable']) && $arr[$key]['disable'] == 1) {
					unset($arr[$key]);
					continue;
				}
			} else {
				$arr[$key]['name'] = $dirname;
			}
			$arr[$key]['dirname']=$dirname;
		}
		return $arr;
	}
	/**
	 * 设置config文件
	 * @param $config 配属信息
	 * @param $filename 要配置的文件名称
	 */
	function set_config($config, $filename="system") {
		$configfile = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.$filename.'.php';
		if(!is_writable($configfile)) showmessage('Please chmod '.$configfile.' to 0777 !');
		$pattern = $replacement = array();
		foreach($config as $k=>$v) {
			if(in_array($k,array('js_path','css_path','festival_off','festival_url','img_path','passport_path','js_version','css_version','shy_version','pagecount_cron','shy_release','attachment_stat','admin_log','gzip','debug','delpanel','errorlog','phpsso','phpsso_appid','phpsso_api_url','phpsso_auth_key','phpsso_version','safe_model','safe_off','logo_model','connect_enable', 'upload_url','sina_akey', 'sina_skey','qq_appid','qq_appkey','qq_callback','wap_qq_callback','xzh_appid','xzh_appkey','xzh_callback','wap_xzh_callback','wx_appid','wx_appkey','wx_callback','admin_url'))) {
				$v = trim($v);
				$configs[$k] = $v;
				$pattern[$k] = "/'".$k."'\s*=>\s*([']?)[^']*([']?)(\s*),/is";
	        	$replacement[$k] = "'".$k."' => \${1}".$v."\${2}\${3},";					
			}
		}
		$str = file_get_contents($configfile);
		$str = preg_replace($pattern, $replacement, $str);
		return shy_base::load_config('system','lock_ex') ? file_put_contents($configfile, $str, LOCK_EX) : file_put_contents($configfile, $str);		
	}
	
	/**
	 * 获取系统信息
	 */
	function get_sysinfo() {
		$sys_info['os']             = PHP_OS;
		$sys_info['zlib']           = function_exists('gzclose');//zlib
		$sys_info['safe_mode']      = (boolean) ini_get('safe_mode');//safe_mode = Off
		$sys_info['safe_mode_gid']  = (boolean) ini_get('safe_mode_gid');//safe_mode_gid = Off
		$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : L('no_setting');
		$sys_info['socket']         = function_exists('fsockopen') ;
		$sys_info['web_server']     = strpos($_SERVER['SERVER_SOFTWARE'], 'PHP')===false ? $_SERVER['SERVER_SOFTWARE'].'PHP/'.phpversion() : $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv']           = phpversion();	
		$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
		return $sys_info;
	}
	
	/**
	 * 检查目录可写性
	 * @param $dir 目录路径
	 */
	function dir_writeable($dir) {
		$writeable = 0;
		if(is_dir($dir)) {  
	        if($fp = @fopen("$dir/chkdir.test", 'w')) {
	            @fclose($fp);      
	            @unlink("$dir/chkdir.test"); 
	            $writeable = 1;
	        } else {
	            $writeable = 0; 
	        } 
		}
		return $writeable;
	}
    function sphinx_adddate($inputtime) {
	$input_now=time();
	$inputtime = strtotime($inputtime);
	$input_time = $input_now-$inputtime;
	$input_hour = (int)($input_time/(60*60));    //小时
	$input_day = (int)($input_time/(60*60*24));  //天
	$input_min = (int)($input_time%(60*60)/60);  //分钟
	$input_week = (int)($input_time/(7*24*60*60));  //星期
	$input_moon = (int)($input_time/(30*24*60*60));  //月份
    if ($input_time < 300) {
		return '刚刚';
	} elseif ($input_hour < 1) {
		return $input_min.'分钟前';
	} elseif ($input_hour < 24 && $input_hour >= 1) {
		return $input_hour.'小时前';
	} elseif ($input_hour >= 24 && $input_day <= 7) {
		return $input_day.'天前';
	} elseif ($input_day > 7 && $input_day <= 30) {
		return $input_week.'个星期前';
	} elseif ($input_day > 30 && $input_day <= 365) {
		return $input_moon.'个月前';
	} else {
		return date('Y-m-d',$inputtime);
	}
}
	/**
	 * 返回错误日志大小，单位MB
	 */
	function errorlog_size() {
		$logfile = CACHE_PATH.'error_log.php';
		if(file_exists($logfile)) {
			return $logsize = shy_base::load_config('system','errorlog') ? round(filesize($logfile) / 1048576 * 100) / 100 : 0;
		} 
		return 0;
	}

?>
