<?php
defined('IN_SHUYANG') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//定义在单独操作内容的时候，同时更新相关栏目页面
define('RELATION_HTML',true);

shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form','',0);
shy_base::load_app_func('util');
shy_base::load_sys_class('format','',0);

class content_all extends admin {
	private $db,$priv_db;
	public $siteid,$categorys;
	public function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		//权限判断
		if(isset($_GET['catid']) && $_SESSION['roleid'] != 1 && ROUTE_A !='pass' && strpos(ROUTE_A,'public_')===false) {
			$catid = intval($_GET['catid']);
			$modelid = intval($_GET['modelid']);
			$this->priv_db = shy_base::load_model('category_priv_model');
			$action = $this->categorys[$catid]['type']==0 ? ROUTE_A : 'init';
			$priv_datas = $this->priv_db->get_one(array('catid'=>$catid,'is_admin'=>1,'action'=>$action));
			if(!$priv_datas) showmessage(L('permission_to_operate'),'blank');
		}
	}
	
	public function init() {
		$show_header = $show_dialog  = $show_safe_edi = '';
		$this->db = shy_base::load_model('sitemodel_model');
		$this->siteid = $this->get_siteid();
		if(!$this->siteid) $this->siteid = 1;
		$datas2 = $this->db->listinfo(array('siteid'=>$this->siteid,'type'=>0),'','',100);
		//模型文章数array('模型id'=>数量);
		$items = array();
		foreach ($datas2 as $k=>$r) {
			foreach ((array)$categorys as $catid=>$cat) {
				if(intval($cat['modelid']) == intval($r['modelid'])) {
					$items[$r['modelid']] += intval($cat['items']);
				} else {
					$items[$r['modelid']] += 0;
				}
			}
			$datas2[$k]['items'] = $items[$r['modelid']];
		}
		$this->db = shy_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		//权限判断
		if(isset($_GET['catid']) && $_SESSION['roleid'] != 1 && ROUTE_A !='pass' && strpos(ROUTE_A,'public_')===false) {
			$catid = intval($_GET['catid']);
			$this->priv_db = shy_base::load_model('category_priv_model');
			$action = $this->categorys[$catid]['type']==0 ? ROUTE_A : 'init';
			$priv_datas = $this->priv_db->get_one(array('catid'=>$catid,'is_admin'=>1,'action'=>$action));
			if(!$priv_datas) showmessage(L('permission_to_operate'),'blank');
		}
		$modelid = $_GET['modelid'] = intval($_GET['modelid']);
		if ($modelid=="") showmessage(L('模型 ID 不存在'),'blank');
		$admin_username = param::get_cookie('admin_username');
		//查询当前的工作流
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		$workflows = getcache('workflow_'.$this->siteid,'commons');
		$workflows = $workflows[$workflowid];
		$workflows_setting = string2array($workflows['setting']);

		//将有权限的级别放到新数组中
		$admin_privs = array();
		foreach($workflows_setting as $_k=>$_v) {
			if(empty($_v)) continue;
			foreach($_v as $_value) {
				if($_value==$admin_username) $admin_privs[$_k] = $_k;
			}
		}
		//工作流审核级别
		$workflow_steps = $workflows['steps'];
		$workflow_menu = '';
		$steps = isset($_GET['steps']) ? intval($_GET['steps']) : 0;
		//工作流权限判断
		if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs)) showmessage(L('permission_to_operate'));
		$this->db->set_model($modelid);
		if($this->db->table_name==$this->db->db_tablepre) showmessage(L('model_table_not_exists'));;
		$status = $steps ? $steps : 99;
		if(isset($_GET['reject'])) $status = 0;
		$where = 'status='.$status;
		//搜索
		
		if(isset($_GET['start_time']) && $_GET['start_time']) {
			$start_time = strtotime($_GET['start_time']);
			$where .= " AND `inputtime` > '$start_time'";
		}
		if(isset($_GET['end_time']) && $_GET['end_time']) {
			$end_time = strtotime($_GET['end_time']);
			$where .= " AND `inputtime` < '$end_time'";
		}
		if($start_time>$end_time) showmessage(L('starttime_than_endtime'));
		if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
			$type_array = array('title','description','username');
			$searchtype = intval($_GET['searchtype']);
			if($searchtype < 3) {
				$searchtype = $type_array[$searchtype];
				$keyword = strip_tags(trim($_GET['keyword']));
				$where .= " AND `$searchtype` like '%$keyword%'";
			} elseif($searchtype==3) {
				$keyword = intval($_GET['keyword']);
				$where .= " AND `id`='$keyword'";
			}
		}
		if(isset($_GET['posids']) && !empty($_GET['posids'])) {
			$posids = $_GET['posids']==1 ? intval($_GET['posids']) : 0;
			$where .= " AND `posids` = '$posids'";
		}
		
		$datas = $this->db->listinfo($where,'id desc',$_GET['page']);
		$edi_pages = $this->db->edi_pages;
		$safe_edi = $_SESSION['safe_edi'];
		for($i=1;$i<=$workflow_steps;$i++) {
			if($_SESSION['roleid']!=1 && !in_array($i,$admin_privs)) continue;
			$current = $steps==$i ? 'class=on' : '';
			$r = $this->db->get_one(array('catid'=>$catid,'status'=>$i));
			$newimg = $r ? '<img src="'.IMG_PATH.'icon/new.png" style="padding-bottom:2px" onclick="window.location.href=\'?app=content&controller=content&view=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&safe_edi='.$safe_edi.'\'">' : '';
			$workflow_menu .= '<a href="?app=content&controller=content&view=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&safe_edi='.$safe_edi.'" '.$current.' ><em>'.L('workflow_'.$i).$newimg.'</em></a><span>|</span>';
		}
		if($workflow_menu) {
			$current = isset($_GET['reject']) ? 'class=on' : '';
			$workflow_menu .= '<a href="?app=content&controller=content&view=&menuid='.$_GET['menuid'].'&catid='.$catid.'&safe_edi='.$safe_edi.'&reject=1" '.$current.' ><em>'.L('reject').'</em></a><span>|</span>';
		}
		$model_fields = getcache('model_field_'.$modelid, 'model');
		$setting = string2array($model_fields['thumb']['setting']);
		$args = '1,'.$setting['upload_allowext'].','.$setting['isselectimage'].','.$setting['images_width'].','.$setting['images_height'].','.$setting['watermark'];
		$authkey = upload_key($args);
		$template = $MODEL['admin_list_template'] ? $MODEL['admin_list_template'] : 'content_list';
		include $this->admin_tpl('content_all_list');
	}
}
?>