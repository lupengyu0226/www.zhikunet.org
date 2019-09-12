<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('model', '', 0);
class press_model extends model {
	function __construct() {
		$this->db_config = shy_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'press';
		$this->_username = param::get_cookie('_username');
		$this->_userid = param::get_cookie('_userid');
		parent::__construct();
	}
	
	/**
	 * 
	 * 检查当前用户积分是否足够
	 * @param  $userid 用户ID
	 */
	public function presscheck($userid){
		$member_arr = get_memberinfo($this->_userid);
		$groups = getcache('grouplist','member');
 		if($groups[$member_arr['groupid']]['allowsendpress']==0){
			showpress('对不起你没有权限发短消息',HTTP_REFERER);
		}else {
			//判断是否到限定条数
			$num = $this->get_memberpress($this->_username);
			if($num>=$groups[$member_arr['groupid']]['allowpress']){
				showpress('你的短消息条数已达最大值!',HTTP_REFERER);
			}
		}
	}
	
	public function add_press($username,$userid,$title,$url,$content) {
			$press = array ();
			$press['siteid'] = '1';
			$press['username'] = $username;
			$press['userid'] = $userid;
			$press['title'] = $title;
			$press['url'] = $url;
			$press['content'] = $content;
			$press['passed'] = '0';
			$press['addtime'] = SYS_TIME;

			if($press['username']==""){
				$press['username'] = $this->_username;
			}
			if(empty($press['url'])){
				showpress('稿件地址不能为空！',HTTP_REFERER);
			}
			
			$id = $this->insert($press,true);
			if(!$id){
				return FALSE;
			}else {
				return true;
			}
	}
	
}
?>
