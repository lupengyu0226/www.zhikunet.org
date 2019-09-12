<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class service extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->db = shy_base::load_model('weixin_replykeyword_model');		
		shy_base::load_app_func('global','weixin');		
		$this->url = shy_base::load_app_class('url', 'content');
	}
    //默认页面显示查询菜单
	public function init() {
		$where=" `type`=9";
		if($_GET['dosubmit']&&isset($_GET['keyword'])){
			$q=trim($_GET['keyword']);
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		if($q!=''){
			$where .= " AND `keyword` LIKE '%$q%' ";
		}
		
		$infos =$this->db->listinfo($where,'id DESC',$page, $pagesize = '15');
		$pages = $this->db->pages;
		$thumb = '<img src="'.IMG_PATH.'icon/small_img.gif" style="padding-bottom:2px" \'">';
		$warning='<img src="'.IMG_PATH.'icon/exclamation_small.png" style="padding-bottom:2px" \'">';
		/*文本回复*/
		$big_menu = array('javascript:window.top.art.dialog({id:\'addkeyword\',iframe:\'?app=weixin&controller=service&view=addkeyword\', title:\''.L('weixin_reply_addkeyword').'\', width:\'600\', height:\'200\'}, function(){var d = window.top.art.dialog({id:\'addkeyword\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'addkeyword\'}).close()});void(0);', L('weixin_reply_addkeyword'));		
		
		include $this->admin_tpl('service_keywordsmanage');
	}
	
	/**
	 * 添加图文回复
	 *在添加关键词时，默认添加一个图文，且默认的图文default=1，不可删除，只能删除关键词时一同删除
	 */
	public function addkeyword(){
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['inputtime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			
			$_POST['weixin']['keyword'] = isset($_POST['weixin']['keyword']) ? trim($_POST['weixin']['keyword']):showmessage(L("operation_failure"),HTTP_REFERER);
			
			
			$replyid = $this->db->insert(
			array(
			'siteid'=>$_POST['weixin']['siteid'],
			'keyword'=>$_POST['weixin']['keyword'],
			'type'=>9,
			'inputtime'=>$_POST['weixin']['inputtime'],
			'updatetime'=>$_POST['weixin']['updatetime'],
			),
			true
			);
			if(!$replyid) return FALSE; 
 			showmessage(L('operation_success'),'?app=weixin&controller=servicey&view=addkeyword','', 'addkeyword');
		}
		
		include $this->admin_tpl('service_addkeyword');
		}
	
	//修改关键词
 	public function editkeyword() {
		if(!isset($_GET['id']) && !$_GET['id']){
			showmessage(L("operation_failure"),HTTP_REFERER);
		}
 		$id = intval($_GET['id']);
		$infos = $this->db->get_one(array('id'=>$id));
		
		
		if(isset($_POST['dosubmit'])) {
			
			$keyword = isset($_POST['weixin']['keyword']) ? trim($_POST['weixin']['keyword']):showmessage(L("operation_failure"),HTTP_REFERER);
			$resultid=$this->db->update(array('keyword'=>$keyword,'updatetime'=>SYS_TIME),array('id'=>$id));	
			
			
					
			if(!$resultid) return FALSE;

			showmessage(L('operation_success'),'?app=weixin&controller=service&view=editkeyword','', 'editkeyword');
			
		}
		
		include $this->admin_tpl('service_editkeyword');
	}	
		
	/**
	 * 删除
	 */
	public function delete() {
  		if((!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				
				foreach($_POST['id'] as $keywordid_arr) {
 					//批量删除
					$this->db->delete(array('id'=>$keywordid_arr));
							
					
				}
				showmessage(L('operation_success'),'?app=weixin&controller=service');
			}
		}
	}
}
?>