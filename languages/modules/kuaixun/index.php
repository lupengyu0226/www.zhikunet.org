<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	function __construct() {
		shy_base::load_app_func('global');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}
	
	public function init() {
		cache_page_start();
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$kuaixun_setting = getcache('kuaixun', 'commons');
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
		$urlrule = '/kuaixun.'.html.'~/kuaixun_{$page}.'.html.'';
		include template('kuaixun','index',$default_style);
		cache_page(120);
	} 	
}
?>
