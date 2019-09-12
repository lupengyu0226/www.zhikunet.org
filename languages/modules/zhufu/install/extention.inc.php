<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'zhufu', 'parentid'=>29, 'm'=>'zhufu', 'c'=>'admin_zhufu', 'a'=>'init', 'data'=>'s=1', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'zhufu_add', 'parentid'=>$parentid, 'm'=>'zhufu', 'c'=>'admin_zhufu', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_zhufu', 'parentid'=>$parentid, 'm'=>'zhufu', 'c'=>'admin_zhufu', 'a'=>'edit', 'data'=>'s=1', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'del_zhufu', 'parentid'=>$parentid, 'm'=>'zhufu', 'c'=>'admin_zhufu', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('zhufu'=>'祝福', 'zhufu_add'=>'添加祝福', 'edit_zhufu'=>'编辑祝福', 'check_zhufu'=>'审核祝福', 'overdue'=>'过期祝福', 'del_zhufu'=>'删除祝福');
?>
