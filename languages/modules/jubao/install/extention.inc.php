<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'jubao', 'parentid'=>29, 'm'=>'jubao', 'c'=>'jubao', 'a'=>'init', 'data'=>'s=1', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'jubao_add', 'parentid'=>$parentid, 'm'=>'jubao', 'c'=>'jubao', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_jubao', 'parentid'=>$parentid, 'm'=>'jubao', 'c'=>'jubao', 'a'=>'edit', 'data'=>'s=1', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'del_jubao', 'parentid'=>$parentid, 'm'=>'jubao', 'c'=>'jubao', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('jubao'=>'内容举报管理', 'del_jubao'=>'删除内容举报');
?>
