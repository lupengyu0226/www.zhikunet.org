<?php
defined('IN_SHUYANG') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(
array(
   'name'=>'weixin',
   'parentid'=>0,//weixin模块的父ID是0，显示在导航栏上1669
   'm'=>'weixin',
   'c'=>'weixin',
   'a'=>'init',
   'data'=>'',
   'listorder'=>2,
   'display'=>'1'//显示菜单，1显示，0隐藏
   ),
 true//插入菜单后是否返回ID，true返回,以供下面使用
);
//}
//菜单管理
$weixin_manage_id=$menu_db->insert(
array(
   'name'=>'weixin_manage',
   'parentid'=>$parentid,
   'm'=>'weixin',
   'c'=>'weixin',
   'a'=>'init',
   'data'=>'',
   'listorder'=>0,
   'display'=>'1'
   ),
   true
  );
 //自定义菜单
$module_manage_id=$menu_db->insert(
array(
   'name'=>'menus_manage',
   'parentid'=>$weixin_manage_id,
   'm'=>'weixin',
   'c'=>'weixin',
   'a'=>'init',
   'data'=>'',
   'listorder'=>0,
   'display'=>'1'
   ),
   true
  );
$menu_db->insert(
array(
 'name'=>'menushow',
 'parentid'=>$module_manage_id,
 'm'=>'weixin',
 'c'=>'weixin',
 'a'=>'menushow',
 'data'=>'',
 'listorder'=>1,
 'display'=>'1'
  )
);
//接口配置
$menu_db->insert(
array(
 'name'=>'api',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'weixin',
 'a'=>'setting',
 'data'=>'',
 'listorder'=>6,
 'display'=>'1'
  )
);
$menu_db->insert(
array(
 'name'=>'service',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'service',
 'a'=>'init',
 'data'=>'',
 'listorder'=>3,
 'display'=>'1'
  )
);

//用户管理
$user_manage_id = $menu_db->insert(
array(
 'name'=>'user_manage',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'usermanage',
 'a'=>'init',
 'data'=>'',
 'listorder'=>0,
 'display'=>'1'
 ),
 true
);

$groups_manage_id = $menu_db->insert(
array(
 'name'=>'groups_manage',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'usermanage',
 'a'=>'groupmanage',
 'data'=>'',
 'listorder'=>1,
 'display'=>'1'
 ),
 true
);

$menu_db->insert(
array(
 'name'=>'sent_cgroup_news',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'typesmanage',
 'a'=>'catlist',
 'data'=>'',
 'listorder'=>4,
 'display'=>'1'
 )
);


$reply_manage_id=$menu_db->insert(
array(
 'name'=>'reply',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'reply',
 'a'=>'init',
 'data'=>'',
 'listorder'=>3,
 'display'=>'1'
 ),
 true
);
$menu_db->insert(
array(
 'name'=>'noreply',
 'parentid'=>$reply_manage_id,
 'm'=>'weixin',
 'c'=>'reply',
 'a'=>'noreply',
 'data'=>'',
 'listorder'=>1,
 'display'=>'1'
  )
);

$focusreply_manage_id = $menu_db->insert(
array(
 'name'=>'focusreplymanage',
 'parentid'=>$weixin_manage_id,
 'm'=>'weixin',
 'c'=>'focusreply',
 'a'=>'init',
 'data'=>'',
 'listorder'=>5,
 'display'=>'1'
 ),
 true
);

$language = array(
				  'weixin'=>'微信',
				  'weixin_manage'=>'微信管理',
				  'reply'=>'智能回复管理',
				  'service'=>'多客服务',
				  'noreply'=>'回复不上来配置',
				  'focusreplymanage'=>'关注回复管理',
				  'focusreply'=>'图文回复',
				  'ticket'=>'推广支持',
				  'service_manage'=>'客服管理',
				  'user_manage'=>'用户管理',
				  'sent_cgroup_news'=>'分组群发',
				  'groupmanage'=>'分组管理',
				  'groups_manage'=>'分组管理',
				  'sent_togroup_manage'=>'分组群发',
				  'menus_manage'=>'菜单管理',
				  'menushow'=>'菜单查询',
				  'addtext'=>'添加文本',
				  'api'=>'接口配置'
				  );