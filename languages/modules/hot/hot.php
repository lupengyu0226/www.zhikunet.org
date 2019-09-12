<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin', 'admin', 0);
shy_base::load_sys_class('form', '', 0);
class hot extends admin {
	private $db;
	public function __construct() {
		$this->db = shy_base::load_model('hot_model');
		$this->db_content = shy_base::load_model('hot_content_model');
		parent::__construct();
	}
	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$where = '';
		if(isset($_GET['keywords'])) {
			$keywords = trim($_GET['keywords']);
			$field = $_GET['field'];
			if(in_array($field, array('tag','tagid'))) {
				if($field=='tagid') {
					$where .= "`tagid` ='$keywords'";
				} else {
					$where .= "`$field` like '%$keywords%'";
				}
			}
		}
		$data = $this->db->listinfo($where, '`tagid` DESC',$page,15);
		$pages = $this->db->pages;
		include $this->admin_tpl('hot_list');
	}
	public function getlist() {
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->adb = shy_base::load_model('hot_content_model');
		shy_base::load_sys_class('format');
			$page = intval($_GET['page']);
			$where = '';
			if($_GET['catid']) {
				$catid = intval($_GET['catid']);
				$where .= "catid>0";
			}
			if(isset($_GET['keywords'])) {
				$keywords = trim($_GET['keywords']);
				$field = $_GET['field'];
				if(in_array($field, array('title','tag','contentid'))) {
					if($field=='contentid') {
						$where .= " AND `contentid` ='$keywords'";
					} else {
						$where .= " AND `$field` like '%$keywords%'";
					}
				}
			}
			$infos = $this->adb->listinfo($where, '`id` DESC',$page,20);
			$pages = $this->adb->pages;
			$big_menu ;
			include $this->admin_tpl('getlist');
	}
	public function edit(){
		if(isset($_POST['dosubmit'])){
			$_POST['info']['lastusetime'] = strtotime($_POST['info']['lastusetime']);
			$_POST['info']['lasthittime'] = strtotime($_POST['info']['lasthittime']);
			$this->db->update($_POST['info'], array('tagid'=>$_GET['tagid']));
			showmessage('更新成功！');
		
		}else{
			$data = $this->db->get_one("`tagid` = '$_GET[tagid]'");
			if(!$data)showmessage('信息不存在或者已被删除！！', '?m=hot&c=hot&a=init');
			shy_base::load_sys_class('form','',0);
			include $this->admin_tpl('hot_edit');
		}
	}
	public function gx(){
			$catid = intval($_GET['catid']);
			$id = intval($_GET['id']);
			$key = $_GET['tag'];
			$title = tgo($catid,$id);
			$this->db_content = shy_base::load_model('hot_content_model');
			$this->db_content->update(array('title'=>$title),array('tag'=>$key,'contentid'=>$id,'catid'=>$catid));
	}

	public function delete(){
		if($_GET['tagid']){
			if(is_array($_GET['tagid'])){
				$_GET['tagid'] = implode(',', $_GET['tagid']);
				$this->db->query("DELETE FROM `v9_tags` WHERE `tagid` in ($_GET[tagid])");
			}else{
				$this->db->query("DELETE FROM `v9_tags` WHERE `tagid` in ($_GET[tagid])");
			}
			showmessage('操作成功', '?app=hot&controller=hot&view=init');
		}else{
			showmessage('参数不正确', '?app=hot&controller=hot&view=init');
		}
	}
	public function kacha(){
		if($_GET['catid'] && $_GET['contentid']) {
			if(is_array($_GET['catid'] && $_GET['contentid'])){
				$_GET['catid'] = implode(',', $_GET['catid']);
				$_GET['contentid'] = implode(',', $_GET['contentid']);
				$this->db->query("DELETE FROM `v9_tags_content` WHERE `id` in ($_GET[id]) AND `catid` in ($_GET[catid]) AND `contentid` in ($_GET[contentid]) ");
			}else{
				$this->db->query("DELETE FROM `v9_tags_content` WHERE `id` in ($_GET[id]) AND `catid` in ($_GET[catid]) AND `contentid` in ($_GET[contentid]) ");
			}
			showmessage('操作成功', '?app=hot&controller=hot&view=getlist');
		}else{
			showmessage('参数不正确', '?app=hot&controller=hot&view=getlist');
		}
	}
	public function listorder(){
		$tagid = $_GET['tagid'];
		if($tagid){
			foreach($tagid as $n=>$id){
				if(!$id)continue;
				$this->db->update('`listorder`='.intval($_GET['listorder'][$n]), array('tagid'=>$id));

			}
			showmessage('更新成功！', '?app=hot&controller=hot&view=init');
		}else{
			showmessage('参数不正确', '?app=hot&controller=hot&view=init');
		}
	}
}
?>