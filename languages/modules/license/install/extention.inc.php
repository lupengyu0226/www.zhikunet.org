<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'license', 'parentid'=>29, 'm'=>'license', 'c'=>'admin_license', 'a'=>'init', 'data'=>'s=1', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'check_license', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'init', 'data'=>'s=2', 'listorder'=>3, 'display'=>'1'));
$menu_db->insert(array('name'=>'license_guoqi', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'init', 'data'=>'s=3', 'listorder'=>4, 'display'=>'1'));
$menu_db->insert(array('name'=>'license_fuwu', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'init', 'data'=>'s=4', 'listorder'=>5, 'display'=>'1'));
$menu_db->insert(array('name'=>'edit_license', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'edit', 'data'=>'s=1', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'license_add', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'notice_guoqi', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'notice_init', 'data'=>'s=3', 'listorder'=>8, 'display'=>'1'));
$menu_db->insert(array('name'=>'notice_shenhe', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'notice_init', 'data'=>'s=2', 'listorder'=>7, 'display'=>'1'));
$menu_db->insert(array('name'=>'notice_op', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'notice_init', 'data'=>'s=1', 'listorder'=>6, 'display'=>'1'));
$menu_db->insert(array('name'=>'icdlist', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'icd', 'data'=>'', 'listorder'=>9, 'display'=>'1'));
$menu_db->insert(array('name'=>'list_type', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'list_type', 'data'=>'', 'listorder'=>10, 'display'=>'1'));
$menu_db->insert(array('name'=>'del_license', 'parentid'=>$parentid, 'm'=>'license', 'c'=>'admin_license', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$language = array('license'=>'商业授权', 'license_add'=>'添加授权', 'license_guoqi'=>'过期授权', 'license_fuwu'=>'过期服务', 'notice_op'=>'远程公告', 'icdlist'=>'序列号列表', 'edit_license'=>'编辑授权', 'check_license'=>'审核授权', 'notice_shenhe'=>'审核公告', 'notice_guoqi'=>'过期公告', 'del_license'=>'删除授权');
?>