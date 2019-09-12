<?php 
defined('IN_SHUYANG') or exit('No permission resources.');
class index {
	function __construct() {
		$this->db = shy_base::load_model('zhufu_model');
	}
	/**
	 * 祝福首页
	 */
	public function init() {
		$siteid = 'SITEID';
		//祝福首页
		$sql = '';
		//$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;
		$urlrule = '/zhufu/index.shtml~/zhufu/page_{$page}.shtml';
		$page = max(intval($_GET['page']), 1);
		$zhufu = $this->db->listinfo($sql, '`edi_id` DESC', $page, 20, '', 10, $urlrule);
			$template = $r['show_template'] ? $r['show_template'] : 'index';
			extract($zhufu);
			include template('zhufu', $template, $r['style']);
	}
	/**
	 * 祝福列表
	 */
	public function lists() {
		$siteid = 'SITEID';
		//祝福列表
		$sql = '';
		//$_GET['status'] = $_GET['status'] ? intval($_GET['status']) : 1;
		$urlrule = '/zhufu/list.shtml~/zhufu/list_{$page}.shtml';
		$page = max(intval($_GET['page']), 1);
		$zhufu = $this->db->listinfo($sql, '`edi_id` DESC', $page, 20, '', 10, $urlrule);
			$template = $r['show_template'] ? $r['show_template'] : 'list';
			extract($zhufu);
			include template('zhufu', $template, $r['style']);
	}
 	/**
	 * 展示祝福
	 */
	public function show() {
		if(!isset($_GET['id'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['id'] =trim($_GET['id']);
		$where = '';
		$where .= "`edi_id`='".$_GET['id']."'";
		$r = $this->db->get_one($where);
	    $top =rand(110,418);
	    $left=rand(21,525);
		if($r['edi_id']) {
			$template = $r['show_template'] ? $r['show_template'] : 'show';
			extract($r);
			include template('zhufu', $template, $r['style']);
		} else {
			showmessage(L('这个祝福信息被年兽吃了'));	
		}
	}
 	/**
	 * 游客祝福单条信息
	 */
	public function zf() {
		if(!isset($_GET['id'])) {
			showmessage(L('illegal_operation'));
		}
		$_GET['id'] =trim($_GET['id']);
		$where = '';
		$where .= "`edi_id`='".$_GET['id']."'";
		$this->db->get_one($where);

		if(!preg_match("/^\d*$/",$_GET['id'])){
		   die("<script>alert('输入错误，请返回重填！');history.back();</script>");
		}
		if($_GET['id']) {
		$this->db->update(array('edi_cs'=>'+=1'), array('edi_id'=>$_GET['id']));
		showmessage(L('您的祝福已发出!').L('正在返回祝福内容'), HTTP_REFERER);
		} else {
		showmessage(L('这个祝福信息被年兽吃了'));	
		}
	}
 	/**
	 * 发布祝福
	 */
	public function post() {
		$siteid = 'SITEID';
 		if(isset($_POST['dosubmit'])){
 			if($_POST['send']==""){
 				showmessage(L('发送者不能为空'),"post.shtml");
 			}
 			if($_POST['info']==""){
 				showmessage(L('祝福语不能为空'),"post.shtml");
 			}
			if($_POST['pick']==""){
 				showmessage(L('接收人不能为空'),"post.shtml");
 			}
 			$zhufu_db = shy_base::load_model(zhufu_model);
		 	$edi_class = 0;
		 	$edi_images = safe_replace(strip_tags($_POST['icon']));
		 	$edi_head = safe_replace(strip_tags($_POST['pick']));
		 	$edi_sign = safe_replace(strip_tags($_POST['send']));
		 	$edi_lr = safe_replace(strip_tags($_POST['info']));
			$edi_date = date("Y-m-d G:i:s");
 			$sql = array('siteid'=>$siteid,'edi_sign'=>$edi_sign,'edi_lr'=>$edi_lr,'edi_head'=>$edi_head,'edi_images'=>$edi_images,'edi_class'=>'$edi_class','edi_date'=>$edi_date,'edi_cs'=>'0');
 			$zhufu_db->insert($sql);
 			showmessage(L('您的祝福已发出!'), "index.shtml");
 		} else {
 			shy_base::load_sys_class('form', '', 0);
  			$SEO = seo('SITEID', '', L('application_phones'), '', '');
   			include template('zhufu', 'post');
 		}
	}
}
?>
