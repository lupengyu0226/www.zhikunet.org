<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form', '', 0);
class manages extends admin {
	function __construct() {
		parent::__construct();
		//$this->sites = shy_base::load_app_class('sites','admin');
		$this->db = shy_base::load_model('shuyangtoday_model');
		//$this->shuyangconfig = getcache('shuyang', 'commons');
		$this->siteid = $this->get_siteid();
	}
	
	function init() {
		$page = max(intval($_GET['page']), 1);
		$data = $this->db->listinfo(array(), '`id` DESC', $page);
		include $this->admin_tpl('list');
	}
	
	function add() {
		if($_POST['dosubmit']) {
			$info = array();
			$topinfo = $_POST['top'];
			$topinfo['thumb'] = thumb($topinfo['thumb'],615,300);	
			$info['name'] = $topinfo['title'];
			$listinfo = $_POST['list'];
			foreach((array)$listinfo as $k=>$v){
				$listinfo[$k]['thumb'] = thumb($v['thumb'],100,100);
			}
			
			$data = array('top'=>$topinfo,'list'=>$listinfo);
			
			$info['datas'] = array2string($data);
			$info['setting'] = array2string($info[setting]);
			$info['addtime'] = time();
		
			$return_id = $this->db->insert($info,'1');
			showmessage(L('add_success'), '?app=shuyangtoday&controller=manages&view=init&menuid='.$_GET['menuid']);
		} else {
			include $this->admin_tpl('add');			
		}		
	}
	
	function edit() {
		$id = intval($_GET['id']) ? intval($_GET['id']) : showmessage('参数错误',HTTP_REFERER);
		if($_POST['dosubmit']) {
			$info = array();
			$topinfo = $_POST['top'];
			$topinfo['thumb'] = thumb($topinfo['thumb'],615,300);
			$info['name'] = $topinfo['title'];
			
			$listinfo = $_POST['list'];
			foreach($listinfo as $k=>$v){
				$listinfo[$k]['thumb'] = thumb($v['thumb'],100,100);
			}
			
			$data = array('top'=>$topinfo,'list'=>$listinfo);
			
			$info['datas'] = array2string($data);
			$info['setting'] = array2string($info['setting']);
			
			$this->db->update($info, array('id'=>$id));
			
			showmessage(L('operation_success'), '?app=shuyangtoday&controller=manages&view=edit&id='.$id.'&menuid='.$_GET['menuid']);
			
		}else{
			$info = $this->db->get_one(array('id'=>$id));
			$info['datas'] = string2array($info['datas']);
			$info['setting'] = string2array($info['setting']);
			
			if($info) {
				include $this->admin_tpl('edit');
			}else{
				showmessage(L('add_success'), '?app=shuyangtoday&controller=manages&view=init');
			}
		}		
		
	}
	
	public function delete() {
		if (isset($_GET['id']) && !empty($_GET['id'])) {
			$id = intval($_GET['id']);
			$this->db->delete(array('id'=>$id));
			showmessage(L('operation_success'), HTTP_REFERER);
		} elseif (isset($_POST['ids']) && !empty($_POST['ids'])) {
			if (is_array($_POST['ids'])) {
				foreach ($_POST['ids'] as $fid) {
					$this->db->delete(array('id'=>$fid));
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('illegal_operation'), HTTP_REFERER);
		}
	}
	
	
	function getlist() {
		$this->adb = shy_base::load_model('content_model');
		shy_base::load_sys_class('format');
		$show_header = '';
		$model_cache = getcache('model','commons');
		if(!isset($_GET['modelid'])) {
			showmessage(L('please_select_modelid'));
		} else {
			$page = intval($_GET['page']);
			
			$modelid = intval($_GET['modelid']);
			$this->adb->set_model($modelid);
			$where = '';
			if($_GET['catid']) {
				$catid = intval($_GET['catid']);
				$where .= "catid='$catid'";
			}
			$where .= $where ?  ' AND status=99' : 'status=99';
			
			if(isset($_GET['keywords'])) {
				$keywords = trim($_GET['keywords']);
				$field = $_GET['field'];
				if(in_array($field, array('id','title','keywords','description'))) {
					if($field=='id') {
						$where .= " AND `id` ='$keywords'";
					} else {
						$where .= " AND `$field` like '%$keywords%'";
					}
				}
			}
			$infos = $this->adb->listinfo($where, '`id` DESC',$page,10);
			$pages = $this->adb->pages;
			include $this->admin_tpl('getlist');
		}
	}
	
}
?>
