<?php
defined('IN_SHUYANG') or exit('No permission resources.');
class ajax{
		
private function _session_start() {
		$session_storage = 'session_'.shy_base::load_config('system','session_storage');
		shy_base::load_sys_class($session_storage);
	}

public function login(){
		$this->db = shy_base::load_model('member_model');
		$this->_session_start();
		//获取用户siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定义站点id常量
		if (!defined('SITEID')) {define('SITEID', $siteid);}
		
		if(isset($_POST['dosubmit'])) {
			//判断验证码
			//if(empty($_SESSION['connectid'])) {	
			//	$code = trim($_POST['code']);
			//	if ($_SESSION['code'] != strtolower($code)) {echo -5; exit;}
			//}
			$username = isset($_POST['username']) && trim(iconv("UTF-8","gb2312",$_POST['username'])) ? trim(iconv("UTF-8","gb2312",$_POST['username'])) : showmessage(L('username_empty'), HTTP_REFERER);
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_empty'), HTTP_REFERER);
			$cookietime = intval($_POST['cookietime']);
			$synloginstr = ''; //同步登陆js代码
			
			if(shy_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$status = $this->client->ps_member_login($username, $password);
				$memberinfo = unserialize($status);
				
				if(isset($memberinfo['uid'])) {
					//查询帐号
					$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
					if(!$r) {
						//插入会员详细信息，会员不存在 插入会员
						$info = array(
									'phpssouid'=>$memberinfo['uid'],
						 			'username'=>$memberinfo['username'],
						 			'password'=>$memberinfo['password'],
						 			'encrypt'=>$memberinfo['random'],
						 			'email'=>$memberinfo['email'],
						 			'regip'=>$memberinfo['regip'],
						 			'regdate'=>$memberinfo['regdate'],
						 			'lastip'=>$memberinfo['lastip'],
						 			'lastdate'=>$memberinfo['lastdate'],
						 			'groupid'=>$this->_get_usergroup_bypoint(),	//会员默认组
						 			'modelid'=>10,	//普通会员
									);
									
						//如果是connect用户
						if(!empty($_SESSION['connectid'])) {
							$userinfo['connectid'] = $_SESSION['connectid'];
						}
						if(!empty($_SESSION['from'])) {
							$userinfo['from'] = $_SESSION['from'];
						}
						unset($_SESSION['connectid'], $_SESSION['from']);
						
						$this->db->insert($info);
						unset($info);
						$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
					}
					$password = $r['password'];
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
 				} else { if($status == -1) {	echo -1;exit; } elseif($status == -2) { echo -2;exit;	} else {	echo -3;exit; } }
				
			} else {
				//密码错误剩余重试次数
				$this->times_db = shy_base::load_model('times_model');
				$rtime = $this->times_db->get_one(array('username'=>$username));
				if($rtime['times'] > 4) {
					$minute = 60 - floor((SYS_TIME - $rtime['logintime']) / 60);
					echo -4;exit;
				}
				
				//查询帐号
				$r = $this->db->get_one(array('username'=>$username));

				if(!$r) {echo -6;exit;}
				
				//验证用户密码
				$password = md5(md5(trim($password)).$r['encrypt']);
				if($r['password'] != $password) {				
					$ip = ip();
					if($rtime && $rtime['times'] < 5) {
						$times = 5 - intval($rtime['times']);
						$this->times_db->update(array('ip'=>$ip, 'times'=>'+=1'), array('username'=>$username));
					} else {
						$this->times_db->insert(array('username'=>$username, 'ip'=>$ip, 'logintime'=>SYS_TIME, 'times'=>1));
						$times = 5;
					}
					echo -2;exit;
				}
				$this->times_db->delete(array('username'=>$username));
			}
			
			//如果用户被锁定
			if($r['islock']) {echo -7;exit;}
			
			$userid = $r['userid'];
			$groupid = $r['groupid'];
			$username = $r['username'];
			$nickname = empty($r['nickname']) ? $username : $r['nickname'];
			
			$updatearr = array('lastip'=>ip(), 'lastdate'=>SYS_TIME);
			//vip过期，更新vip和会员组
			if($r['overduedate'] < SYS_TIME) {
				$updatearr['vip'] = 0;
			}		

			//检查用户积分，更新新用户组，除去邮箱认证、禁止访问、游客组用户、vip用户，如果该用户组不允许自助升级则不进行该操作		
			if($r['point'] >= 0 && !in_array($r['groupid'], array('1', '7', '8')) && empty($r['vip'])) {
				$grouplist = getcache('grouplist');
				if(!empty($grouplist[$r['groupid']]['allowupgrade'])) {	
					$check_groupid = $this->_get_usergroup_bypoint($r['point']);
	
					if($check_groupid != $r['groupid']) {
						$updatearr['groupid'] = $groupid = $check_groupid;
					}
				}
			}

			//如果是connect用户
			if(!empty($_SESSION['connectid'])) {
				$updatearr['connectid'] = $_SESSION['connectid'];
			}
			if(!empty($_SESSION['from'])) {
				$updatearr['from'] = $_SESSION['from'];
			}
			unset($_SESSION['connectid'], $_SESSION['from']);
						
			$this->db->update($updatearr, array('userid'=>$userid));
			
			if(!isset($cookietime)) {
				$get_cookietime = param::get_cookie('cookietime');
			}
			$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
			$cookietime = $_cookietime ? SYS_TIME + $_cookietime : 0;
			
			$shuyang_auth_key = md5(shy_base::load_config('system', 'auth_key').$_SERVER['HTTP_USER_AGENT']);
			$shuyang_auth = sys_auth($userid."\t".$password, 'ENCODE', $shuyang_auth_key);
			param::set_cookie('auth', $shuyang_auth, $cookietime);
			param::set_cookie('_userid', $userid, $cookietime);
			param::set_cookie('_username', $username, $cookietime);
			param::set_cookie('_groupid', $groupid, $cookietime);
			param::set_cookie('_nickname', $nickname, $cookietime);
			//param::set_cookie('cookietime', $_cookietime, $cookietime);
			echo 1;
		} else {
				if(param::get_cookie('_userid')){
				$arr[userid] = param::get_cookie('_userid');
				$arr[username] = iconv("gb2312","UTF-8",param::get_cookie('_username'));
				$arr[nickname] =iconv("gb2312","UTF-8",param::get_cookie('_nickname'));
				$arr['success'] = 1;}else{$arr['success'] = 0;}
				echo json_encode($arr);}
				}
private function _init_phpsso() {
		shy_base::load_app_class('client', '', 0);
		define('APPID', shy_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = shy_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = shy_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
public function logout() {
		$setting = shy_base::load_config('system');
		//snda退出
		if($setting['snda_enable'] && param::get_cookie('_from')=='snda') {
			param::set_cookie('_from', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? urlencode($_GET['forward']) : '';
			$logouturl = 'https://cas.sdo.com/cas/logout?url='.urlencode(APP_PATH.'index.php?app=member&controller=index&view=logout&forward='.$forward);
			header('Location: '.$logouturl);
		} else {
			$synlogoutstr = '';	//同步退出js代码
			if(shy_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$synlogoutstr = $this->client->ps_member_synlogout();			
			}
			
			param::set_cookie('auth', '');
			param::set_cookie('_userid', '');
			param::set_cookie('_username', '');
			param::set_cookie('_groupid', '');
			param::set_cookie('_nickname', '');
			param::set_cookie('cookietime', '');
			echo 1;
		}
		}
}
?>
