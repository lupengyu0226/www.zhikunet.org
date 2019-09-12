<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
shy_base::load_app_func('util');
shy_base::load_app_func('global');
class today {
	private $db;
	function __construct() {
		$this->db = shy_base::load_model('content_model');
		$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');
		$this->_groupid = param::get_cookie('_groupid');
		$this->siteid = isset($_GET['siteid']) && (intval($_GET['siteid']) > 0) ? intval(trim($_GET['siteid'])) : (param::get_cookie('siteid') ? param::get_cookie('siteid') : 1);
		param::set_cookie('siteid',$this->siteid);	
		$this->mobile_site = getcache('mobile_site','mobile');
		$this->mobile = $this->mobile_site[$this->siteid];
		define('MOBILE_SITEURL', $this->mobile['domain'] ? $this->mobile['domain'].'/' : APP_PATH.'index.php?app=mobile&siteid='.$this->siteid);
		if($this->mobile['status']!=1) mobilemsg(L('mobile_close_status'));
	}
	//首页
	public function init() {
		$this->weixin = shy_base::load_app_class('wxauth', 'mobile');
		$wxcofig=$this->weixin->get_sign();
		$MOBILE = $this->mobile;
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$siteid = $GLOBALS['siteid'] = max($siteid,1);
		define('SITEID', $siteid);
		$_userid = $this->_userid;
		$_username = $this->_username;
		$_groupid = $this->_groupid;
		//SEO
		$SEO = seo($siteid);
		$sitelist  = getcache('sitelist','commons');
		$default_style = $sitelist[$siteid]['default_style'];
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		$urlrule = '/today.'.'html'.'~/today_{$page}.'.'html'.'';
		include template('mobile','today',$default_style);
	}
}
?>
