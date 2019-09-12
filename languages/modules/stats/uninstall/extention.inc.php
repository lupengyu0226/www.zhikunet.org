<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');
$type_db = shy_base::load_model('type_model');
$menu_db = shy_base::load_model('menu_model');

$menu_db->delete(array('m'=>'admin', 'c'=>'manage_stats', 'a'=>'init'));
$menu_db->delete(array('m'=>'stats', 'c'=>'stats', 'a'=>'init'));
$menu_db->delete(array('m'=>'admin', 'c'=>'category_analysis', 'a'=>'init'));
$menu_db->delete(array('m'=>'admin', 'c'=>'manage_stats', 'a'=>'init'));
$typeid = $type_db->delete(array('module'=>'stats'));
if(!$typeid) return FALSE;
?> 
