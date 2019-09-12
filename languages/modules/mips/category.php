<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);

class category extends admin {
	private $db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('category_model');
		$this->siteid = $this->get_siteid();
	}
	/**
	 * 管理栏目
	 */
	public function init () {
		$show_safe_edi = '';
		$tree = shy_base::load_sys_class('tree');
		$models = getcache('model','commons');
		$sitelist = getcache('sitelist','commons');
		$category_items = array();
		foreach ($models as $modelid=>$model) {
			$category_items[$modelid] = getcache('category_items_'.$modelid,'commons');
		}
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		//读取缓存
		$result = getcache('category_content_'.$this->siteid,'commons');
		$show_detail = count($result) < 500 ? 1 : 0;
		$parentid = $_GET['parentid'] ? intval($_GET['parentid']) : 0;
		$html_root = shy_base::load_config('system','html_root');
		$types = array(0 => L('category_type_system'),1 => L('category_type_page'),2 => L('category_type_link'));
		if(!empty($result)) {
			foreach($result as $r) {
				$r['modelname'] = $models[$r['modelid']]['name'];
				$r['str_manage'] .= '<a class="xbtn btn-info btn-xs" href="?app=mips&controller=category&view=edit&catid='.$r['catid'].'&menuid='.$_GET['menuid'].'&type='.$r['type'].'&safe_edi='.$_SESSION['safe_edi'].'">'.L('edit').'</a>';			
				$r['typename'] = $types[$r['type']];
				$r['display_icon'] = $r['ismenu'] ? '' : ' <img src ="'.IMG_PATH.'icon/gear_disable.png" title="'.L('not_display_in_menu').'">';

				$r['help'] = '';
				$setting = string2array($r['setting']);
				$r['url'] = ' <a href="'.S($r['url']).'" target="_blank"><i class="icon-on icon-mips"><em class="home"></em></i></a>&nbsp;&nbsp;' ;
				$categorys[$r['catid']] = $r;
			}
		}
		$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text-c'></td>
					<td align='center'>\$id</td>
					<td >\$spacer\$catname\$display_icon</td>
					<td>\$typename</td>
					<td>\$modelname</td>
					<td>\$url</td>
					<td align='center' >\$str_manage</td>
				</tr>";
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		$show_dialog = true;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=mips&controller=mips_admin&view=add\', title:\''.L('add_site').'\', width:\'440\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('mips_add_site'));
		include $this->admin_tpl('category_manage');
	}

	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('catid'=>$id));
			}
			$this->cache();
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}
	public function edit() {
		
		if(isset($_POST['dosubmit'])) {
			shy_base::load_sys_func('iconv');
			$catid = 0;
			$catid = intval($_POST['catid']);
			$mipssetting = $_POST['mipssetting'];
			$_POST['info']['mipssetting'] = array2string($mipssetting);
			//栏目生成静态配置
			if($_POST['type'] != 2) {
				if($mipssetting['ishtml']) {
					$mipssetting['category_ruleid'] = $_POST['category_html_ruleid'];
				} else {
					$mipssetting['category_ruleid'] = $_POST['category_php_ruleid'];
				}
			}
			if($mipssetting['content_ishtml']) {
				$mipssetting['show_ruleid'] = $_POST['show_html_ruleid'];
			} else {
				$mipssetting['show_ruleid'] = $_POST['show_php_ruleid'];
			}	
			$_POST['info']['mipssetting'] = array2string($mipssetting);
			$this->db->update($_POST['info'],array('catid'=>$catid,'siteid'=>$this->siteid));
            showmessage(L('operation_success'),'?app=mips&controller=category&view=init');
		} else {
			//获取站点模板信息
			shy_base::load_app_func('global');
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$show_validator = $catid = $r = '';
			$catid = intval($_GET['catid']);
			shy_base::load_sys_class('form','',0);
			$r = $this->db->get_one(array('catid'=>$catid));
			if($r) extract($r);
			$mipssetting = string2array($mipssetting);
			
			$this->priv_db = shy_base::load_model('category_priv_model');
			$this->privs = $this->priv_db->select(array('catid'=>$catid));
			
			$type = $_GET['type'];
			$show_dialog = true;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=mips&controller=mips_admin&view=add\', title:\''.L('add_site').'\', width:\'440\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('mips_add_site'));
		
			if($type==0) {
				include $this->admin_tpl('category_edit');
			} elseif ($type==1) {
				include $this->admin_tpl('category_page_edit');
			} else {
				include $this->admin_tpl('category_link');
			}
		}	
	}
	
	/**
	 * 更新缓存
	 */
	public function cache() {
		$categorys = array();
		$models = getcache('model','commons');
		foreach ($models as $modelid=>$model) {
			$datas = $this->db->select(array('modelid'=>$modelid),'catid,type,items',10000);
			$array = array();
			foreach ($datas as $r) {
				if($r['type']==0) $array[$r['catid']] = $r['items'];
			}
			setcache('category_items_'.$modelid, $array,'commons');
		}
		$array = array();
		$categorys = $this->db->select('`module`=\'content\'','catid,siteid',20000,'listorder ASC');
		foreach ($categorys as $r) {
			$array[$r['catid']] = $r['siteid'];
		}
		setcache('category_content',$array,'commons');
		$categorys = $this->categorys = array();
		$this->categorys = $this->db->select(array('siteid'=>$this->siteid, 'module'=>'content'),'*',10000,'listorder ASC');
		foreach($this->categorys as $r) {
			unset($r['module']);
			$mipssetting = string2array($r['mipssetting']);
			$r['create_to_html_root'] = $mipssetting['create_to_html_root'];
			$r['ishtml'] = $mipssetting['ishtml'];
			$r['content_ishtml'] = $mipssetting['content_ishtml'];
			$r['category_ruleid'] = $mipssetting['category_ruleid'];
			$r['show_ruleid'] = $mipssetting['show_ruleid'];
			$r['workflowid'] = $mipssetting['workflowid'];
			$r['isdomain'] = '0';
			if(!preg_match('/^(http|https):\/\//', $r['url'])) {
				$r['url'] = siteurl($r['siteid']).$r['url'];
			} elseif ($r['ishtml']) {
				$r['isdomain'] = '1';
			}
			$categorys[$r['catid']] = $r;
		}
		setcache('category_content_'.$this->siteid,$categorys,'commons');
		return true;
	}
/**
	 * 更新缓存并修复栏目
	 */
	public function public_cache() {
		$this->cache();
		showmessage(L('operation_success'),'?app=mips&controller=category&view=init&menuid=2196');
	}
	/**
	 * json方式加载模板
	 */
	public function public_tpl_file_list() {
		$style = isset($_GET['style']) && trim($_GET['style']) ? trim($_GET['style']) : exit(0);
		$catid = isset($_GET['catid']) && intval($_GET['catid']) ? intval($_GET['catid']) : 0;
		$batch_str = isset($_GET['batch_str']) ? '['.$catid.']' : '';
		if ($catid) {
			$cat = getcache('category_content_'.$this->siteid,'commons');
			$cat = $cat[$catid];
			$cat['mipssetting'] = string2array($cat['mipssetting']);
		}
		shy_base::load_sys_class('form','',0);
		if($_GET['type']==1) {
			$html = array('page_template'=>form::select_template($style, 'mips',(isset($cat['mipssetting']['page_template']) && !empty($cat['mipssetting']['page_template']) ? $cat['mipssetting']['page_template'] : 'category'),'name="mipssetting'.$batch_str.'[page_template]"','page'));
		} else {
			$html = array('category_template'=> form::select_template($style, 'mips',(isset($cat['mipssetting']['category_template']) && !empty($cat['mipssetting']['category_template']) ? $cat['mipssetting']['category_template'] : 'category'),'name="mipssetting'.$batch_str.'[category_template]"','category'), 
				'list_template'=>form::select_template($style, 'mips',(isset($cat['mipssetting']['list_template']) && !empty($cat['mipssetting']['list_template']) ? $cat['mipssetting']['list_template'] : 'list'),'name="mipssetting'.$batch_str.'[list_template]"','list'),
				'show_template'=>form::select_template($style, 'mips',(isset($cat['mipssetting']['show_template']) && !empty($cat['mipssetting']['show_template']) ? $cat['mipssetting']['show_template'] : 'show'),'name="mipssetting'.$batch_str.'[show_template]"','show')
			);
		}
		if ($_GET['module']) {
			unset($html);
			if ($_GET['templates']) {
				$templates = explode('|', $_GET['templates']);
				if ($_GET['id']) $id = explode('|', $_GET['id']);
				if (is_array($templates)) {
					foreach ($templates as $k => $tem) {
						$t = $tem.'_template';
						if ($id[$k]=='') $id[$k] = $tem;
						$html[$t] = form::select_template($style, $_GET['module'], $id[$k], 'name="'.$_GET['name'].'['.$t.']" id="'.$t.'"', $tem);
					}
				}
			}
			
		}
		if (CHARSET == 'gbk') {
			$html = array_iconv($html, 'gbk', 'utf-8');
		}
		echo json_encode($html);
	}
}
?>
