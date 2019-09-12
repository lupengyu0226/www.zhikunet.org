<?php 
defined('IN_SHUYANG') or exit('No permission resources.'); 
class EDI_index extends index { 
    private $times_db;
    public function __construct() { 
        parent::__construct(); 
        $this->press_db = shy_base::load_model('press_model');
    } 
	public function top_mini() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		$jsoncallback=isset($_GET['jsoncallback']) ? $_GET['jsoncallback'] : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		if($_username){
			$res["success"]=1;
			$res["message"]='&nbsp;&nbsp;'.L('hellow').'<a href="'.PASSPORT_PATH.'member-account_manage_avatar.html" target="_blank"><img style="display:inline;vertical-align: middle;padding:1px;width:16px;height:16px;border-radius:100%;border:1px solid #dedede;" src="'.is_avatar(get_memberavatar($_userid,1,30)).'" width="16" height="16" onerror="this.src=\''.IMG_PATH.'member/nophoto.gif\'"></a>&nbsp;'.get_nickname().' 欢迎回家 <a href="'.PASSPORT_PATH.'member-index.html" target="_blank">'.L('member_center').'</a> | <a href="'.PASSPORT_PATH.'member-fabu.html" target="_top" class="upv_btn">发布信息</a> | <a href="'.PASSPORT_PATH.'member-logout.html">'.L('logout').'</a>';
			$res["message"] = shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'utf-8', $res["message"]) : $res["message"];
			//get_nickname();//,
			
			}
		else{
			$res["success"]=0;
			}
			
		if($jsoncallback){
      		echo $jsoncallback . "({\"items\":[".json_encode($res)."]})";
		}else{
			echo json_encode($res);
		}
		//echo json_encode($res);
	}

	/**
	 * 我的评论
	 * 
	 */
	public function comment() {
		$comment_data_db = shy_base::load_model('mycomment_model');
		$this->_session_start();
		$_SESSION['userid'] = $this->memberinfo['userid'];
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		if(isset($_GET['id']) && trim($_GET['id'])) {
		$comment_data_db->delete(array('userid'=>$memberinfo['userid'], 'id'=>intval($_GET['id'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			    $page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
                $commentlist = $comment_data_db->listinfo(array('userid'=>$memberinfo['userid']), 'id DESC', $page, 10);
				$pages = $comment_data_db->pages;
                include template('member', 'comment_list');
		}
	}

	/**
	 * 我的请求
	 * 
	 */
	public function press() {
		$press_data_db = shy_base::load_model('press_model');
		$this->_session_start();
		$_SESSION['userid'] = $this->memberinfo['userid'];
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		if(isset($_GET['id']) && trim($_GET['id'])) {
		$press_data_db->delete(array('userid'=>$memberinfo['userid'], 'id'=>intval($_GET['id'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			    $page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
                $presslist = $press_data_db->listinfo(array('userid'=>$memberinfo['userid']), 'id DESC', $page, 10);
				$pages = $press_data_db->pages;
                include template('member', 'press_list');
		}
	}
	/**
	 * 稿件请求提交
	 * 
	 */
	public function account_press() {
		$memberinfo = $this->memberinfo;
		$this->_session_start();
		if($memberinfo['point'] < '10000') showmessage('你积分不足');
		$_SESSION['userid'] = $this->_userid;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		//判断当前会员，是否可发，短消息．
		//$this->message_db->messagecheck($this->_userid);
		if(isset($_POST['dosubmit'])) {
			$username = $this->_username;
			$userid = $this->memberinfo['userid'];
			$title = safe_replace($_POST['info']['title']);
			$url = new_html_special_chars($_POST['info']['url']);
			$content = new_html_special_chars($_POST['info']['content']);
			$this->press_db->add_press($username,$userid,$title,$url,$content,true);
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_validator = $show_scroll = $show_header = true;
			include template('member', 'account_press');
		}
	}

	public function blog_mini() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		$jsoncallback=isset($_GET['jsoncallback']) ? $_GET['jsoncallback'] : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		if($_username){
			$res["success"]=1;
			$res["message"]='&nbsp;<a href="'.PASSPORT_PATH.'member-account_manage_avatar.html" target="_blank"><img style="display:inline;vertical-align: middle;padding:2px; width:45px; height:45px;border-radius:100%;border:2px solid #dedede;" src="'.is_avatar(get_memberavatar($_userid,1,90)).'" width="45" height="45" onerror="this.src=\''.IMG_PATH.'member/nophoto.gif\'"></a>&nbsp;&nbsp;&nbsp;&nbsp;'.L('hellow').get_nickname().' 欢迎回家<br><br> <li><a  class="db_bdr btn_lab4" href="'.PASSPORT_PATH.'member-index.html" target="_blank">'.L('member_center').'</a></li><li><a class="db_bdr btn_lab2"  href="'.PASSPORT_PATH.'member-fabu.html" target="_top" class="upv_btn">发布信息</a></li><li><a class="db_bdr btn_lab2"  href="'.PASSPORT_PATH.'member-logout.html">'.L('logout').'</a></li>';
			$res["message"] = shy_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'utf-8', $res["message"]) : $res["message"];
			//get_nickname();//,
			
			}
		else{
			$res["success"]=0;
			}
			
		if($jsoncallback){
      		echo $jsoncallback . "({\"items\":[".json_encode($res)."]})";
		}else{
			echo json_encode($res);
		}
		//echo json_encode($res);
	}		
	//弹出发布菜单
	public function menu() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$this->_session_start();
		$_SESSION['userid'] = $this->memberinfo['userid'];
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
        $memberinfo = $this->memberinfo;
		if ($memberinfo['point'] > 99){
		include template('member', 'menu');
		}else{
		include template('member', 'yuebuzu');
		}
	}
	//登录后发布菜单
	public function fabu() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$this->_session_start();
		$_SESSION['userid'] = $this->memberinfo['userid'];
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		//定义站点id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist','member');
		$memberinfo['groupname'] = $grouplist[$memberinfo['groupid']]['name'];
		$memberinfo['starnum'] = $grouplist[$memberinfo['groupid']]['starnum'];
		if ($memberinfo['point'] > 99){
		include template('member', 'fabu');
		}else{
		include template('member', 'fabu_yuebuzu');
		}
	}
	private function _session_start() {
		$session_storage = 'session_'.shy_base::load_config('system','session_storage');
		shy_base::load_sys_class($session_storage);
	}
 
} 
?>
