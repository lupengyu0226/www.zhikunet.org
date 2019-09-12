<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'shuyangtoday_add ', 'parentid'=>29, 'm'=>'shuyangtoday', 'c'=>'manages', 'a'=>'add', 'data'=>'', 'listorder'=>1, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'shuyangtoday', 'parentid'=>$parentid, 'm'=>'shuyangtoday', 'c'=>'manages', 'a'=>'init', 'data'=>'', 'listorder'=>2, 'display'=>'1'));
$menu_db->insert(array('name'=>'shuyangtoday_edit', 'parentid'=>$parentid, 'm'=>'shuyangtoday', 'c'=>'manages', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'shuyangtoday_delete', 'parentid'=>$parentid, 'm'=>'shuyangtoday', 'c'=>'manages', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('shuyangtoday'=>'推荐历史',
				  'shuyangtoday_add'=>'今日推荐',
				  'shuyangtoday_edit'=>'修改',
				  'shuyangtoday_delete'=>'删除'				  
                  );

?>
