<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$iphpcmsdb = $menu_db->get_one(array('name'=>'shuyang_cron','parentid'=>'0'));
if($iphpcmsdb){
$parentid =$iphpcmsdb['id'];
}else{
$parentid = $menu_db->insert(array('name'=>'shuyang_cron', 'parentid'=>'0', 'm'=>'cron', 'c'=>'index', 'a'=>'init', 'data'=>'', 'listorder'=>9, 'display'=>'1'), true);
}
$mid = $menu_db->insert(array('name'=>'cron','parentid'=>$parentid, 'm'=>'cron', 'c'=>'cron', 'a'=>'init', 'data'=>'', 'listorder'=>15, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'cron_add', 'parentid'=>$mid, 'm'=>'cron', 'c'=>'cron', 'a'=>'add', 'data'=>'', 'listorder'=>1, 'display'=>'1'));
$menu_db->insert(array('name'=>'cron_manage', 'parentid'=>$mid, 'm'=>'cron', 'c'=>'cron', 'a'=>'init', 'data'=>'', 'listorder'=>2, 'display'=>'1'));

$language = array('shuyang_cron'=>'计划任务', 'cron'=>'计划任务','cron_add'=>'添加计划任务','cron_manage'=>'管理计划任务');
?>
