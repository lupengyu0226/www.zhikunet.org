<?php
defined('IN_SHUYANG') or exit('No permission resources.');
huadong_comment();
function huadong_comment() {
	if(!session_id()) session_start();
	if(empty($_POST['ihuadong']) && isset($_SESSION['ihuadong']) && $_SESSION['ihuadong']) {
		unset($_SESSION['ihuadong']);
		exit('1');
	} else {
		exit('0');
	}
}
?>
