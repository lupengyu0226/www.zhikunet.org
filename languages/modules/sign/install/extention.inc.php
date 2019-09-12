<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'sign', 'parentid'=>29, 'm'=>'sign', 'c'=>'sign', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'sign_set', 'parentid'=>$parentid, 'm'=>'sign', 'c'=>'sign', 'a'=>'set', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'now_day_sign', 'parentid'=>$parentid, 'm'=>'sign', 'c'=>'sign', 'a'=>'now_day_sign', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$language = array('sign'=>'签到系统', 'now_day_sign'=>'今日签到用户','sign_set'=>'签到设置');
?>