<?php 
defined('IN_SHUYANG') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');

$urlrule_db = shy_base::load_model('urlrule_model');
$urlrule_db->delete(array('module'=>'zhuanlan'));

?>