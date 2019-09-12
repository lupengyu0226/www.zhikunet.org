<?php
defined('IN_SHUYANG') or exit('No permission resources.');
 class space {
     private $times_db;
        public function init(){
		cache_page_start();
		$cuserid = $_GET['uid']?intval($_GET['uid']):$_userid;
		$cusername = $_GET['name']?addslashes(trim($_GET['name'])):$_username;//当前查看的个人空间会员用户名
		$cnickname = $_GET['nickname']?addslashes(trim($_GET['nickname'])):$_nickname;//空间主人的昵称
		$cmodel = $_GET['model']?addslashes(trim($_GET['model'])):news;//模型ID
		$CATEGORYS = getcache('category_content', 'commons');
		$siteid = intval($_GET['siteid']);
		if(!$siteid) $siteid = 1;
		$siteurl = siteurl($siteid);
		$space_name = get_memberinfo($cuserid, 'username');
		if(!$space_name){
		showmessage('该用户不存在！','','0');
		} else {
		$space_groupid = get_memberinfo($cuserid, 'groupid');
		$space_regtime = get_memberinfo($cuserid, 'regdate');
		$space_uid = get_memberinfo($cuserid, 'userid');
		$seo_keywords = '';
		$title = $space_name.'的个人主页';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		$urlrule = './'.$cmodel.'~./'.$cmodel.'_{$page}.html ';
		include template('member', 'space');
		cache_page(720);
		}
	  }

	public function index() {
		$seo_keywords = '沭阳专栏,沭阳网专栏';
		$title = '沭阳网专栏';
		//$cuserid = $username;
		//$space_name = get_memberinfo_buyusername($cuserid, 'userid');
		include template('member', 'space_index');
	}


 }
?>
