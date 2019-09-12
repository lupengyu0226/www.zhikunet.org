<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);

class index extends admin {
	public function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('admin_model');
		$this->menu_db = shy_base::load_model('menu_model');
		$this->panel_db = shy_base::load_model('admin_panel_model');
	}
	
	public function init () {
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');
		$roles = getcache('role','commons');
		$rolename = $roles[$_SESSION['roleid']];
		$site = shy_base::load_app_class('sites');
		$sitelist = $site->get_list($_SESSION['roleid']);
		$currentsite = $this->get_siteinfo(param::get_cookie('siteid'));
		/*管理员收藏栏*/
		$adminpanel = $this->panel_db->select(array('userid'=>$userid), "*",20 , 'datetime');
		$site_model = param::get_cookie('site_model');
		include $this->admin_tpl('index');
	}
	
	public function login() {
		if(isset($_GET['dosubmit'])) {
			
			//不为口令卡验证
			if (!isset($_GET['card'])) {
				$username = isset($_POST['username']) ? trim($_POST['username']) : showmessage(L('nameerror'),HTTP_REFERER);
				$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
				if ($_SESSION['code'] != strtolower($code)) {
					$_SESSION['code'] = '';
					showmessage(L('code_error'), HTTP_REFERER);
				}
				$_SESSION['code'] = '';
			} else { //口令卡验证
				if (!isset($_SESSION['card_verif']) || $_SESSION['card_verif'] != 1) {
					showmessage(L('your_password_card_is_not_validate'), '?app=admin&controller=index&view=public_card');
				}
				$username = $_SESSION['card_username'] ? $_SESSION['card_username'] :  showmessage(L('nameerror'),HTTP_REFERER);
			}
			if(!is_username($username)){
				showmessage(L('username_illegal'), HTTP_REFERER);
			}
			//密码错误剩余重试次数
			$this->times_db = shy_base::load_model('times_model');
			$rtime = $this->times_db->get_one(array('username'=>$username,'isadmin'=>1));
			$maxloginfailedtimes = getcache('common','commons');
			$maxloginfailedtimes = (int)$maxloginfailedtimes['maxloginfailedtimes'];

			if($rtime['times'] >= $maxloginfailedtimes) {
				$minute = 60-floor((SYS_TIME-$rtime['logintime'])/60);
				if($minute>0) showmessage(L('wait_1_hour',array('minute'=>$minute)));
			}
			//查询帐号
			$r = $this->db->get_one(array('username'=>$username));
			if(!$r) showmessage(L('user_not_exist'),'?app=admin&controller=index&view=login');
			$password = md5(md5(trim((!isset($_GET['card']) ? $_POST['password'] : $_SESSION['card_password']))).$r['encrypt']);
			
			if($r['password'] != $password) {
				$ip = ip();
				if($rtime && $rtime['times'] < $maxloginfailedtimes) {
					$times = $maxloginfailedtimes-intval($rtime['times']);
					$this->times_db->update(array('ip'=>$ip,'isadmin'=>1,'times'=>'+=1'),array('username'=>$username));
				} else {
					$this->times_db->delete(array('username'=>$username,'isadmin'=>1));
					$this->times_db->insert(array('username'=>$username,'ip'=>$ip,'isadmin'=>1,'logintime'=>SYS_TIME,'times'=>1));
					$times = $maxloginfailedtimes;
				}
				showmessage(L('password_error',array('times'=>$times)),'?app=admin&controller=index&view=login',3000);
			}
			$this->times_db->delete(array('username'=>$username));
			
			//查看是否使用口令卡
			if (!isset($_GET['card']) && $r['card'] && shy_base::load_config('system', 'safe_card') == 1) {
				$_SESSION['card_username'] = $username;
				$_SESSION['card_password'] = $_POST['password'];
				header("location:?app=admin&controller=index&view=public_card");
				exit;
			} elseif (isset($_GET['card']) && shy_base::load_config('system', 'safe_card') == 1 && $r['card']) {//对口令卡进行验证
				isset($_SESSION['card_username']) ? $_SESSION['card_username'] = '' : '';
				isset($_SESSION['card_password']) ? $_SESSION['card_password'] = '' : '';
				isset($_SESSION['card_password']) ? $_SESSION['card_verif'] = '' : '';
			}
			
			$this->db->update(array('lastloginip'=>ip(),'lastlogintime'=>SYS_TIME),array('userid'=>$r['userid']));
			$_SESSION['userid'] = $r['userid'];
			$_SESSION['roleid'] = $r['roleid'];
			$_SESSION['safe_edi'] = random(6,'abcdefghigklmnopqrstuvwxwyABCDEFGHIGKLMNOPQRSTUVWXWY0123456789');
			$_SESSION['lock_screen'] = 0;
			$default_siteid = self::return_siteid();
			$cookie_time = SYS_TIME+86400*30;
			if(!$r['lang']) $r['lang'] = 'zh-cn';
			param::set_cookie('admin_username',$username,$cookie_time);
			param::set_cookie('siteid', $default_siteid,$cookie_time);
			param::set_cookie('userid', $r['userid'],$cookie_time);
			param::set_cookie('admin_email', $r['email'],$cookie_time);
			param::set_cookie('sys_lang', $r['lang'],$cookie_time);
			showmessage(L('login_success'),'?app=admin&controller=index');
		} else {
			shy_base::load_sys_class('form', '', 0);
			include $this->admin_tpl('login');
		}
	}
	
	public function public_card() {
		$username = $_SESSION['card_username'] ? $_SESSION['card_username'] :  showmessage(L('nameerror'),HTTP_REFERER);
		$r = $this->db->get_one(array('username'=>$username));
		if(!$r) showmessage(L('user_not_exist'),'?app=admin&controller=index&view=login');
		if (isset($_GET['dosubmit'])) {
			shy_base::load_app_class('card', 'admin', 0);
			$result = card::verification($r['card'], $_POST['code'], $_POST['rand']);
			$_SESSION['card_verif'] = 1;
			header("location:?app=admin&controller=index&view=login&dosubmit=1&card=1");
			exit;
		}
		shy_base::load_app_class('card', 'admin', 0);
		$rand = card::authe_rand($r['card']);
		include $this->admin_tpl('login_card');
	}
	
	public function public_logout() {
		$_SESSION['userid'] = 0;
		$_SESSION['roleid'] = 0;
		param::set_cookie('admin_username','');
		param::set_cookie('userid',0);
		
		//退出phpsso
		$phpsso_api_url = shy_base::load_config('system', 'phpsso_api_url');
		$phpsso_logout = '<script type="text/javascript" src="'.$phpsso_api_url.'/index.php?app=api&controller=index&op=logout" reload="1"></script>';
		
		showmessage(L('logout_success').$phpsso_logout,'?app=admin&controller=index&view=login');
	}
	
	//左侧菜单
	public function public_menu_left() {
		$menuid = intval($_GET['menuid']);
		$datas = admin::admin_menu($menuid);
		if (isset($_GET['parentid']) && $parentid = intval($_GET['parentid']) ? intval($_GET['parentid']) : 10) {
			foreach($datas as $_value) {
	        	if($parentid==$_value['id']) {
	        		echo '<li id="_M'.$_value['id'].'" class="on top_menu"><a href="javascript:_M('.$_value['id'].',\'?app='.$_value['m'].'&controller='.$_value['c'].'&view='.$_value['a'].'\')" hidefocus="true" style="outline:none;"><span class="icon icon-'.$_value['id'].'"></span>'.L($_value['name']).'</a></li>';
	        		
	        	} else {
	        		echo '<li id="_M'.$_value['id'].'" class="top_menu"><a href="javascript:_M('.$_value['id'].',\'?app='.$_value['m'].'&controller='.$_value['c'].'&view='.$_value['a'].'\')"  hidefocus="true" style="outline:none;"><span class="icon icon-'.$_value['id'].'"></span>'.L($_value['name']).'</a></li>';
	        	}      	
	        }
		} else {
			include $this->admin_tpl('left');
		}
		
	}
	//当前位置
	public function public_current_pos() {
		echo admin::current_pos($_GET['menuid']);
		exit;
	}
	
	/**
	 * 设置站点ID COOKIE
	 */
	public function public_set_siteid() {
		$siteid = isset($_GET['siteid']) && intval($_GET['siteid']) ? intval($_GET['siteid']) : exit('0'); 
		param::set_cookie('siteid', $siteid);
		exit('1');
	}
	
        public function public_ajax_add_panel() {
                $menuid = isset($_POST['menuid']) ? $_POST['menuid'] : exit('0');
                $menuarr = $this->menu_db->get_one(array('id'=>$menuid));
                $url = '?app='.$menuarr['m'].'&controller='.$menuarr['c'].'&view='.$menuarr['a'].'&'.$menuarr['data'];
                $data = array('menuid'=>$menuid, 'userid'=>$_SESSION['userid'], 'name'=>$menuarr['name'], 'url'=>$url, 'datetime'=>SYS_TIME);
                $this->panel_db->insert($data, '', 1);
                $panelarr = $this->panel_db->listinfo(array('userid'=>$_SESSION['userid']), "datetime");
                $delete_panel = shy_base::load_config('system','delpanel');
                foreach($panelarr as $v) {
                        echo "<span><a onclick='paneladdclass(this);' target='right' href='".$v['url'].'&menuid='.$v['menuid']."&safe_edi=".$_SESSION['safe_edi']."'>".L($v['name'])."</a> <a class='panel-delete' href='javascript:delete_panel(".$v['menuid'].");'></a></span>";
                        if($delete_panel==0){
                        echo "<a class='panel-delete' href='javascript:delete_panel(".$v['menuid'].");'></a>";
                        }
                        echo "</span>";
                }
		exit;
	}
	
	public function public_ajax_delete_panel() {
		$menuid = isset($_POST['menuid']) ? $_POST['menuid'] : exit('0');
		$this->panel_db->delete(array('menuid'=>$menuid, 'userid'=>$_SESSION['userid']));

		$panelarr = $this->panel_db->listinfo(array('userid'=>$_SESSION['userid']), "datetime");
		foreach($panelarr as $v) {
			echo "<span><a onclick='paneladdclass(this);' target='right' href='".$v['url']."&safe_edi=".$_SESSION['safe_edi']."'>".L($v['name'])."</a> <a class='panel-delete' href='javascript:delete_panel(".$v['menuid'].");'></a></span>";
		}
		exit;
	}
	public function public_main() {
		shy_base::load_app_func('global');
		shy_base::load_app_func('admin');
		define('SHY_VERSION', shy_base::load_config('version','shy_version'));
		define('SHY_RELEASE', shy_base::load_config('version','shy_release'));
		$this->hot_db = shy_base::load_model('hot_model');
		$this->session_db = shy_base::load_model('session_model');
		$this->member_db = shy_base::load_model('member_model');
		$this->sphinx_counter_db = shy_base::load_model('sphinx_counter_model');
		$sphinx_counter = $this->sphinx_counter_db->get_one(array('counter_id'=>'1'));
        $total_hot_check = $this->hot_db->count();
        $total_session_online = $this->session_db->count("ip");
		$total_member = $this->member_db->count();	//会员总数
		$todaytime = strtotime(date('Y-m-d', SYS_TIME));	//今日会员数
		$today_member = $this->member_db->count("`regdate` > '$todaytime'");
		$models = getcache('model','commons');
		$allcount = 0;
		foreach ($models as $modelid=>$model) {
		    foreach(getcache('category_items_'.$modelid,'commons') as $cat){
		        $allcount += intval($cat);
		    }			
		}
		$admin_username = param::get_cookie('admin_username');
		$roles = getcache('role','commons');
		$userid = $_SESSION['userid'];
		$rolename = $roles[$_SESSION['roleid']];
		$r = $this->db->get_one(array('userid'=>$userid));
		$logintime = $r['lastlogintime'];
		$loginip = $r['lastloginip'];
		$sysinfo = get_sysinfo();
		$sysinfo['mysqlv'] = $this->db->version();
		$show_header = $show_safe_edi = 1;
		/*检测框架目录可写性*/
		$pc_writeable = is_writable(SHY_PATH.'feitian.php');
		$common_cache = getcache('common','commons');
		$logsize_warning = errorlog_size() > $common_cache['errorlog_size'] ? '1' : '0';
		$adminpanel = $this->panel_db->select(array('userid'=>$userid), '*',20 , 'datetime');
		$product_copyright = '沭阳科力网络科技有限公司';
		$programmer = '马玉辉、张明雪、李天会、潘兆志';
 		$designer = '张二强';
		ob_start();
		include $this->admin_tpl('main');
		$data = ob_get_contents();
		ob_end_clean();
		system_information($data);
	}
	/**
	 * 维持 session 登陆状态
	 */
	public function public_session_life() {
		$userid = $_SESSION['userid'];
		return true;
	}
	/**
	 * 锁屏
	 */
	public function public_lock_screen() {
		$_SESSION['lock_screen'] = 1;
	}
	public function public_login_screenlock() {
		if(empty($_GET['lock_password'])) showmessage(L('password_can_not_be_empty'));
		//密码错误剩余重试次数
		$this->times_db = shy_base::load_model('times_model');
		$username = param::get_cookie('admin_username');
		$maxloginfailedtimes = getcache('common','commons');
		$maxloginfailedtimes = (int)$maxloginfailedtimes['maxloginfailedtimes'];
		
		$rtime = $this->times_db->get_one(array('username'=>$username,'isadmin'=>1));
		if($rtime['times'] > $maxloginfailedtimes-1) {
			$minute = 60-floor((SYS_TIME-$rtime['logintime'])/60);
			exit('3');
		}
		//查询帐号
		$r = $this->db->get_one(array('userid'=>$_SESSION['userid']));
		$lockscreen = md5(md5($_GET['lock_password']).$r['lockscreenencrypt']);
		if($r['lockscreen'] != $lockscreen) {
			$ip = ip();
			if($rtime && $rtime['times']<$maxloginfailedtimes) {
				$times = $maxloginfailedtimes-intval($rtime['times']);
				$this->times_db->update(array('ip'=>$ip,'isadmin'=>1,'times'=>'+=1'),array('username'=>$username));
			} else {
				$this->times_db->insert(array('username'=>$username,'ip'=>$ip,'isadmin'=>1,'logintime'=>SYS_TIME,'times'=>1));
				$times = $maxloginfailedtimes;
			}
			exit('2|'.$times);//密码错误
		}
		$this->times_db->delete(array('username'=>$username));
		$_SESSION['lock_screen'] = 0;
		exit('1');
	}
	
	//后台站点地图
	public function public_map() {
		 $array = admin::admin_menu(0);
		 $menu = array();
		 foreach ($array as $k=>$v) {
		 	$menu[$v['id']] = $v;
		 	$menu[$v['id']]['childmenus'] = admin::admin_menu($v['id']);
		 }
		 $show_header = true;
		 include $this->admin_tpl('map');
	}

	/**
	 * @设置网站模式 设置了模式后，后台仅出现在此模式中的菜单
	 */
	public function public_set_model() {
		$model = $_GET['site_model'];
		if (!$model) {
			param::set_cookie('site_model','');
		} else {
			$models = shy_base::load_config('model_config');
			if (in_array($model, array_keys($models))) {
				param::set_cookie('site_model', $model);
			} else {
				param::set_cookie('site_model','');
			}
		}
		$menudb = shy_base::load_model('menu_model');
		$where = array('parentid'=>0,'display'=>1);
		if ($model) {
			$where[$model] = 1;
 		}
		$result =$menudb->select($where,'id',1000,'listorder ASC');
		$menuids = array();
		if (is_array($result)) {
			foreach ($result as $r) {
				$menuids[] = $r['id'];
			}
		}
		exit(json_encode($menuids));
	}

}
?>