<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'mobile', 'parentid'=>29, 'm'=>'mobile', 'c'=>'mobile_admin', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'mobile_add', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile_admin', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'mobile_edit', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile_admin', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'mobile_delete', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'mobile_admin', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'lanmuguanli', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'category', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'categorys_edit', 'parentid'=>$parentid, 'm'=>'mobile', 'c'=>'category', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$language = array('mobile'=>'移动门户','mobile_add'=>'添加','mobile_edit'=>'修改','mobile_delete'=>'删除','lanmuguanli'=>'栏目管理','categorys_edit'=>'栏目编辑',);
?>
