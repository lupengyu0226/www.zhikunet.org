<?php
defined('IN_SHUYANG') or exit('The resource access forbidden.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form','',0);
class zhuanlan extends admin {
	function __construct() {
		parent::__construct();
        $this->siteid = $this->get_siteid();
        $this->module_db = shy_base::load_model('module_model');
        $this->zhuanlan_db = shy_base::load_model('zhuanlan_model');
        $this->zhuanlan_caches = shy_base::load_app_class('zhuanlan_cache','zhuanlan');
	}


    public function init (){
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$list = $this->zhuanlan_db->listinfo('',$order = 'id DESC',$page, $pages = '20');
		$pages = $this->zhuanlan_db->pages;
        include $this->admin_tpl('zhuanlan_list');   
    }

    public function edit (){
    	if(isset($_GET['id'])) $id=intval($_GET['id']);
    	if(!$id) exit();
    	if(isset($_POST['dosubmit'])) {
			//print_r($_POST['info']);
			$info=array();
			$info=$_POST['info'];
			$this->zhuanlan_db->update($info,array('id'=>$id));
			$this->zhuanlan_caches->_cache();
			showmessage(L('operation_success'), '', '', 'edit');
		}else{
			$data = $this->zhuanlan_db->get_one(array('id'=>$id));
			if(!empty($data)){
				//extract($data);
				$show_validator = $show_scroll = $show_header = true;
				include $this->admin_tpl('zhuanlan_edit');
			}
		}
	}
	/**
	 * 删除专栏作家  
	 * @param	intval	$id	作家ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
 					//批量删除专栏作家
					$this->zhuanlan_db->delete(array('id'=>$id_arr));
				}
				showmessage(L('operation_success'),'?app=zhuanlan&controller=zhuanlan');
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;
				//删除专栏作家
				$result = $this->zhuanlan_db->delete(array('id'=>$id));
				if($result){
					showmessage(L('operation_success'),'?app=zhuanlan&controller=zhuanlan');
				}else {
					showmessage(L("operation_failure"),'?app=zhuanlan&controller=zhuanlan');
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	public function setting() {
		$siteid = get_siteid();
		if(isset($_POST['dosubmit'])) {
			//合并数据库缓存与新提交缓存
			$r = $this->module_db->get_one(array('module'=>'zhuanlan'));
			$zhuanlan_setting = string2array($r['setting']);
			
			$zhuanlan_setting[$siteid] = $_POST['setting'];
			$setting = array2string($zhuanlan_setting);
			setcache('zhuanlan_setting',$zhuanlan_setting,'zhuanlan');
            $this->module_db->update(array('setting'=>$setting),array('module'=>'zhuanlan'));
			//$this->zhuanlan_caches->_cache();
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
            
            $r = $this->module_db->get_one(array('module'=>'zhuanlan'));
            $setting = string2array($r['setting']);
			if($setting[$siteid]){
				extract($setting[$siteid]);
            }
            $show_validator = '';
			include $this->admin_tpl('zhuanlan_setting');
		}
	}

	/**
	 * 专栏搜索
	 */
	function search() {
		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';	
		$type = isset($_GET['type']) ? $_GET['type'] : '';	
		if (isset($_GET['search'])) {
			if($keyword) {
				if ($type == '1') {
					$where .= "`username` LIKE '%$keyword%'";
				} elseif($type == '2') {
					$where .= "`domain` = '$keyword'";
				} elseif($type == '3') {
					$where .= "`name` like '%$keyword%'";
				} elseif($type == '4') {
					$where .= "`id` = '$keyword'";
				} else {
					$where .= "`username` like '%$keyword%'";
				}
			} else {
				$where .= '1';
			}
			
		} else {
			$where = '';
		}

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$list = $this->zhuanlan_db->listinfo($where, 'id DESC', $page, 15);
		$pages = $this->zhuanlan_db->pages;
		$big_menu = array('?app=zhuanlan&controller=zhuanlan&view=init&menuid=2829', L('沭阳号搜索'));
		include $this->admin_tpl('zhuanlan_list');
	}

	
}
?>