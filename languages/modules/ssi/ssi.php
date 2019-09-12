<?php
defined('IN_SHUYANG') or exit('No permission resources.'); 
shy_base::load_app_class('admin', 'admin', 0);
class ssi extends admin {
	private $db, $siteid,$sitelist,$dbsource;
	public function __construct() {
		$this->db = shy_base::load_model('ssi_model');
		$this->dbsource = shy_base::load_model('dbsource_model');
		$this->db2 = shy_base::load_model('type_model');
		$this->siteid = $this->get_siteid();
		$this->sitelist = getcache('sitelist','commons');
		parent::__construct();
	}
	
	public function init() {
		if($_GET['typeid']!=''){
			$where = array('typeid'=>intval($_GET['typeid']),'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
	$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=ssi&controller=ssi&view=add\', title:\''.L('add_ssi').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_ssi'));
		$infos = $this->db->select('1','id,name,tag,cache',100);
		$array = array();
		foreach ($infos as $r) {
			$r['lastupdate']=time();
			$array[$r['id']] = $r;
			
		}
		setcache('ssi_var',$array,'ssi');	
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'id DESC',$page, $pages = '20');
		$pages = $this->db->pages;
		$types = $this->db2->listinfo(array('module'=>ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'listorder ASC');
		$types = new_html_special_chars($types);
 		$type_arr = array ();
 		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}	
		include $this->admin_tpl('ssi_list');
	}
	
	
	/**
	 * 添加标签向导
	 */
	public function add() {
		shy_base::load_app_func('global', 'dbsource');
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('name').L('empty'));
			$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 60;
			$tag= isset($_POST['tag']) && trim($_POST['tag']) ? trim($_POST['tag']) : showmessage(L('id').L('empty'));
			$data = isset($_POST['data']) && trim($_POST['data']) ? trim($_POST['data']) : showmessage(L('custom_sql').L('empty'));
			//检查名称是否已经存在
			if ($this->db->get_one(array('name'=>$name)))  {
				showmessage(L('name').L('exists'));
			}
			$siteid = $this->get_siteid();
			
		
			$insert_id=$this->db->insert(array('siteid'=>$siteid, 'tag'=>$tag,'typeid'=>$_POST['typeid'], 'name'=>$name,'data'=>$data,'cache'=>$cache),1);
			if($insert_id){				
				if (get_magic_quotes_gpc()){
					$data = stripslashes($data); 
				}
				$ssi = shy_base::load_app_class('ssi_tag');
				$ssi->createhtml(SHY_PATH.'templates'.DIRECTORY_SEPARATOR.$this->sitelist[$this->siteid]['default_style'].DIRECTORY_SEPARATOR.'ssi'.DIRECTORY_SEPARATOR.'ssi_'.$insert_id.'.html',$data);
				}
			showmessage(L('operation_success'),HTTP_REFERER,'', 'add');
			
		} else {
			$show_header = $show_validator = true;
			shy_base::load_sys_class('form', '', 0);
 			$siteid = $this->get_siteid();
			$types = $this->db2->get_types($siteid);
			include $this->admin_tpl('tag_add');
		}
	}
	
	
	public function edit() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :  showmessage(L('illegal_operation'));
		if (!$data = $this->db->get_one(array('id'=>$id))) {
			showmessage(L('nofound'));
		}
		if (isset($_POST['dosubmit'])) {
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : showmessage(L('name').L('empty'), HTTP_REFERER);
			$cache = isset($_POST['cache']) && intval($_POST['cache']) ? intval($_POST['cache']) : 60;
			$tag= isset($_POST['tag']) && trim($_POST['tag']) ? trim($_POST['tag']) : showmessage(L('id').L('empty'), HTTP_REFERER);
			$data = isset($_POST['data']) && trim($_POST['data']) ? trim($_POST['data']) : showmessage(L('custom_sql').L('empty'), HTTP_REFERER);
			//$type = isset($_POST['typeid']);
			//var_dump($_POST['typeid']);exit;
			/*			
			if ($data['name'] != $name) {
				if ($this->db->get_one(array('name'=>$name))) {
					showmessage(L('name').L('exists'), HTTP_REFERER);
				}
			}
			*/
			if ($this->db->update(array('name'=>$name,'tag'=>$tag,'data'=>$data,'typeid'=>$_POST['typeid'],'cache'=>$cache,'siteid'=>$this->siteid), array('id'=>$id))) {	
				if (get_magic_quotes_gpc()){
					$data = stripslashes($data); 
				}

				$ssi = shy_base::load_app_class('ssi_tag');
				$ssi->createhtml(SHY_PATH.'templates'.DIRECTORY_SEPARATOR.$this->sitelist[$this->siteid]['default_style'].DIRECTORY_SEPARATOR.'ssi'.DIRECTORY_SEPARATOR.'ssi_'.$id.'.html',$data);
				showmessage(L('operation_success'), '', '' ,'edit');
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		}
		else{
			
		$show_header = $show_validator = true;
		shy_base::load_sys_class('form', '', 0);
		$types = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
			$type_arr = array ();
		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}
		include $this->admin_tpl('tag_edit');
		}
	}


	
	public function del() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :  showmessage(L('illegal_operation'));
		if (!$data = $this->db->get_one(array('id'=>$id))) {
			showmessage(L('nofound'));
		}
		if ($this->db->delete(array('id'=>$id))) {
			@unlink(SHY_PATH.'templates'.DIRECTORY_SEPARATOR.$this->sitelist[$this->siteid]['default_style'].DIRECTORY_SEPARATOR.'ssi'.DIRECTORY_SEPARATOR.'ssi_'.$id.'.html');
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	//添加SSI分类
 	public function add_type() {
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['type']['name'])) {
				showmessage(L('typename_noempty'),HTTP_REFERER);
			}
			$_POST['type']['siteid'] = $this->get_siteid(); 
			$_POST['type']['module'] = ROUTE_M;
 			$this->db2 = shy_base::load_model('type_model');
			$typeid = $this->db2->insert($_POST['type'],true);
			if(!$typeid) return FALSE;
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_validator = $show_scroll = true;
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=ssi&controller=ssi&view=add\', title:\''.L('add_ssi').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_ssi'));
			include $this->admin_tpl('ssi_type_add');
		}

	}
	public function edit_type() {
		if(isset($_POST['dosubmit'])){ 
			$typeid = intval($_GET['typeid']); 
			if($typeid < 1) return false;
			if(!is_array($_POST['type']) || empty($_POST['type'])) return false;
			if((!$_POST['type']['name']) || empty($_POST['type']['name'])) return false;
			$this->db2->update($_POST['type'],array('typeid'=>$typeid));
			showmessage(L('operation_success'),'?app=ssi&controller=ssi&view=list_type','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			//解出分类内容
			$info = $this->db2->get_one(array('typeid'=>$_GET['typeid']));
			if(!$info) showmessage(L('linktype_exit'));
			extract($info);
			include $this->admin_tpl('ssi_type_edit');
		}

	}
	/**
	 * 删除分类
	 */
	public function delete_type() {
		if((!isset($_GET['typeid']) || empty($_GET['typeid'])) && (!isset($_POST['typeid']) || empty($_POST['typeid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['typeid'])){
				foreach($_POST['typeid'] as $typeid_arr) {
 					$this->db2->delete(array('typeid'=>$typeid_arr));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				$typeid = intval($_GET['typeid']);
				if($typeid < 1) return false;
				$result = $this->db2->delete(array('typeid'=>$typeid));
				if($result)
				{
					showmessage(L('operation_success'),HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"),HTTP_REFERER);
				}
			}
		}
	}

	//添加分类时，验证分类名是否已存在
	public function public_check_name() {
		$type_name = isset($_GET['type_name']) && trim($_GET['type_name']) ? (shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['type_name'])) : trim($_GET['type_name'])) : exit('0');
		$type_name = safe_replace($type_name);
 		$typeid = isset($_GET['typeid']) && intval($_GET['typeid']) ? intval($_GET['typeid']) : '';
 		$data = array();
		if ($typeid) {
 			$data = $this->db2->get_one(array('typeid'=>$typeid), 'name');
			if (!empty($data) && $data['name'] == $type_name) {
				exit('1');
			}
		}
		if ($this->db2->get_one(array('name'=>$type_name), 'typeid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	//:分类管理
 	public function list_type() {
		$this->db2 = shy_base::load_model('type_model');
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'listorder DESC',$page, $pages = '10');
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?app=ssi&controller=ssi&view=add\', title:\''.L('add_ssi').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_ssi'));
		$pages = $this->db2->pages;
		include $this->admin_tpl('ssi_list_type');
	}
 
	public function ssi_update() {
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) :  showmessage(L('illegal_operation'), HTTP_REFERER);
		//进行权限判断
		if (!$data = $this->db->get_one(array('id'=>$id))) {
			showmessage(L('nofound'));
		}
		//print_r($data);
		$ssi = shy_base::load_app_class('ssi_tag');
		
		$r=$ssi->createhtml(SHY_PATH.'templates'.DIRECTORY_SEPARATOR.$this->sitelist[$this->siteid]['default_style'].DIRECTORY_SEPARATOR.'ssi'.DIRECTORY_SEPARATOR.'ssi_'.$data['id'].'.html',$data['data']);//更新模板
		$this->create_ssi($id);
		
		if($r){
			//echo "更新成功";
			showmessage(L('更新成功'));
			}else{
			echo "更新失败";
			};
	}
	
	
	public function public_name() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? (shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['name'])) : trim($_GET['name'])) : exit('0');
		$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
		
		$name = safe_replace($name);
 		
		$data = array();
		if ($id) {
			$data = $this->db->get_one(array('id'=>$id), 'name');
			if (!empty($data) && $data['name'] == $name) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$name), 'id')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	public function public_call(){
		$_GET['id'] = intval($_GET['id']);
		if (!$_GET['id']) showmessage(L('illegal_action'), HTTP_REFERER, '', 'call');
		$r = $this->db->get_one(array('id'=>$_GET['id']));
		include $this->admin_tpl('ssi_call');		
		
	}
		
	//生成ssi碎片
	public function public_ssi() {
		$this->html = shy_base::load_app_class('ssihtml');
		$posid=intval($_GET['posid']);
		$var=getcache('ssi_var','ssi');
		if($posid){
			$size = $this->html->ssi($posid,$var[$posid]['tag']);
		}else{
			
			//print_r($var);
			if(!empty($var)){
				foreach((array)$var as $k=>$row){
					//print_r((int)$row['lastupdate']<time()-(int)$row['cache']);
				 	if((int)$row['lastupdate']<time()-(int)$row['cache']){	
						$size = $this->html->ssi($row['id'],$row['tag']);

						$var[$k]['lastupdate']=time();
					}
				 }
			 setcache('ssi_var',$var,'ssi'); 
			}	 
		}
	}	


	//生成ssi碎片
	private function create_ssi($posid=0) {
		$this->html = shy_base::load_app_class('ssihtml');
		$var=getcache('ssi_var','ssi');
		if($posid){
			$size = $this->html->ssi($posid,$var[$posid]['tag']);
			//print_r($size);exit();
		}else{
			if(!empty($var)){
				foreach($var as $k=>$row){
				 	if(((int)$row['lastupdate']+(int)$row['cache'])>time()){	
						$size = $this->html->ssi($row['id'],$row['tag']);
						}
				 }
			}	 
		}
	}

}
