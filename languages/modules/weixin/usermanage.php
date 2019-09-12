<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class usermanage extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->dbmenuevent= shy_base::load_model('weixin_menuevent_model');
		$this->dbmember= shy_base::load_model('weixin_member_model');
		$this->dbmember_group= shy_base::load_model('weixin_member_group_model');
		$this->dbsent_group_news= shy_base::load_model('weixin_sent_group_news_model');
		$this->dbkeyword = shy_base::load_model('weixin_replykeyword_model');
		$this->dbarticle = shy_base::load_model('weixin_article_model');
		shy_base::load_app_func('global','weixin');
	}	
	public function init() {
		$big_menu = array('javascript:;', L('用户管理'));
		$sql =  "";
		if(isset($_GET['dosubmit'])&& $_GET['nickname']!=''){
		$nickname = $_GET['nickname'];//栏目ID
		$sql .= $sql."`nickname` like '%$nickname%' AND `subscribe`=1";
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$userinfos =$this->dbmember->listinfo($sql,'subscribe_time DESC',$page, 20);
		$pages = $this->dbmember->pages;
		}else{
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$userinfos =$this->dbmember->listinfo(array('subscribe'=>1),'subscribe_time DESC',$page, 20);
		$pages = $this->dbmember->pages;
		}
		foreach($userinfos as $k=>$v){
			$info = $this->dbmember_group->get_one(array('id'=>$v['groupid']));
			$v['name'] = $info['name'];
			$infos[]=$v;
		}
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$dayBegin = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
		$dayEnd = mktime(23,59,59,$month,$day,$year);//当天结束时间戳
		$subscribe_time;
		$where = "subscribe_time<$dayEnd AND subscribe_time>$dayBegin AND subscribe=1";
		$newsusersnembers=$this->dbmember->count($where);
		$cancelusersnembers=$this->dbmember->count(array('subscribe'=>0));	
		$usernembers=$this->dbmember->count(array('subscribe'=>1));	
		$grouplist =$this->dbmember_group->listinfo();	
		$access_token = get_xzh_token();
		if($access_token){
		$url="https://openapi.baidu.com/rest/2.0/cambrian/datacube/getusersummary?date=".date("Y-m-d",strtotime("-1 day"))."&access_token=".$access_token;
		$result = https_request($url);
		$xzhuser=json_decode($result, true); 
		}
		$wxaccess_token = get_access_token();
		$json_user_message=array('begin_date'=>date("Y-m-d",strtotime("-1 day")),'end_date'=>date("Y-m-d",strtotime("-1 day")));
		$jsondata=JSON($json_user_message);
		if($wxaccess_token){
		$wxurl="https://api.weixin.qq.com/datacube/getusersummary?&access_token=".$wxaccess_token;
		$wxzongurl="https://api.weixin.qq.com/datacube/getusercumulate?&access_token=".$wxaccess_token;
		$wxresult = https_request($wxurl,$jsondata);
		$wxz = https_request($wxzongurl,$jsondata);
		$wxuser=json_decode($wxresult, true);
		$wxzong=json_decode($wxz, true);
		}
		include $this->admin_tpl('weixin_user_list');
	}
	public function groupmanage(){
		$grouplists =$this->dbmember_group->listinfo();	
		$big_menu = array('javascript:window.top.art.dialog({id:\'addusergroup\',iframe:\'?app=weixin&controller=usermanage&view=addusergroup\', title:\''.L('weixin_user_addgroup').'\', width:\'400\', height:\'250\'}, function(){var d = window.top.art.dialog({id:\'addusergroup\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'addusergroup\'}).close()});void(0);', L('weixin_user_addgroup'));
		
		include $this->admin_tpl('weixin_group_list');
	}
	public function groupupdate() {
		if(isset($_POST['dosubmit'])) {
		$group_data=get_group_arr();
		
		foreach((array)$group_data as $v){
			$v['updatetime'] = SYS_TIME;
			$v['siteid'] = $this->get_siteid();
			$resultid = $this->dbmember_group->get_one(array('id'=>$v['id']));
			$this->dbmember_group->update($v,array('id'=>$v['id']));
			if(!$resultid){
			$v['inputtime'] = SYS_TIME;
			$this->dbmember_group->insert($v,true);
			}
		}
		
		showmessage(L("operation_success"),HTTP_REFERER);
		}
		
	}
	public function move(){
		if(isset($_POST['dosubmit'])) {
			if(!isset($_POST['id']) || empty($_POST['id'])) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		    }
			$groupid = intval($_POST['groupid']);//从下拉菜单获取
			foreach($_POST['id'] as $id) {
 				$info = $this->dbmember->get_one(array('userid'=>$id));	
				if($info['status']==0) continue; // 当status为0时，跳出本次循环				
				$openid = $info['openid'];
				$openid = rtrim($openid,"\@");
				$access_token = get_access_token();	
				if($access_token){				
				  $url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=".$access_token;
				  $arr_data=array('openid'=>$openid,'to_groupid'=>$groupid);
				  $arr_data=array_iconv($arr_data, $input = 'gbk', $output = 'utf-8');//20141210
				  $json_data=JSON($arr_data);
				  $result = https_request($url,$json_data);
				  $result_arr=json_decode($result,true);
				  if($result_arr['errcode']==0){
					$this->dbmember->update(array('groupid'=>$groupid),array('userid'=>$id));
				  }
				  $result_errcode[] = $result_arr['errcode'];
				}
			}
				$result_unique = array_unique($result_errcode);
				if(count($result_unique)==1){
				  showmessage(L('operation_success'),HTTP_REFERER);
				}else{
					showmessage(L("operation_failure"),HTTP_REFERER);
					}		
			
		}
	}
	public function details() {
 		$id = intval($_GET['id']);
		$infos = $this->dbmember->get_one(array('userid'=>$id));
		include $this->admin_tpl('weixin_user_details');
	}
	public function news_users() {
		//今天新增用户
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$dayBegin = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
		$dayEnd = mktime(23,59,59,$month,$day,$year);//当天结束时间戳
		$subscribe_time;
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$where = "subscribe_time<$dayEnd AND subscribe_time>$dayBegin AND subscribe=1";
		$todayuserinfos =$this->dbmember->listinfo($where,'',$page, 20);
		$pages = $this->dbmember->pages;
		foreach($todayuserinfos as $tk=>$tv){
			$tinfo = $this->dbmember_group->get_one(array('id'=>$tv['groupid']));
			$tv['name'] = $tinfo['name'];
			$tinfos[]=$tv;
		}
		$grouplist =$this->dbmember_group->listinfo();	
		//用户总数
		$usernembers=$this->dbmember->count($where);	
		include $this->admin_tpl('weixin_user_news');
	}
	public function cancel_users() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$nouserinfos =$this->dbmember->listinfo(array('subscribe'=>0),'subscribe_time DESC',$page, 20);
		$usernembers=$this->dbmember->count(array('subscribe'=>0));	
		$pages = $this->dbmember->pages;
		include $this->admin_tpl('weixin_user_cancel');
	}
	//向用户发送消息(文本消息)
	public function sent_user_message(){
		$openid = trim($_GET['openid']);
		$openid = rtrim($openid,"\@");
		$content = trim($_GET['content']);
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['message']['content'])) {
				showmessage(L('亲，内容不能为空'),HTTP_REFERER);
			} else {
				$content = safe_replace($_POST['message']['content']);
			}	
			$jsonmessage=array();
		    $json_user_message=array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>$content));
		    $jsondata=JSON($json_user_message);
			$access_token = get_access_token();
			if($access_token){
			$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			if($arr_result['errcode']==0){
			  showmessage(L('operation_success'),'?app=weixin&controller=usermanage&view=sent_user_message','', 'sent_user_message');
			}else{
				 echo globalreturncode($arr_result['errcode']);
				}
			}
		}
         include $this->admin_tpl('weixin_addusermessage');
	}
	//向用户发送图文消息
	public function sent_news(){
		$openid = trim($_GET['openid']);
		$openid = rtrim($openid,"\@");
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['weixin']['content']&&$_POST['weixin']['title']&&$_POST['weixin']['picurl']&&$_POST['weixin']['url'])) {
				showmessage(L('亲，标题,内容和图片,链接都不能为空'),HTTP_REFERER);
			} else {
			$article[] = array(
				  'title'=>$_POST['weixin']['title'],
				  'description'=>$_POST['weixin']['content'],
				  'url'=>$_POST['weixin']['url'],
				  'picurl'=>$_POST['weixin']['picurl']
				  );
			}	
			$jsonmessage=array();
			$array_message=array(
				  'touser'=>$openid,
				  'msgtype'=>'news',
					'news'=>array(
					  'articles'=>$article
				      )
				);
			$jsondata=JSON($array_message);
			$access_token = get_access_token();
			if($access_token){
			$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$arr_result=json_decode($result, true); 
			if($arr_result['errcode']==0){
			  showmessage(L('operation_success'),'?app=weixin&controller=usermanage&view=sent_news','', 'sent_news');
			}else{
				 echo globalreturncode($arr_result['errcode']);
				}
			}
		}
		 shy_base::load_sys_class('form', '', 0);
         include $this->admin_tpl('weixin_user_addnews');
	}
	//向熊掌号用户发送消息(文本消息)
	public function sent_xzh_message(){
		$openid = trim($_GET['openid']);
		$content = trim($_GET['content']);
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['message']['content'])) {
				showmessage(L('亲，内容不能为空'),HTTP_REFERER);
			} else {
				$content = safe_replace($_POST['message']['content']);
			}	
			$jsonmessage=array();
		    $json_user_message=array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>$content));
		    $jsondata=JSON($json_user_message);
			$access_token = get_xzh_token();
			if($access_token){
			$url="https://openapi.baidu.com/rest/2.0/cambrian/message/custom_send?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			if($arr_result['errcode']==0){
			  showmessage(L('operation_success'),'?app=weixin&controller=usermanage&view=sent_xzh_message','', 'sent_xzh_message');
			}else{
				 echo globalreturncode($arr_result['errcode']);
				}
			}
		}
         include $this->admin_tpl('weixin_addxzhmessage');
	}
	//向熊掌号用户发送图文消息
	public function sent_xzh_news(){
		$openid = trim($_GET['openid']);
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['weixin']['content']&&$_POST['weixin']['title']&&$_POST['weixin']['url'])) {
				showmessage(L('亲，标题,内容和图片,链接都不能为空'),HTTP_REFERER);
			} else {
			$article[] = array(
				  'title'=>$_POST['weixin']['title'],
				  'description'=>$_POST['weixin']['content'],
				  'url'=>$_POST['weixin']['url'],
				  'picurl'=>"https://cambrian-images.cdn.bcebos.com/03e0ed1ba3ad56c71974fa15c4d8c3ca.jpeg"
				  );
			}	
			$jsonmessage=array();
			$array_message=array(
				  'touser'=>$openid,
				  'msgtype'=>'news',
					'news'=>array(
					  'articles'=>$article
				      )
				);
			$jsondata=JSON($array_message);
			$access_token = get_xzh_token();
			if($access_token){
			$url="https://openapi.baidu.com/rest/2.0/cambrian/message/custom_send?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$arr_result=json_decode($result, true); 
			if($arr_result['errcode']==0){
			  showmessage(L('operation_success'),'?app=weixin&controller=usermanage&view=sent_xzh_news','', 'sent_xzh_news');
			}else{
				 echo globalreturncode($arr_result['errcode']);
				}
			}
		}
		 shy_base::load_sys_class('form', '', 0);
         include $this->admin_tpl('weixin_xzh_addnews');
	}
	public function addusergroup(){
	
		if(isset($_POST['dosubmit'])) {

			$_POST['group']['inputtime'] = SYS_TIME;
			$_POST['group']['updatetime'] = SYS_TIME;
			$_POST['group']['siteid'] = $this->get_siteid();
			if(empty($_POST['group']['name'])) {
				showmessage(L("operation_failure"),HTTP_REFERER);
			} else {
				$_POST['group']['name'] = safe_replace($_POST['group']['name']);
			}
			
			$data = new_addslashes($_POST['group']);
			$resultid = $this->dbmember_group->insert($data,true);
			
			if(!$resultid) return FALSE; 
	
			$jsongroup=array();
		    $jsongroup['group']=array('name'=>$_POST['group']['name']);
			
		    $jsondata=JSON($jsongroup);
			
			$access_token = get_access_token();
			if($access_token){
			//创建分组
			$url="https://api.weixin.qq.com/cgi-bin/groups/create?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$result_arr=json_decode($result,true);
			$result_update = $this->dbmember_group->update(array('id'=>$result_arr['group']['id']),array('groupid'=>$resultid));
			if(!$result_update) return FALSE; 
			
				showmessage(L("operation_success"),'?app=weixin&controller=usermanage&view=addusergroup','', 'addusergroup');
			
			}
			
			
		}else{
		
		include $this->admin_tpl('weixin_add_usergroup');
		}
	}
	
	//修改分组名称
 	public function editgroup() {
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
 		$id = intval($_GET['id']);//微信分组的id
		$name = trim($_GET['name']);

		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['group']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$groupname = safe_replace($_POST['group']['name']);
				$id = intval($_POST['group']['id']);
			}
			$result_update = $this->dbmember_group->update(array('name'=>$groupname),array('id'=>$id));	
			
			if(!$result_update){
				showmessage(L("operation_success"),HTTP_REFERER);
			}	
			$jsongroup=array();
		    $jsongroup['group']=array('id'=>$id,'name'=>$groupname);
			
		    $jsondata=JSON($jsongroup);
			
			$access_token = get_access_token();
			if($access_token){
			$url="https://api.weixin.qq.com/cgi-bin/groups/update?access_token=".$access_token;
			$result = https_request($url,$jsondata);
			$arr_result=json_decode($result, true); 
			if($arr_result['errcode']==0 && $arr_result['errmsg']=='ok'){
			  showmessage(L('operation_success'),'?app=weixin&controller=usermanage&view=editgroup','', 'editgroup');
			}else{
				showmessage(L("operation_failure"),HTTP_REFERER);
				}
			
			}

		}
		
		include $this->admin_tpl('weixin_editgroup');
	}
}
?>
