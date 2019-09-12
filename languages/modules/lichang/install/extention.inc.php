<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'lichang', 'parentid'=>'29', 'm'=>'lichang', 'c'=>'lichang_admin', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'lichang_setting', 'parentid'=>$parentid, 'm'=>'lichang', 'c'=>'lichang_admin', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('lichang'=>'新闻立场', 'lichang_setting'=>'立场配置');
setcache('lichang_program', array('1'=>array(
  1 => 
  array (
    'use' => '1',
    'name' => '支持',
    'pic' => 'lichang/a1.gif',
  ),
  2 => 
  array (
    'use' => '1',
    'name' => '反对',
    'pic' => 'lichang/a2.gif',
  ),
)), 'commons');
?>
