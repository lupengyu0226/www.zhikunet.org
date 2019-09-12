<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'url', 'parentid'=>29, 'm'=>'url', 'c'=>'admin_url', 'a'=>'init', 'data'=>'s=1', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'url_add', 'parentid'=>$parentid, 'm'=>'url', 'c'=>'admin_url', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_url', 'parentid'=>$parentid, 'm'=>'url', 'c'=>'admin_url', 'a'=>'edit', 'data'=>'s=1', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'check_url', 'parentid'=>$parentid, 'm'=>'url', 'c'=>'admin_url', 'a'=>'init', 'data'=>'s=2', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'overdue', 'parentid'=>$parentid, 'm'=>'url', 'c'=>'admin_url', 'a'=>'init', 'data'=>'s=3', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'del_url', 'parentid'=>$parentid, 'm'=>'url', 'c'=>'admin_url', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('url'=>'外链', 'url_add'=>'添加外链', 'edit_url'=>'编辑外链', 'check_url'=>'审核外链', 'overdue'=>'过期外链', 'del_url'=>'删除外链');
?>
