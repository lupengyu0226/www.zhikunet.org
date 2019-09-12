<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class focusreply extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->db = shy_base::load_model('weixin_replykeyword_model');
		$this->dbfocusreply = shy_base::load_model('weixin_focusreply_model');
		shy_base::load_app_func('global','weixin');
	}
	public function init() {
		$big_menu = array('javascript:;', L('回复管理'));
		 $infos = $this->dbfocusreply->get_one(array('id'=>1));
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$where='type in(1,5)';
		$keywords =$this->db->listinfo($where,'id DESC',$page, $pagesize = '21');
		$pages = $this->db->pages;
		$thumb = '<i class="iconfont icon-img" style="color:green"></i> ';
		include $this->admin_tpl('weixin_focusreply_manage');
	}
	public function addtext(){
		$infos = $this->dbfocusreply->get_one(array('id'=>1));		
		if(isset($_POST['dosubmit'])) {
			if(trim($_POST['weixin']['content'])==''){
				showmessage(L("内容不能为空"),HTTP_REFERER);	 
			}
			$data=array();
			$data['content'] = $_POST['weixin']['content'];   			  
			$data['replyid'] = $_POST['weixin']['replyid']=0;
			$result=$this->dbfocusreply->update($data,array('id'=>1));
			if($result){
			showmessage(L('operation_success'),HTTP_REFERER);		
			}else{
				showmessage(L("operation_failure"),HTTP_REFERER); 
			}
		}
		include $this->admin_tpl('weixin_focusreply_addtext');
	}
	public function addgraphic(){
		if(isset($_POST['dosubmit'])) {
			if($_POST['weixin']['replyid']==0){
				showmessage(L("请选择图文选项"),HTTP_REFERER);	 
			}			
			$data=array();
			$data['content'] = $_POST['weixin']['content']='';   	  
			$data['replyid'] = intval($_POST['weixin']['replyid']);
			$result=$this->dbfocusreply->update($data,array('id'=>1));
			if($result){
			showmessage(L('operation_success'),HTTP_REFERER);		
			}else{
				showmessage(L("operation_failure"),HTTP_REFERER); 
			}			  
		}
	}
}
?>
