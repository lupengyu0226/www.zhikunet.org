<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'zhuanlan', 'parentid'=>29, 'm'=>'zhuanlan', 'c'=>'zhuanlan', 'a'=>'init','listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'zhuanlan_setting', 'parentid'=>$parentid, 'm'=>'zhuanlan', 'c'=>'zhuanlan', 'a'=>'setting','listorder'=>0, 'display'=>1));
$urlrule_db = shy_base::load_model('urlrule_model');
$urlrule_db->insert(array('module'=>'zhuanlan','file'=>'index','ishtml'=>0,'urlrule'=>'index.php?app=zhuanlan&controller=index|index.php?app=zhuanlan&controller=index&page={$page}','example'=>'index.php?app=zhuanlan&controller=index&page=1'));
$urlrule_db->insert(array('module'=>'zhuanlan','file'=>'index','ishtml'=>0,'urlrule'=>'/zhuanlan/index.html|/zhuanlan/index_{$page}.html','example'=>'zhuanlan/index.html|/zhuanlan/index_123.html'));
$urlrule_db->insert(array('module'=>'zhuanlan','file'=>'list','ishtml'=>0,'urlrule'=>'index.php?app=zhuanlan&controller=index&view=show&domain={$domain}|index.php?app=zhuanlan&controller=index&view=show&domain={$domain}&page={$page}','example'=>'index.php?app=zhuanlan&controller=index&view=show&domain=admin&page=1'));
$urlrule_db->insert(array('module'=>'zhuanlan','file'=>'list','ishtml'=>0,'urlrule'=>'/zhuanlan/{$domain}/index.html|/zhuanlan/{$domain}/{$page}.html','example'=>'/zhuanlan/admin/index.html|/zhuanlan/admin/2.html'));
$language = array('zhuanlan'=>'沭阳号','zhuanlan_setting'=>'沭阳号设置');
?>