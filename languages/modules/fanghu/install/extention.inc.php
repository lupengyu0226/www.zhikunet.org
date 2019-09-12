<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'fanghu', 'parentid'=>29, 'm'=>'fanghu', 'c'=>'fanghu', 'a'=>'init', 'data'=>'s=1', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'fanghu_add', 'parentid'=>$parentid, 'm'=>'fanghu', 'c'=>'fanghu', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_fanghu', 'parentid'=>$parentid, 'm'=>'fanghu', 'c'=>'fanghu', 'a'=>'edit', 'data'=>'s=1', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'del_fanghu', 'parentid'=>$parentid, 'm'=>'fanghu', 'c'=>'fanghu', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('fanghu'=>'攻击日志管理', 'del_fanghu'=>'删除攻击日志');
?>
