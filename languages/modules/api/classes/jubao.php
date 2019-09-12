<?php
/**
 * 举报内容，免登录
 * @param url 地址，需urlencode，防止乱码产生
 * @param title 标题，需urlencode，防止乱码产生
 * @param content 地址，需urlencode，防止乱码产生
 * @param 状态说明：提交成功1，缺少参数提交失败-2，验证码不正确-3，验证码没输入-4
 */
defined('IN_SHUYANG') or exit('No permission resources.');
$session_storage = 'session_'.shy_base::load_config('system','session_storage'); 
shy_base::load_sys_class($session_storage); 
if(empty($_GET['title']) || empty($_GET['content']) || empty($_GET['url'])){
	exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>-2)).')');
} else {
	$title = $_GET['title'];
	$type = $_GET['type'];
	$content = $_GET['content'];
	$jianyi = $_GET['jianyi'];
	$username = $_GET['username'];
	$email = $_GET['email'];
	$title = addslashes(urldecode($title));
	$type = addslashes(urldecode($type));
	$content = addslashes(urldecode($content));
	$jianyi = addslashes(urldecode($jianyi));
	$username = addslashes(urldecode($username));
	$email = addslashes(urldecode($email));
	if(CHARSET != 'utf-8') {
		$title = iconv('utf-8', CHARSET, $title);
		$content = iconv('utf-8', CHARSET, $content);
		$jianyi = iconv('utf-8', CHARSET, $jianyi);
		$title = addslashes($title);
		$content = addslashes($content);
		$jianyi = addslashes($jianyi);
	    $username = addslashes($username);
	    $email = addslashes($email);
	}
	$username = new_html_special_chars($username);
	$email = new_html_special_chars($email);
	$title = new_html_special_chars($title);
	$type = new_html_special_chars($type);
	$content = new_html_special_chars($content);
	$jianyi = new_html_special_chars($jianyi);
	$url = safe_replace(addslashes(urldecode($_GET['url'])));
	$url = trim_script($url);
}
if(!empty($_SESSION['code'])) {
   //判断验证码
   $code = isset($_GET['code']) && trim($_GET['code']) ? trim($_GET['code']) : exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>-4)).')');
   if ($_SESSION['code'] != strtolower($code)) {
    exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>-3)).')');
   }
 }
$_GET['callback'] = safe_replace($_GET['callback']);
$shuyang_auth = param::get_cookie('auth');
list($userid) = explode("\t", sys_auth($shuyang_auth, 'DECODE', get_auth_key('login')));
$userid = intval($userid);
$jubao_db = shy_base::load_model('jubao_model');
$data = array('username'=>$username, 'email'=>$email,'title'=>$title, 'type'=>$type, 'content'=>$content, 'jianyi'=>$jianyi, 'url'=>$url, 'adddate'=>SYS_TIME, 'userid'=>$userid);
//根据url判断该用户是否已经举报过。
$is_exists = $jubao_db->get_one(array('url'=>$url, 'userid'=>$userid));
if(!$is_exists) {
	$jubao_db->insert($data);
}
exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>1)).')');
?>