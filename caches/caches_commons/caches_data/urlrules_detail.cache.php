<?php
return array (
  1 => 
  array (
    'urlruleid' => '1',
    'module' => 'content',
    'file' => 'category',
    'ishtml' => '1',
    'urlrule' => '{$categorydir}{$catdir}/index.html|{$categorydir}{$catdir}/list_{$page}.html',
    'example' => 'news/china/list_1000.html',
  ),
  6 => 
  array (
    'urlruleid' => '6',
    'module' => 'content',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => 'index.php?app=content&controller=index&view=lists&catid={$catid}|index.php?app=content&controller=index&view=lists&catid={$catid}&page={$page}',
    'example' => 'index.php?app=content&controller=index&view=lists&catid=1&page=1',
  ),
  11 => 
  array (
    'urlruleid' => '11',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '1',
    'urlrule' => '{$catdir}/view_{$id}.html|{$catdir}/view_{$id}_{$page}.html',
    'example' => '2010/catdir_0720/1_2.html',
  ),
  12 => 
  array (
    'urlruleid' => '12',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '1',
    'urlrule' => '{$categorydir}{$catdir}/{$year}/{$month}{$day}/{$id}.html|{$categorydir}{$catdir}/{$year}/{$month}{$day}/{$id}_{$page}.html',
    'example' => 'it/product/2010/0720/1_2.html',
  ),
  16 => 
  array (
    'urlruleid' => '16',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => 'index.php?app=content&controller=index&view=show&catid={$catid}&id={$id}|index.php?app=content&controller=index&view=show&catid={$catid}&id={$id}&page={$page}',
    'example' => 'index.php?app=content&controller=index&view=show&catid=1&id=1',
  ),
  17 => 
  array (
    'urlruleid' => '17',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => 'show-{$catid}-{$id}-{$page}.html',
    'example' => 'show-1-2-1.html',
  ),
  18 => 
  array (
    'urlruleid' => '18',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => 'content-{$catid}-{$id}-{$page}.html',
    'example' => 'content-1-2-1.html',
  ),
  30 => 
  array (
    'urlruleid' => '30',
    'module' => 'content',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => 'list-{$catid}-{$page}.html',
    'example' => 'list-1-1.html',
  ),
  31 => 
  array (
    'urlruleid' => '31',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '1',
    'urlrule' => '{$categorydir}{$catdir}/view_{$id}.html|{$categorydir}{$catdir}/view_{$id}_{$page}.html',
    'example' => '不带日期目录的地址',
  ),
  49 => 
  array (
    'urlruleid' => '49',
    'module' => 'zhuanlan',
    'file' => 'index',
    'ishtml' => '0',
    'urlrule' => 'index.php?app=zhuanlan&controller=index|index.php?app=zhuanlan&controller=index&page={$page}',
    'example' => 'index.php?app=zhuanlan&controller=index&page=1',
  ),
  33 => 
  array (
    'urlruleid' => '33',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '1',
    'urlrule' => '{$categorydir}{$catdir}/{$month}{$day}/view_{$id}.html|{$categorydir}{$catdir}/{$month}{$day}/view_{$id}_{$page}.html',
    'example' => '带日期地址',
  ),
  34 => 
  array (
    'urlruleid' => '34',
    'module' => 'content',
    'file' => 'show',
    'ishtml' => '1',
    'urlrule' => '{$catdir}/huati_{$month}{$day}_{$id}.html|{$catdir}/huati_{$month}{$day}_{$id}_{$page}.html',
    'example' => '今日话题专用地址',
  ),
  35 => 
  array (
    'urlruleid' => '35',
    'module' => 'mobile',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => 'list-{$catid}-1.html|list-{$catid}-{$page}.html',
    'example' => '移动门户列表页',
  ),
  36 => 
  array (
    'urlruleid' => '36',
    'module' => 'mobile',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => 'show-{$catid}-{$id}-1.html|show-{$catid}-{$id}-{$page}.html',
    'example' => '移动门户内容页',
  ),
  38 => 
  array (
    'urlruleid' => '38',
    'module' => 'mobile',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => 'show-{$catid}-{$id}-1.html|show-{$catid}-{$id}-{$page}.html',
    'example' => '手机门户测试URL',
  ),
  48 => 
  array (
    'urlruleid' => '48',
    'module' => 'mobile',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => 'mip-{$catid}-{$id}-1.html|mip-{$catid}-{$id}-{$page}.html',
    'example' => '手机站 MIP 页面内容页',
  ),
  40 => 
  array (
    'urlruleid' => '40',
    'module' => 'content',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => '/{$catdir}/xz_{$typeid}_1.html|/{$catdir}/xz_{$typeid}_{$page}.html',
    'example' => 'news/china/xn_1000.html',
  ),
  41 => 
  array (
    'urlruleid' => '41',
    'module' => 'mobile',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => '/{$catdir}/xz_{$typeid}_1.html|/{$catdir}/xz_{$typeid}_{$page}.html',
    'example' => '手机版type类别',
  ),
  43 => 
  array (
    'urlruleid' => '43',
    'module' => 'mobile',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => 'miplist-{$catid}-1.html|miplist-{$catid}-{$page}.html',
    'example' => 'miplist-1-1.html|miplist-1-1.html',
  ),
  44 => 
  array (
    'urlruleid' => '44',
    'module' => 'mobile',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => '{$categorydir}{$catdir}/{$month}{$day}/view_{$id}.html|{$categorydir}{$catdir}/{$month}{$day}/view_{$id}_{$page}.html',
    'example' => '手机站新式内容页，带日期',
  ),
  45 => 
  array (
    'urlruleid' => '45',
    'module' => 'mobile',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => '{$categorydir}{$catdir}/view_{$id}.html|{$categorydir}{$catdir}/view_{$id}_{$page}.html',
    'example' => '手机站新式内容页，不带日期',
  ),
  46 => 
  array (
    'urlruleid' => '46',
    'module' => 'mobile',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => '{$catdir}/huati_{$month}{$day}_{$id}.html|{$catdir}/huati_{$month}{$day}_{$id}_{$page}.html',
    'example' => '今日话题手机站规则',
  ),
  47 => 
  array (
    'urlruleid' => '47',
    'module' => 'mobile',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => '{$categorydir}{$catdir}/index.html|{$categorydir}{$catdir}/list_{$page}.html',
    'example' => '手机站新式列表页',
  ),
  50 => 
  array (
    'urlruleid' => '50',
    'module' => 'zhuanlan',
    'file' => 'index',
    'ishtml' => '0',
    'urlrule' => '/u/index.html|/u/index_{$page}.html',
    'example' => 'u/index.html|/zhuanlan/index_123.html',
  ),
  51 => 
  array (
    'urlruleid' => '51',
    'module' => 'zhuanlan',
    'file' => 'list',
    'ishtml' => '0',
    'urlrule' => 'index.php?app=zhuanlan&controller=index&view=show&domain={$domain}|index.php?app=zhuanlan&controller=index&view=show&domain={$domain}&page={$page}',
    'example' => 'index.php?app=zhuanlan&controller=index&view=show&domain=admin&page=1',
  ),
  52 => 
  array (
    'urlruleid' => '52',
    'module' => 'zhuanlan',
    'file' => 'list',
    'ishtml' => '0',
    'urlrule' => '/index.html|/{$page}.html',
    'example' => '/u/admin/index.html|/u/admin/2.html',
  ),
  53 => 
  array (
    'urlruleid' => '53',
    'module' => 'mips',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => '{$categorydir}{$catdir}/{$month}{$day}/view_{$id}.html|{$categorydir}{$catdir}/{$month}{$day}/view_{$id}_{$page}.html',
    'example' => '手机站新式内容页，带日期',
  ),
  54 => 
  array (
    'urlruleid' => '54',
    'module' => 'mips',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => '{$categorydir}{$catdir}/view_{$id}.html|{$categorydir}{$catdir}/view_{$id}_{$page}.html',
    'example' => '手机站新式内容页，不带日期',
  ),
  55 => 
  array (
    'urlruleid' => '55',
    'module' => 'mips',
    'file' => 'show',
    'ishtml' => '0',
    'urlrule' => '{$catdir}/huati_{$month}{$day}_{$id}.html|{$catdir}/huati_{$month}{$day}_{$id}_{$page}.html',
    'example' => '今日话题MIP站规则',
  ),
  56 => 
  array (
    'urlruleid' => '56',
    'module' => 'mips',
    'file' => 'category',
    'ishtml' => '0',
    'urlrule' => '{$categorydir}{$catdir}/index.html|{$categorydir}{$catdir}/list_{$page}.html',
    'example' => 'MIP新式列表页',
  ),
);
?>