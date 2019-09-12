<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	function __construct() {
		shy_base::load_app_func('global');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
	}
	
	public function init() {
		$siteid = SITEID;
 		if(isset($_POST['dosubmit'])){
 			if($_POST['name']==""){
 				showmessage(L('sitename_noempty'),"phone.shtml");
 			}
 			if($_POST['url']==""){
 				showmessage(L('siteurl_not_empty'),"phone.shtml");
 			}
			if($_POST['username']==""){
 				showmessage(L('username_not_empty'),"phone.shtml");
 			}
			if($_POST['introduce']==""){
 				showmessage(L('jieshao_not_empty'),"phone.shtml");
 			}
 			$phone_db = shy_base::load_model('phone_model');
			$name = safe_replace(strip_tags($_POST['name']));
			$url = safe_replace(strip_tags($_POST['url']));
			$username = safe_replace(strip_tags($_POST['username']));
			$introduce = safe_replace(strip_tags($_POST['introduce']));
			$url = trim_script($url);
 			$sql = array('siteid'=>$siteid,'name'=>$name,'url'=>$url,'username'=>$username,'introduce'=>$introduce);
 			$phone_db->insert($sql);
 			showmessage(L('add_success'), "phone.shtml");
 		} else {
  			$setting = getcache('phone', 'commons');
			$setting = $setting[$siteid];
 			if($setting['is_post']=='0'){
 				showmessage(L('suspend_application'), HTTP_REFERER);
 			}
 			$this->type = shy_base::load_model('type_model');
 			$types = $this->type->get_types($siteid);//获取站点下所有便民电话分类
			shy_base::load_sys_class('form', '', 0);
			$SEO = seo(SITEID, '', $subject, $description, $subject);
			$title='便民电话申请';
			$description='为大家提供便民电话首页展示!';
			$keywords='沭阳便民电话,便民电话申请';
			$SEO = seo($siteid,0, $title, $description, $keywords);
   			include template('phone', 'register');
 		}
	}
 	
}
?>