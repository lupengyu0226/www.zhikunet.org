<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_sys_class('form', '', 0);
class index {
	function __construct(){
		$this->db = shy_base::load_model('book_model');
		$this->db_reply = shy_base::load_model('book_reply_model');
		$this->db_member = shy_base::load_model('member_model');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
		define("SITEID",$siteid);
	}
	public function init(){
		$SEO = seo(SITEID, '', $subject, $description, $subject);
		$siteid = SITEID;
		$page = isset($_GET['page']) && intval ($_GET['page']) ? intval ($_GET['page']) : 1;
		$where = array('view_password'=>'','is_check'=>'0','siteid'=>$siteid);
		$infos = $this->db->listinfo($where,'id DESC',$page,10);
		foreach ($infos as $k=>$v){
			$id = $v['id'];
			$where = array('gid'=>$v['id'],'role'=>99);
			$infos_reply = $this->db_reply->get_one($where,'reply','id DESC');
			$infos[$k][$id] = $infos_reply['reply'];
		}
		$pages = $this->db->pages;
		//SEO
		$title='留言反馈';
		$description='大家如果对沭阳网有各种意见或者建议的话，都请在这里留言，您每一个留言我们都会认真对待，哪怕是不合理的!';
		$keywords='沭阳留言本,留言反馈,意见反馈,给我留言,雁过留声';
		$SEO = seo($siteid,0, $title, $description, $keywords);
		$username = param::get_cookie('_username');
		$my_book = $this->db->listinfo(array('username'=>$username,'is_check'=>'0'));

		include template('book','list');
	}
	public function add(){
		$SEO = seo(SITEID, '', $subject, $description, $subject);
		$siteid = SITEID;
		$title='添加留言';
		$description='大家如果对沭阳网有各种意见或者建议的话，都请在这里留言，您每一个留言我们都会认真对待，哪怕是不合理的!';
		$keywords='沭阳留言本,留言反馈,意见反馈,给我留言,雁过留声';
		$SEO = seo($siteid,0, $title, $description, $keywords);
		$setting = new_html_special_chars(getcache('book','commons'));
		$set = $setting[$siteid];
		if (isset($_POST['dosubmit'])){
			if(isset($_POST['code'])){
				$session_storage = 'session_'.shy_base::load_config('system','session_storage');
				shy_base::load_sys_class($session_storage);
					if (!isset($_SESSION)){
						session_start();
					}
						$code = isset($_POST['code']) && trim ($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'),HTTP_REFERER);
							if ($_SESSION['code'] != strtolower($code)){
								showmessage(L('code_error'),HTTP_REFERER);
						}
			}
			$userid = param::get_cookie('_userid');
			$username = param::get_cookie('_username');
			$_POST['info']['realname'] = $_POST['realname'];
			$_POST['info']['userid'] = $userid;
			$_POST['info']['username'] = $username;
			$_POST['info']['email'] = $_POST['email'];
			$_POST['info']['mobile'] = $_POST['mobile'];
			$_POST['info']['title'] = htmlspecialchars($_POST['title']);
			$_POST['info']['content'] = addslashes($_POST['content']);
			$_POST['info']['addtime'] = SYS_TIME;
			$_POST['info']['siteid'] = $siteid;
			
			$view_password = $_POST['view_password'];
			$checked = $_POST['checked'];
			if ($checked != 1){
				$_POST['info']['view_password'] = safe_replace($view_password);
				$insert = $this->db->insert($_POST['info']);
				$insert_id = $this->db->insert_id($insert);

				shy_base::load_sys_func('mail');
				$emails =  getcache('common','commons');
				$subject = L('view_password_url');
				$message = L('password_url').APP_PATH.'index.php?app=book&controller=index&view=show&'.$siteid.'&id='.$insert_id.L('view_password').$view_password;
				$emailto = $_POST['email'];
				$mail= Array (
							'mailsend' => 2,
							'maildelimiter' => 1,
							'mailusername' => 1,
							'server' => $emails['mail_server'],
							'port' => intval($emails['mail_port']),
							'mail_type' => intval($emails['mail_type']),
							'auth' => intval($emails['mail_auth']),
							'from' => $emails['mail_from'],
							'auth_username' => $emails['mail_user'],
							'auth_password' => $emails['mail_password']
						);
				if (!sendmail($emailto,$subject,$message,$emails['mail_from'],$mail)){
					showmessage (L('mail_fail'));
				}else{
					showmessage (L('mail_success'),HTTP_REFERER);
				}

			}else{
				if ($set['is_check'] == 1){
					$_POST['info']['is_check'] = 1;
					$this->db->insert($_POST['info']);
					showmessage(L('message_check'),'index.php?app=book&controller=index');
				}else{
					$this->db->insert($_POST['info']);
					showmessage(L('message_success'),'index.php?app=book&controller=index');
				}
			}
		}
		include template('book','add');
	}
	public function show(){
		$SEO = seo(SITEID, '', $subject, $description, $subject);
		$siteid = SITEID;
		$title='留言内容';
		$description='大家如果对沭阳网有各种意见或者建议的话，都请在这里留言，您每一个留言我们都会认真对待，哪怕是不合理的!';
		$keywords='沭阳留言本,留言反馈,意见反馈,给我留言,雁过留声';
		$SEO = seo($siteid,0, $title, $description, $keywords);
		$id = intval($_GET['id']);
		$where = array('id'=>$id);
		$infos = $this->db->get_one($where);
		$view_password = $infos['view_password'];
		$r = $this->db->get_one($where);
		if (isset($_POST['dosubmit']) && $_POST['view_password'] == $view_password){
				$id = intval($_GET['id']);
				$where = array('gid'=>$id);
				$reply = $this->db_reply->listinfo($where,'id ASC');
				
				$username = param::get_cookie('_username');
				$my_book = $this->db->listinfo(array('username'=>$username,'is_check'=>'0'));			
				include template('book','show');
		}else{
			if ($view_password != ''){
				include template('book','password');
			}else{
				$id = intval($_GET['id']);
				$where = array('gid'=>$id);
				$reply = $this->db_reply->listinfo($where,'id ASC');
				if($r['id']) {	
				$username = param::get_cookie('_username');
				$my_book = $this->db->listinfo(array('username'=>$username,'is_check'=>'0'));
				include template('book','show');
			} else {
			showmessage(L('no_exists'));	
	       }
	      }
		}
	}
	public function reply(){
		if (isset($_POST['dosubmit'])){
			$id = intval($_GET['id']);
			$role = isset($_GET['role']) && intval ($_GET['role']) ? intval ($_GET['role']) : 1;
			$_POST['info']['gid'] = $id;
			$_POST['info']['reply'] = $_POST['reply'];
			$_POST['info']['role'] = $role;
			$_POST['info']['addtime'] = SYS_TIME;
			$this->db_reply->insert($_POST['info']);
			showmessage(L('reply_success'),HTTP_REFERER);
		}

	}
}
?>
