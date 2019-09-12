<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'xihuan', 'parentid'=>'29', 'm'=>'xihuan', 'c'=>'xihuan_admin', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'xihuan_setting', 'parentid'=>$parentid, 'm'=>'xihuan', 'c'=>'xihuan_admin', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('xihuan'=>'喜欢', 'xihuan_setting'=>'喜欢配置');
setcache('xihuan_program', array('1'=>array(
  1 => 
  array (
    'use' => '1',
    'name' => '喜欢',
    'pic' => 'xihuan/xh.gif',
  ),
)), 'commons');
?>
