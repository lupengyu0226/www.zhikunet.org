<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'onlines', 'parentid'=>29, 'm'=>'onlines', 'c'=>'onlines', 'a'=>'init', 'data'=>'s=1', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'onlines_add', 'parentid'=>$parentid, 'm'=>'onlines', 'c'=>'onlines', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_onlines', 'parentid'=>$parentid, 'm'=>'onlines', 'c'=>'onlines', 'a'=>'edit', 'data'=>'s=1', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'del_onlines', 'parentid'=>$parentid, 'm'=>'onlines', 'c'=>'onlines', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$language = array('onlines'=>'在线用户', 'del_onlines'=>'踢掉用户');
?>