<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'kuaixun', 'parentid'=>29, 'm'=>'kuaixun', 'c'=>'kuaixun', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_kuaixun', 'parentid'=>$parentid, 'm'=>'kuaixun', 'c'=>'kuaixun', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_kuaixun', 'parentid'=>$parentid, 'm'=>'kuaixun', 'c'=>'kuaixun', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'kuaixun_setting', 'parentid'=>$parentid, 'm'=>'kuaixun', 'c'=>'kuaixun', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'delete_kuaixun', 'parentid'=>$parentid, 'm'=>'kuaixun', 'c'=>'kuaixun', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$kuaixun_db = shy_base::load_model('kuaixun_model');
$kuaixun_db->insert(array('siteid'=>1,'typeid'=>$typeid,'kuaixuntype'=>'1','name'=>'SHUYANG','url'=>'http://www.05273.cn','logo'=>'http://www.05273.cn/images/logo_88_31.gif','passed'=>1,'addtime'=>SYS_TIME)); 
$kuaixun_db->insert(array('siteid'=>1,'typeid'=>$typeid,'kuaixuntype'=>'1','name'=>'盛大在线','url'=>'http://www.sdo.com','logo'=>'http://www.snda.com/cn/logo/comp_logo_sdo.gif','passed'=>1,'addtime'=>SYS_TIME));

$language = array('kuaixun'=>'快讯推送', 'add_kuaixun'=>'添加快讯', 'edit_kuaixun'=>'编辑快讯', 'kuaixun_setting'=>'模块配置', 'delete_kuaixun'=>'删除快讯');
?>
