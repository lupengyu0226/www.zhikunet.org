<?php
//用户唯一key
define('FEITIAN_KEY', 'a5d5e826a81b7cc026732266ec7ed52e');
define('FEITIAN_DOMAIN', 'account.05273.cn');
define('FEITIAN_PASSWORD', 'P6ABX0XA11OS8WCSW9VO');
//数据回调统计地址
define('FEITIAN_API', 'https://api.05273.cn/rexss.php?key='.FEITIAN_KEY.'&domain='.FEITIAN_DOMAIN.'&pwd='.FEITIAN_PASSWORD);
//拦截开关(1为开启，0关闭)
$feitian_switch=1;
//提交方式拦截(1开启拦截,0关闭拦截,post,get,cookie,referre选择需要拦截的方式)
$feitian_post=1;
$feitian_get=1;
$feitian_cookie=1;
$feitian_referre=1;
//后台白名单,后台操作将不会拦截,添加"|"隔开白名单目录下面默认是网址带 admin  /dede/ 放行
$feitian_white_directory='admin|\/dede\/';
//url白名单,可以自定义添加url白名单,默认是对shuyang的后台url放行
//写法：比如phpcms 后台操作url index.php?app=admin php168的文章提交链接post.php?job=postnew&step=post ,dedecms 空间设置edit_space_info.php
$feitian_white_url = array('index.php' => 'app=admin','post.php' => 'job=postnew&step=post','edit_space_info.php'=>'');
?>