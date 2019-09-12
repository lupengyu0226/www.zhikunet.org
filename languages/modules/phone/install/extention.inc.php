<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'phone', 'parentid'=>29, 'm'=>'phone', 'c'=>'phone', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_phone', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_phone', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'delete_phone', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'phone_setting', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'add_type', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'add_type', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'list_type', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'list_type', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'check_register', 'parentid'=>$parentid, 'm'=>'phone', 'c'=>'phone', 'a'=>'check_register', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$phone_db = shy_base::load_model('phone_model');
$phone_db->insert(array('siteid'=>1,'typeid'=>$typeid,'phonetype'=>'1','name'=>'SHUYANG','url'=>'http://www.05273.cn','logo'=>'http://www.05273.cn/images/logo_88_31.gif','passed'=>1,'addtime'=>SYS_TIME)); 
$phone_db->insert(array('siteid'=>1,'typeid'=>$typeid,'phonetype'=>'1','name'=>'盛大在线','url'=>'http://www.sdo.com','logo'=>'http://www.snda.com/cn/logo/comp_logo_sdo.gif','passed'=>1,'addtime'=>SYS_TIME));

$language = array('phone'=>'便民电话', 'add_phone'=>'添加便民电话', 'edit_phone'=>'编辑便民电话', 'delete_phone'=>'删除便民电话', 'phone_setting'=>'模块配置', 'add_type'=>'添加类别', 'list_type'=>'分类管理', 'check_register'=>'审核申请');
?>
