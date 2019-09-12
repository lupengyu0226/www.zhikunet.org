<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class reply extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->db = shy_base::load_model('weixin_replykeyword_model');
		$this->dbmenuevent = shy_base::load_model('weixin_menuevent_model');
		$this->dbarticle = shy_base::load_model('weixin_article_model');
		shy_base::load_app_func('global','weixin');
		$this->newsdb = shy_base::load_model('news_model');
		$this->url = shy_base::load_app_class('url', 'content');
	}
	public function init() {
		if($_GET['dosubmit']&&isset($_GET['keyword'])){
			$q=trim($_GET['keyword']);
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		if($q==''){
			$where='';
		}else{
			$where = " `keyword` LIKE '%$q%' ";
		}
		$infos =$this->db->listinfo($where,'id DESC',$page, $pagesize = '15');
		$pages = $this->db->pages;
		$thumb = '<img src="'.IMG_PATH.'icon/small_img.gif" style="padding-bottom:2px" \'">';
		$warning='<img src="'.IMG_PATH.'icon/exclamation_small.png" style="padding-bottom:2px" \'">';
		$big_menu = array('javascript:window.top.art.dialog({id:\'addkeyword\',iframe:\'?app=weixin&controller=reply&view=addkeyword\', title:\''.L('weixin_reply_addkeyword').'\', width:\'1000\', height:\'600\'}, function(){var d = window.top.art.dialog({id:\'addkeyword\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'addkeyword\'}).close()});void(0);', L('weixin_reply_addkeyword'));
		include $this->admin_tpl('weixin_reply_keywordsmanage');
	}
	public function addkeyword(){
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['inputtime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			if($_POST['weixin']['keyword']=='') {
				showmessage(L("operation_failure"),HTTP_REFERER);
			} else {
				$_POST['weixin']['keyword'] = trim($_POST['weixin']['keyword']);
			}
			
			$replyid = $this->db->insert(
			array(
			'siteid'=>$_POST['weixin']['siteid'],
			'keyword'=>$_POST['weixin']['keyword'],
			'type'=>1,
			'num'=>1,
			'inputtime'=>$_POST['weixin']['inputtime'],
			'updatetime'=>$_POST['weixin']['updatetime'],
			),
			true
			);
			unset($_POST['weixin']['keyword']);
			$_POST['weixin']['replyid'] =$replyid;
			$_POST['weixin']['default'] =1;
			$data =$_POST['weixin'];
			$resultid = $this->dbarticle->insert($data,true);
			$siteid=$this->get_siteid()?$this->get_siteid():1;
			$url = MOBILE_PATH.'weixin_'.$resultid.'.html';
			$resultid = $this->dbarticle->update(array('url'=>$url),array('id'=>$resultid));
			if(!$resultid) return FALSE; 
 			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=addkeyword','', 'addkeyword');
		}
		include $this->admin_tpl('weixin_reply_addkeyword');
		}
	//绑定栏目
	public function bandingcat(){
		if(isset($_POST['dosubmit'])) {
			$catid = intval($_POST['catid']);
			if(empty($_POST['weixin']['keyword'])) {
				showmessage(L("关键词不能为空"),HTTP_REFERER);
			} 
			$keyword=trim($_POST['weixin']['keyword']);
			if(empty($catid)) {
				showmessage(L("请选择栏目"),HTTP_REFERER);
			} 
			if($_POST['num']==''){
				$num=$_POST['num']=5;
			}else{
				$num=intval($_POST['num']);
			}
			if($_POST['weixin']['picurl']==''){
				$picurl='http://statics.05273.cn/images/weixinico.png';
			}else{
				$picurl=trim($_POST['weixin']['picurl']);
			}
			if($_POST['weixin']['url']==''){
				$siteid=$this->get_siteid()?$this->get_siteid():1;
				$url =MOBILE_PATH.'list-'.$catid.'-1.html';
			}else{
				$url=trim($_POST['weixin']['url']);
			}
			$resultid = $this->db->insert(
			array(
			'siteid'=>$siteid,
			'keyword'=>$keyword,
			'type'=>5,
			'catid'=>$catid,
			'num'=>$num,
			'name'=>trim($_POST['weixin']['name']),
			'url'=>$url,
			'picurl'=>$picurl,
			'inputtime'=>SYS_TIME,
			'updatetime'=>SYS_TIME,
			),
			true
			);
			if(!$resultid) return FALSE; 
 			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=addkeyword','', 'addkeyword');
		}
		include $this->admin_tpl('weixin_reply_bandingcat');
	}
	public function editbandingcat(){
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
		$id = intval($_GET['id']);
		$infos = $this->db->get_one(array('id'=>$id));
		if(isset($_POST['dosubmit'])) {
			$catid = intval($_POST['catid']);
			if(empty($_POST['weixin']['keyword'])) {
				showmessage(L("关键词不能为空"),HTTP_REFERER);
			} 
			$keyword=trim($_POST['weixin']['keyword']);
			if(empty($catid)) {
				showmessage(L("请选择栏目"),HTTP_REFERER);
			} 
			if($_POST['num']==''){
				$num=$_POST['num']=5;
			}else{
				$num=intval($_POST['num']);
			}
			if($_POST['weixin']['picurl']==''){
				$picurl='http://statics.05273.cn/images/weixinico.png';
			}else{
				$picurl=trim($_POST['weixin']['picurl']);
			}
			if($_POST['weixin']['url']==''){
				$url =MOBILE_PATH.'list-'.$catid.'-1.html';
			}else{
				$url=trim($_POST['weixin']['url']);
			}
			$resultid = $this->db->update(
			array(
			'keyword'=>$keyword,
			'catid'=>$catid,
			'num'=>$num,
			'name'=>trim($_POST['weixin']['name']),
			'picurl'=>$picurl,
			'url'=>$url,
			'updatetime'=>SYS_TIME,
			),
			array('id'=>$id)
			);
			if(!$resultid) return FALSE; 
 			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=editbandingcat','', 'editbandingcat');
		}
		include $this->admin_tpl('weixin_reply_editbandingcat');
	}
	
	//修改关键词
 	public function editkeyword() {
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
 		$id = intval($_GET['id']);
		$infos = $this->db->get_one(array('id'=>$id));
		$lists =$this->dbarticle->listinfo(array('replyid'=>$id));	
        $arinfos = $this->dbarticle->get_one(array('replyid'=>$id,'default'=>1));
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			if($_POST['weixin']['keyword']=='') {
				showmessage(L("operation_failure"),HTTP_REFERER);
			} else {
				$_POST['weixin']['keyword'] = safe_replace($_POST['weixin']['keyword']);
			}
			$_POST['weixin']['keyword'] = new_addslashes($_POST['weixin']['keyword']);
			$resultid=$this->db->update(array('keyword'=>$_POST['weixin']['keyword'],'updatetime'=>SYS_TIME),array('id'=>$id));	
			unset($_POST['weixin']['keyword']);
			$_POST['weixin']['replyid'] =$id;
			$_POST['weixin']['default'] =1;
			$data =$_POST['weixin'];
			$resultid = $this->dbarticle->update($data,array('replyid'=>$id,'default'=>1));
			$this->dbarticle->update(array('url'=>$_POST['weixin']['url']),array('id'=>$resultid));
			if(!$resultid) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=editkeyword','', 'editkeyword');
		}
		$thumb = '<img src="'.IMG_PATH.'icon/small_img.gif" style="padding-bottom:2px" \'">';
		$warning='<img src="'.IMG_PATH.'icon/exclamation_small.png" style="padding-bottom:2px" \'">';
		include $this->admin_tpl('weixin_reply_editkeyword');
	}	
	public function editkeyword2() {
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
 		$id = intval($_GET['id']);
		$infos = $this->db->get_one(array('id'=>$id));
        $arinfos = $this->dbarticle->get_one(array('replyid'=>$id,'default'=>1));
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			if(empty($_POST['weixin']['keyword'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['weixin']['keyword'] = safe_replace($_POST['weixin']['keyword']);
			}
			$_POST['weixin']['keyword'] = new_addslashes($_POST['weixin']['keyword']);
			$resultid=$this->db->update(array('keyword'=>$_POST['weixin']['keyword'],'updatetime'=>SYS_TIME),array('id'=>$id));	
			unset($_POST['weixin']['keyword']);
			$_POST['weixin']['replyid'] =$id;
			$_POST['weixin']['default'] =1;
			$data =$_POST['weixin'];
			$resultid = $this->dbarticle->update($data,array('replyid'=>$id,'default'=>1));
			$this->dbarticle->update(array('url'=>$_POST['weixin']['url']),array('id'=>$resultid));		
			if(!$resultid) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=editkeyword','', 'editkeyword');
		}
		include $this->admin_tpl('weixin_reply_editkeyword');
	}
	public function addarticle(){
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
		$id = intval($_GET['id']);
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['inputtime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			if(empty($_POST['weixin']['title'])) {
				showmessage(L("operation_failure"),HTTP_REFERER);
			}
			$data =$_POST['weixin'];
			$resultid = $this->dbarticle->insert($data,true);
			if($resultid){
				$info=$this->dbarticle->get_one(array('id'=>$resultid));
				$num=$this->dbarticle->count(array('replyid'=>$info['replyid']));
				$this->db->update(array('num'=>$num),array('id'=>$info['replyid']));	
				$siteid=$this->get_siteid()?$this->get_siteid():1;
				$url = MOBILE_PATH.'weixin_'.$resultid.'.html';
				$this->dbarticle->update(array('url'=>$url),array('id'=>$resultid));
				showmessage(L('operation_success'),'?app=weixin&controller=reply&view=editkeyword','', 'editkeyword');
			}else{
				return FALSE;
			}
		}
		include $this->admin_tpl('weixin_reply_addarticle');
	}
	//修改关键词
 	public function editarticle() {
 		$id = intval($_GET['id']);
		$replyid = intval($_GET['replyid']);
		$infos = $this->dbarticle->get_one(array('id'=>$id));
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			$data =$_POST['weixin'];
			$id=$this->dbarticle->update($data,array('id'=>$id));			
			if(!$id) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=editkeyword','', 'editkeyword');			
		}		
		include $this->admin_tpl('weixin_reply_editarticle');
	}
	public function articlemanage(){
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}		
		$replyid = intval($_GET['id']);
		$lists =$this->dbarticle->listinfo(array('replyid'=>$replyid));	
		$thumb = '<img src="'.IMG_PATH.'icon/small_img.gif" style="padding-bottom:2px" \'">';
		$warning='<img src="'.IMG_PATH.'icon/exclamation_small.png" style="padding-bottom:2px" \'">';		
		include $this->admin_tpl('weixin_reply_article_manage');
	}
	public function sel_artictle(){
		if(!isset($_GET['replyid']) && !$_GET['replyid']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
		$lists=$this->newsdb->listinfo();
		$replyid=intval($_GET['replyid']);
		include $this->admin_tpl('weixin_select_article_manage');	
	}
	public function selact(){
		if(isset($_POST['dosubmit'])) {
		if(is_array($_POST['id'])){
				foreach($_POST['id'] as $newsid_arr) {
 					$this->newsdb->update(array('replyid'=>trim($_POST['replyid'])),array('id'=>$newsid_arr));
				}
				showmessage(L('operation_success'));
		}
		}
	}
	//添加关键词文本
	public function addtext(){
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['inputtime'] = SYS_TIME;
			$_POST['weixin']['type'] = 3;//文本标识
			$_POST['weixin']['siteid'] = $this->get_siteid();		
			$data =$_POST['weixin'];
			$resultid = $this->db->insert($data,true);
 			if(!$resultid) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=addkeyword','', 'addkeyword');
		}
		include $this->admin_tpl('weixin_reply_addtext');
	}
	//编辑关键词文本
	public function edittext(){
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
		$id = intval($_GET['id']);
		$infos = $this->db->get_one(array('id'=>$id));
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$data =$_POST['weixin'];
			$resultid = $this->db->update($data,array('id'=>$id));			
			if(!$resultid) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=reply&view=edittext','', 'edittext');
		}
		include $this->admin_tpl('weixin_reply_edittext');
	}
	public function noreply() {
		if(isset($_POST['dosubmit'])) {
		  $setting=array();
		  $setting['noreply']=$_POST['reply'];
		  setcache('reply_setting', $setting, 'commons');
		  showmessage(L('operation_success'),HTTP_REFERER);
		}else{
		  $setting = getcache('reply_setting','commons');	
		}
		include $this->admin_tpl('noreplyset');
		}
	public function delarcticle() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) ) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} 
		$id = intval($_GET['id']);
				if($id < 1) return false;
				$result=$this->dbarticle->delete(array('id'=>$id));
				if($result){
					showmessage(L('operation_success'),HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"),HTTP_REFERER);
				}
	}		
	/**
	 * 删除
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $keywordid_arr) {
					$this->db->delete(array('id'=>$keywordid_arr));
					$this->dbarticle->delete(array('replyid'=>$keywordid_arr));					
				}
				showmessage(L('operation_success'),'?app=weixin&controller=reply');
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;
				$result = $this->db->delete(array('id'=>$id));
				$this->dbarticle->delete(array('replyid'=>$id));
				
				if($result){
					showmessage(L('operation_success'),'?app=weixin&controller=reply');
				}else {
					showmessage(L("operation_failure"),'?app=weixin&controller=reply');
				}
			}
		}
	}
}
?>