<?php
defined('IN_SHUYANG') or exit('No permission resources.');
shy_base::load_app_class('admin','admin',0);
shy_base::load_sys_class('form','',0);
shy_base::load_app_func('global','sms');
class book extends admin{
	function __construct() {
		parent::__construct();
		$this->db = shy_base::load_model('book_model');
		$this->db_reply = shy_base::load_model('book_reply_model');

	}
	public function init(){
		$siteid = $this->get_siteid();
		if (isset($_GET['open'])){
			if ($_GET['open'] == 1){
				$where = array('is_check'=>0,'view_password'=>'','siteid'=>$siteid);
			}elseif ($_GET['open'] == 99){
				$where = "`is_check`=0 and `view_password` != '' and 'siteid'= $siteid";
			}
		}else{
			$where = array('is_check'=>0,'siteid'=>$siteid);
		}
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,'id DESC',$page,'20');

		foreach ($infos as $k=>$v){
			$id = $v['id'];
			$where = array('gid'=>$v['id'],'role'=>99);
			$infos_reply = $this->db_reply->get_one($where,'reply','id DESC');
			$infos[$k]['reply'] = $infos_reply['reply'];
		}

		$pages = $this->db->pages;
		include $this->admin_tpl('book_list');
	}
	public function check(){
		$siteid = $this->get_siteid();
		if(isset($_POST['dosubmit'])){
			foreach ($_POST['id'] as $id_arr){
				$this->db->update(array('is_check'=>0),array('id'=>$id_arr));
				}
			showmessage(L('check_success'),HTTP_REFERER);
		}

		if (isset($_GET['id'])){
			$id = intval($_GET['id']);
			$this->db->update(array('is_check'=>0),array('id'=>$id));
			showmessage(L('check_success'),HTTP_REFERER);
		}
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$where = array('is_check'=>1,'siteid'=>$siteid);
		$infos = $this->db->listinfo($where,'id DESC',$page,'10');
		$pages = $this->db->pages;
		include $this->admin_tpl('book_check');
	}
	public function setting(){
		$siteid = $this->get_siteid();
		$m_db = shy_base::load_model('module_model');
		$set = $m_db->get_one(array('module'=>'book'));
		$setting = string2array($set['setting']);
		$now_setting = $setting[$siteid];

		//判断短信是否开启
		$sms = getcache('sms','sms');

		if(isset($_POST['dosubmit'])){
			$setting[$siteid] = $_POST['setting'];
			setcache('book',$setting,'commons');
			$set = array2string($setting);
			$m_db->update(array('setting'=>$set),array('module'=>ROUTE_M));
			showmessage(L('setting_success'),HTTP_REFERER);
		}else{
			@extract($now_setting);
			include $this->admin_tpl('book_setting');
		}
	}
	public function reply(){
		$siteid = $this->get_siteid();
		$setting = new_html_special_chars(getcache('book','commons'));
		$set = $setting[$siteid];
		$id = intval($_GET['id']);
		if (isset($_POST['dosubmit'])){
			$_POST['info']['gid'] = $id;
			$_POST['info']['reply'] = $_POST['reply'];
			$_POST['info']['role'] = 99;
			$_POST['info']['addtime'] = SYS_TIME;
			$this->db_reply->insert($_POST['info']);
			
			if ($set['mailnotice'] == 1){
				shy_base::load_sys_func('mail');
				$emails =  getcache('common','commons');
				$where = array('id'=>$id);
				$infos = $this->db->get_one($where);
					$subject = $infos['title'];
					$message = L('message_reply').L('password_url').APP_PATH.'index.php?app=book&controller=index&view=show&id='.$id;
					$emailto = $infos['email'];
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
					showmessage (L('mail_fail'),HTTP_REFERER);
				}
			}

			if ($set['telnotice'] == 1){
				$siteid = get_siteid();
				shy_base::load_app_class('smsapi','sms', 0);
				$sms = getcache('sms','sms');

				$sms_uid = $sms[$siteid]['userid'];
				$sms_pid = $sms[$siteid]['productid'];
				$sms_passwd = $sms[$siteid]['sms_key'];

				$smsapi = new smsapi($sms_uid, $sms_pid, $sms_passwd);
				$where = array('id'=>$id);
				$infos = $this->db->get_one($where);

				$id_code = random(6);
				$tplid = 16; //短信模版ID，与短信平台->短信群发中一致
				$mobile = $infos['mobile'];;
				$content = L('mobile_content').$infos['title'].L('mobile_content_reply').$_POST['reply'];
				$sent_time = date('Y-m-d H:i:s',SYS_TIME);
				$return = $smsapi->send_sms($mobile, $content, $sent_time, CHARSET,'',$tplid);
				if ($return != L('send_success')){
					showmessage(L('send_fail'),HTTP_REFERER);
				}
			}

		showmessage(L('reply_success'),HTTP_REFERER);
		}

		$where = array('id'=>$id);
		$infos = $this->db->listinfo($where);
		
		$where = array('gid'=>$id);
		$infos_reply = $this->db_reply->listinfo($where,'id ASC');
		include $this->admin_tpl('book_reply');
	}
	public function delete(){
		$id = $_GET['id'];
		$result = $this->db->delete(array('id'=>$id));
		$result_reply =$this->db_reply->delete(array('gid'=>$id));
			if($result && $result_reply){
				showmessage(L('delete_success'),HTTP_REFERER);
			}else {
				showmessage(L('delete_fail'),HTTP_REFERER);
		}
	}
	public function delete_d(){
		$id = $_GET['id'];
		$result_reply =$this->db_reply->delete(array('id'=>$id));
			if($result_reply){
				showmessage(L('delete_success'),HTTP_REFERER);
			}else {
				showmessage(L('delete_fail'),HTTP_REFERER);
		}
	}
	public function delete_all(){
		if (isset($_POST['id'])){
			foreach ($_POST['id'] as $id_arr){
				$this->db->delete(array('id'=>$id_arr));
				$this->db_reply->delete(array('gid'=>$id_arr));
			}
			showmessage(L('delete_success'),HTTP_REFERER);
		}else{
			showmessage(L('no_tick'));
		}
	}
}
?>
