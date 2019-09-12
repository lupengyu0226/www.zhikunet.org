<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'gaojianlanmutongji', 'parentid'=>4, 'm'=>'admin', 'c'=>'manage_stats', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'lanmufangwentongji', 'parentid'=>$parentid, 'm'=>'stats', 'c'=>'stats', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'lanmuyunyingfenxi', 'parentid'=>$parentid, 'm'=>'admin', 'c'=>'category_analysis', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'gaojiantongji', 'parentid'=>$parentid, 'm'=>'admin', 'c'=>'manage_stats', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$language = array('gaojianlanmutongji'=>'栏目统计', 'lanmufangwentongji'=>'栏目访问统计', 'lanmuyunyingfenxi'=>'栏目运营分析','gaojiantongji'=>'稿件统计');
?>