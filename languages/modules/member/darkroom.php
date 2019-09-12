<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class darkroom {
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
		$urlrule = '/darkroom.html~/darkroom_{$page}.html';
		include template('member', 'darkroom');
		cache_page(3600);
		}
        public function shuyang(){
		$cuserid = $_GET['uid']?intval($_GET['uid']):$_userid;
		$cusername = $_GET['name']?addslashes(trim($_GET['name'])):$_username;//当前查看的个人空间会员用户名
		$cnickname = $_GET['nickname']?addslashes(trim($_GET['nickname'])):$_nickname;//空间主人的昵称
		$space_name = get_memberinfo($cuserid, 'username');
		$space_nickname = get_memberinfo($cuserid, 'nickname');
		$space_regip = get_memberinfo($cuserid, 'regip');
		$space_yuanyin = get_memberinfo($cuserid, 'yuanyin');
		if(!$space_name){
		showmessage('该用户不存在！','','0');
		} else {
		$space_groupid = get_memberinfo($cuserid, 'groupid');
		$space_regtime = get_memberinfo($cuserid, 'regdate');
		$seo_keywords = '';
		$title = $space_name.'的个人主页';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		//$urlrule = './'.$cmodel.'~./'.$cmodel.'_{$page}.html ';
		include template('member', 'darkroomid');
		}
	  }
}
?>
