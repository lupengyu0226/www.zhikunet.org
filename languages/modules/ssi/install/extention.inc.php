<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'ssi', 'parentid'=>826, 'm'=>'ssi', 'c'=>'ssi', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_ssi', 'parentid'=>$parentid, 'm'=>'ssi', 'c'=>'ssi', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_ssi', 'parentid'=>$parentid, 'm'=>'ssi', 'c'=>'ssi', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'delete_ssi', 'parentid'=>$parentid, 'm'=>'ssi', 'c'=>'ssi', 'a'=>'del', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'ssi_lists', 'parentid'=>$parentid, 'm'=>'ssi', 'c'=>'ssi', 'a'=>'lists', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('ssi'=>'ssi碎片', 'add_ssi'=>'添加ssi碎片', 'edit_ssi'=>'修改ssi标签', 'delete_ssi'=>'删除ssi标签', 'ssi_lists'=>'ssi标签列表');
?>
