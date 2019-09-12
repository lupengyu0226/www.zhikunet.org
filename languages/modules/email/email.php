<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class email extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('email_model');
		shy_base::load_app_func('global');
	}
	//首页
	public function init() {
		include $this->admin_tpl('index');
	}
	public function lists() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$where = '';
		if(isset($_GET['ids'])) {
			$ids = trim($_GET['ids']);
			$field = $_GET['field'];
			if(in_array($field, array('ids','id'))) {
				if($field=='id') {
					$where .= "`id` ='$ids'";
				} else {
					$where .= "`$field` like '%$ids%'";
				}
			}
		}
		$data = $this->db->listinfo($where, '`id` DESC',$page,15);
		$pages = $this->db->pages;
		include $this->admin_tpl('list');
	}
	public function delete(){
		if($_GET['id']){
			if(is_array($_GET['id'])){
				$_GET['id'] = implode(',', $_GET['id']);
				$this->db->query("DELETE FROM `v9_email` WHERE `id` in ($_GET[id])");
			}else{
				$this->db->query("DELETE FROM `v9_email` WHERE `id` in ($_GET[id])");
			}
			showmessage('操作成功', '?app=email&controller=email&view=lists');
		}else{
			showmessage('参数不正确', '?app=email&controller=email&view=lists');
		}
	}
	public function call() {
		$_GET['id'] = intval($_GET['id']);
		$where = array('id' => $_GET['id']);
		$an_info = $this->db->get_one($where);
		$an_info = preg_replace("/<p>|<br>|<\/p>/is", "", $an_info); 
		$big_menu = array('javascript:;', L('邮件详情'));
		include $this->admin_tpl('call');
	}
	public function emails() {
	  shy_base::load_sys_func('tougao');
      if(isset($_POST['dosubmit'])) {
			$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
			if ($_SESSION['code'] != strtolower($code)) {
				$_SESSION['code'] = '';
				showmessage(L('code_error'), HTTP_REFERER);
			}
			$_SESSION['code'] = '';
		   if(!empty($_POST['emails']['ids'])) {
		   	$ids=$_POST['emails']['ids'];
		    $emailetitle=$_POST['emails']['title'];
		    $emailcontent=$_POST['emails']['content']."<br><br><br><br><p>".$_POST['emails']['star']."</p><br><p>(此邮件为05273.cn审稿机器人发送!沭阳网投稿邮箱变更提醒：原news@05273.com 变更为：news@05273.cn 请悉知！)</p>";
		    sendmail($ids,$emailetitle,$emailcontent);
		    $addtime = SYS_TIME;
			$this->email_db = shy_base::load_model('email_model');
			$this->email_db->insert(array('ids'=>$ids,'emailetitle'=>$emailetitle,'emailcontent'=>$emailcontent,'addtime'=>$addtime));
		    showmessage("邮件发送成功", '?app=email&controller=email&view=lists&menuid=2808');
		       } else {
            showmessage(L('illegal_parameters'), '?app=email&controller=email&view=lists&menuid=2808');
            }
	  }
	}
}
?>
