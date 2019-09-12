<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'mips', 'parentid'=>29, 'm'=>'mips', 'c'=>'mips_admin', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'mips_add', 'parentid'=>$parentid, 'm'=>'mips', 'c'=>'mips_admin', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'mips_edit', 'parentid'=>$parentid, 'm'=>'mips', 'c'=>'mips_admin', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'mips_delete', 'parentid'=>$parentid, 'm'=>'mips', 'c'=>'mips_admin', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'lanmuguanli', 'parentid'=>$parentid, 'm'=>'mips', 'c'=>'category', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'categorys_edit', 'parentid'=>$parentid, 'm'=>'mips', 'c'=>'category', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$language = array('mips'=>'手机MIP','mips_add'=>'添加','mips_edit'=>'修改','mips_delete'=>'删除','lanmuguanli'=>'栏目管理','categorys_edit'=>'栏目编辑',);
?>
