<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
class weixin extends admin {
	private $addmenu;
	private $db;
	private $dbmenuevent;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('weixin', 'commons'));
		$this->db = shy_base::load_model('weixin_menu_model');
		$this->dbmenuevent = shy_base::load_model('weixin_menuevent_model');
		$this->dbkeyword = shy_base::load_model('weixin_replykeyword_model');
		$this->replyword = shy_base::load_model('weixin_keyword_model');
		shy_base::load_app_func('global','weixin');
	}
    //默认页面显示查询菜单
	public function init() {
		
		$menus =$this->dbmenuevent->listinfo(array('siteid'=>$this->get_siteid()),$order = 'path,id');	
		$arr=array();
		foreach($menus as $datas){
		      $arr[] =array( "id"=>$datas['id'], "pid"=>$datas['pid'],"name"=>$datas['name']);				  	   
		}
		 $showmenu=$arr;
		
		include $this->admin_tpl('weixin_list');
	}
	public function menushow(){
		$access_token = get_access_token();
		if($access_token){
		$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$access_token;
        $result = https_request($url);
	    $arr=json_decode($result, true);
		$arrmenu = $arr['menu']['button'][0];
		$fmenu = $arr['menu']['button'];
		}
		$pid_num=count($fmenu);
		$array=array();
		$son_array=array();
		foreach((array)$fmenu as $k=>$v){
			$array[]=array('id'=>$k+1,'pid'=>0,'name'=>$v['name']);
			foreach($v['sub_button'] as $ks=>$vs){
				$son_array[]=array('id'=>$ks+1,'pid'=>$k+1,'name'=>$vs['name']);
			}
			
			}

		$nson_array=array();
        foreach($son_array as $sk=>$sv){
			$nson_array[]=array('id'=>$sk+$pid_num+1,'pid'=>$sv['pid'],'name'=>$sv['name']);
		}
		$new_arr=array_merge($array,$nson_array);
		
		include $this->admin_tpl('weixin_menu_show');
	}
	public function addpmenu(){
		$pid = intval($_GET['id']);
		if(isset($_POST['dosubmit'])) {
			$minfo =$this->dbmenuevent->listinfo(array('siteid'=>$this->get_siteid(),'pid'=>0),$order = 'path,id');
			if(count($minfo)>=3){
				
				 showmessage('主菜单最多只能3个！',HTTP_REFERER);
			}
			$_POST['menu']['pid'] = 0;
			$_POST['menu']['addtime'] = SYS_TIME;
			
			$_POST['menu']['siteid'] = $this->get_siteid();
			if(empty($_POST['menu']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['menu']['name'] = safe_replace($_POST['menu']['name']);
			}
			
			$data = new_addslashes($_POST['menu']);
			$menuid = $this->dbmenuevent->insert($data,true);
			$this->dbmenuevent->update(array('key'=>'A'.$menuid),array('id'=>$menuid));
			if(!$menuid) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=weixin&view=addpmenu','', 'addpmenu');
		}
		include $this->admin_tpl('weixin_addpmenu');
		}
	//添加菜单
 	public function addsmenu() {
 		$pid = intval($_GET['id']);
		$infos = $this->dbmenuevent->get_one(array('id'=>$pid));
		
		if(isset($_POST['dosubmit'])) {
			
			$_POST['menu']['key'] = "A".$_POST['menu']['pid'];
			$_POST['menu']['addtime'] = SYS_TIME;
			$_POST['menu']['siteid'] = $this->get_siteid();
			if(empty($_POST['menu']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['menu']['name'] = safe_replace($_POST['menu']['name']);
			}
			$data = new_addslashes($_POST['menu']);
			
			$menuid = $this->dbmenuevent->insert($data,true);
			
			if($menuid){
				$this->dbmenuevent->update(array('key'=>"A".$menuid),array('id'=>$menuid));
			}else{
				return FALSE;
			}
			showmessage(L('operation_success'),'?app=weixin&controller=weixin&view=addsmenu','', 'addsmenu');
			
		}
		
		include $this->admin_tpl('weixin_addsmenu');
	}
	//修改菜单
 	public function editmenu() {
 		$id = intval($_GET['id']);
		$infos = $this->dbmenuevent->get_one(array('id'=>$id));

		if(isset($_POST['dosubmit'])) {
			$updatetime = SYS_TIME;
			if(empty($_POST['menu']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$name = safe_replace($_POST['menu']['name']);
			}
			$data = new_addslashes($_POST['menu']);
			$menuid=$this->dbmenuevent->update(array('name'=>$name,'updatetime'=>$updatetime),array('id'=>$id));
			if(!$menuid) return FALSE;
			showmessage(L('operation_success'),'?app=weixin&controller=weixin&view=editmenu','', 'editmenu');
		}
		include $this->admin_tpl('weixin_editmenu');
	}
	/**
	 * 添加微信自定义菜单响应事件
	 */
	public function addevent(){
		$id = intval($_GET['id']);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$keywords = $this->dbkeyword-> listinfo('','',$page, $pages = '30');
		$pages = $this->dbkeyword->pages;
		$thumb = '<img src="'.IMG_PATH.'icon/small_img.gif" style="padding-bottom:2px" \'">';
		if(isset($_POST['dosubmit'])) {  
			 if(trim($_POST['weixin']['url'])==''){
			 $_POST['weixin']['url']='';
			 }elseif($_POST['weixin']['replyid']==0){
				 $_POST['weixin']['replyid'] = 0;
			 }elseif($_POST['weixin']['replyid']!==0 && trim($_POST['weixin']['url'])!==''){
				 $this->dbmenuevent->update(array('Url'=>'','replyid'=>0),array('id'=>$id));
				 showmessage(L("事件类型只能二选其一，请重新填写！"),HTTP_REFERER);
			 }			 
			 
			$this->dbmenuevent->update($_POST['weixin'],array('id'=>$id));
			showmessage(L('operation_success'),'?app=weixin&controller=weixin&view=addevent','', 'addevent');
		}
		shy_base::load_sys_class('form', '', 0);
		$infos = $this->dbmenuevent->get_one(array('id'=>$id));
		include $this->admin_tpl('weixin_addevent');
		}
	/**
	 * 添加微信自定义菜单
	 */
	public function add(){
		if(isset($_POST['dosubmit'])) {
			$_POST['weixin']['updatetime'] = SYS_TIME;
			$_POST['weixin']['siteid'] = $this->get_siteid();
			if(empty($_POST['weixin']['menu'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['weixin']['menu'] = $_POST['weixin']['menu'];
			}			
			$data =$_POST['weixin'];			
			$weixinid=$this->db->update($data,array('id'=>1));
			if(!$weixinid) return FALSE; 
 			$siteid = $this->get_siteid();	 		
			$this->update_menu();
		}
		$jsonmenu = $this->get_jsonmenu();
		include $this->admin_tpl('weixin_add');
		}
	public function fabu(){
		if(isset($_POST['dosubmit'])) {
			$this->update_menu();
		}
	}
	public function fabuyixin(){
		if(isset($_POST['dosubmit'])) {
			$this->update_yixin_menu();
		}
	}
	//创建微信自定义菜单
	public function update_menu(){
	$access_token = get_access_token();
	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
	$jsonmenu = $this->get_jsonmenu();
    $result = https_request($url, $jsonmenu);
	$arr=json_decode($result, true); 
	if($arr['errcode']==0 && $arr['errmsg']=='ok'){
	  showmessage(L('operation_success'),HTTP_REFERER);
	}else{
		showmessage(L("operation_failure"),HTTP_REFERER);
		}
	}
	//创建易信自定义菜单
	public function update_yixin_menu(){
	$yixin_access_token = get_yixin_access_token();
	$url = "https://api.yixin.im/cgi-bin/menu/create?access_token=".$yixin_access_token;
	$jsonmenu = $this->get_jsonmenu();
    $result = https_request($url, $jsonmenu);
	$arr=json_decode($result, true); 
	if($arr['errcode']==0 && $arr['errmsg']=='请求成功'){
	  showmessage(L('operation_success'),HTTP_REFERER);
	}else{
		showmessage(L("operation_failure"),HTTP_REFERER);
		}
	}
	//删除自定义菜单
	public function delete_menu(){
		$access_token = get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token;
		$result = https_request($url);	
		$arr=json_decode($result, true); 
		if($arr['errcode']==0 && $arr['errmsg']=='ok'){
		  showmessage(L('operation_success'),HTTP_REFERER);
		}else{
			showmessage(L("operation_failure"),HTTP_REFERER);
			}
	}

	/**
	*获取json菜单
	*/
	public function get_jsonmenu(){
		$where="pid >0";
		$data =$this->dbmenuevent->listinfo($where,$order = 'id ASC');
			
		$array=array();
		//从数据表中获取指定的数据组成一个新的数组$array
		foreach($data as $m){			
		    $array[] =array( "id"=>$m['id'], "pid"=>$m['pid'],"name"=>$m['name'],"type"=>$m['type'],"key"=>$m['key'],"url"=>$m['Url'],"program"=>$m['program'],"pagepath"=>$m['pagepath']);		   
		}
		//获取父菜单()
		$pdata =$this->dbmenuevent->listinfo(array('siteid'=>$this->get_siteid(),'pid'=>0),$order = 'id ASC');
		  foreach($pdata as $pm){			
				if(trim($pm['type'])=='view'){		
				$parr[] =array( "id"=>$pm['id'], "pid"=>$pm['pid'],"name"=>$pm['name'],"type"=>$pm['type'],"url"=>$pm['Url']);	
				}elseif(trim($pm['type'])=='click'){
				$parr[] =array( "id"=>$pm['id'], "pid"=>$pm['pid'],"name"=>$pm['name'],"type"=>$pm['type'],"key"=>$pm['key']);
				}else{
				$parr[] =array( "id"=>$pm['id'], "pid"=>$pm['pid'],"name"=>$pm['name']);	
				}
		  }
		/*
		//如果父菜单有子菜单（下面这种）
		*/
		foreach($parr as $key=>$pm){
			foreach($array as $son){
			  if($pm['id']==$son['pid']){
				if(trim($son['type'])=='view'){
				$parr[$key]['sub_button'][]=array('id'=>$son['id'],'pid'=>$son['pid'],'name'=>$son['name'],"type"=>$son['type'],"url"=>$son['url']);
				  }elseif(trim($son['type'])=='click'){
				$parr[$key]['sub_button'][]=array('id'=>$son['id'],'pid'=>$son['pid'],'name'=>$son['name'],"type"=>$son['type'],"key"=>$son['key']);
				  }elseif(trim($son['type'])=='miniprogram'){
				$parr[$key]['sub_button'][]=array('id'=>$son['id'],'pid'=>$son['pid'],'name'=>$son['name'],"type"=>$son['type'],"url"=>$son['url'],"appid"=>$son['program'],"pagepath"=>$son['pagepath']);
				  }
			}
		    }
		}
		//删除无用的数组元素
		foreach($parr as $k=>$v){
			
			unset($parr[$k]['id']);
			unset($parr[$k]['pid']);
			if(is_array($parr[$k]['sub_button'])){
				foreach($parr[$k]['sub_button'] as $j=>$d){
					unset($parr[$k]['sub_button'][$j]['id']);
					unset($parr[$k]['sub_button'][$j]['pid']);
				}
				}
					
				}	
		$button=array();
		$button['button']=$parr;
		//print_r($button);exit;
		return JSON($button);
		 
	}
	/**
	 * 微信模块配置
	 */
	public function setting() {
		$big_menu = array('javascript:;', L('核心配置'));
		//读取配置文件
		$data = array();
		$siteid=$this->get_siteid()?$this->get_siteid():1;//当前站点
		$url = APP_PATH.'index.php?app=weixin&controller=weixinapi&view=init'; 
		$wapurl = MOBILE_PATH.'index.php'; 
		$m_db = shy_base::load_model('module_model');
		$data = $m_db->select(array('module'=>'weixin'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; //当前站点配置
		$data = $now_seting;
		if(isset($_POST['dosubmit'])) {
			//多站点存储配置文件
			if($_POST['setting']['token']==''||$_POST['setting']['appid']==''||$_POST['setting']['appsecret']==''||$_POST['setting']['yixin_appid']==''||$_POST['setting']['kefus']==''||$_POST['setting']['kefux']==''||$_POST['setting']['yixin_appsecret']==''||$_POST['setting']['thumb']==''){
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			}else{
				$_POST['setting']['token']=trim($_POST['setting']['token']);
				$_POST['setting']['appid']=trim($_POST['setting']['appid']);
				$_POST['setting']['appsecret']=trim($_POST['setting']['appsecret']);
				$_POST['setting']['yixin_appid']=trim($_POST['setting']['yixin_appid']);
				$_POST['setting']['yixin_appsecret']=trim($_POST['setting']['yixin_appsecret']);
				$_POST['setting']['kefus']=trim($_POST['setting']['kefus']);
				$_POST['setting']['kefux']=trim($_POST['setting']['kefux']);
				$_POST['setting']['thumb']=trim($_POST['setting']['thumb']);
			}
 			$setting[$siteid] = $_POST['setting'];
  			setcache('weixin', $setting, 'commons');  
  			$m_db = shy_base::load_model('module_model'); //调用模块数据模型
			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			showmessage(L('operation_success'), '?app=weixin&controller=weixin&view=setting');
		} else {
			@extract($now_seting);
			shy_base::load_sys_class('form', '', 0);
 			include $this->admin_tpl('setting');
		}
	}
	/**
	 * 删除微信菜单  
	 */
	public function delete() {
  		if((!isset($_GET['id']) || empty($_GET['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			
		  $id = intval($_GET['id']);
		  if($id < 1) return false;
		  //如果删除的是父菜单
		  $data =$this->dbmenuevent->listinfo(array('pid'=>$id));
		  $idarr = array();
		  foreach($data as $ids){			
		  $idarr[] =$ids['id'];		   
		  }
		  if(count($idarr) > 0){
			foreach($idarr as $id_arr) {
				//批量删除子菜单
				$this->dbmenuevent->delete(array('id'=>$id_arr));
			}
		  }
			  $result = $this->dbmenuevent->delete(array('id'=>$id));
			  
			  if($result){
				  showmessage(L('operation_success'),'?app=weixin&controller=weixin');
			  }else {
				  showmessage(L("operation_failure"),'?app=weixin&controller=weixin');
			  }
		  }
		  showmessage(L('operation_success'), HTTP_REFERER);
	  }
	public function replyword() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$data =$this->replyword->listinfo(array('type'=>'text'),$order = 'id DESC', $page, 20);
		$pages = $this->replyword->pages;
		include $this->admin_tpl('weixin_replyword');
	}
	public function tupianword() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$data =$this->replyword->listinfo(array('type'=>'image'),$order = 'id DESC', $page, 20);
		$pages = $this->replyword->pages;
		include $this->admin_tpl('weixin_tupianword');
	}
	/**
	 * 删除
	 */
	public function replyword_delete() {
  		if((!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $keywordid_arr) {
 					//批量删除
					$this->replyword->delete(array('id'=>$keywordid_arr));
				}
				showmessage(L('operation_success'),'?app=weixin&controller=weixin&view=replyword&menuid=2850');
			}
		}
	}
	function replyword_status() {
		 $passed = intval($_GET['passed']) && intval($_GET['passed'])== 1 ? '1' : '0';
		 $id = intval($_GET['id']) ? intval($_GET['id']) : showmessage(L('参数错误'),HTTP_REFERER);
		 $this->replyword->update(array('passed'=>$passed), array('id'=>$id));
		 showmessage(L('操作成功'),HTTP_REFERER);
	}
}
?>