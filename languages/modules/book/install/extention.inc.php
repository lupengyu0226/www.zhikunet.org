<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'book', 'parentid'=>29, 'm'=>'book', 'c'=>'book', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'check', 'parentid'=>$parentid, 'm'=>'book', 'c'=>'book', 'a'=>'check', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'book_setting', 'parentid'=>$parentid, 'm'=>'book', 'c'=>'book', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$language = array('book'=>'留言板','check'=>'留言审核','book_setting'=>'留言设置');
?>
