<?php
return array(
//网站路径
'web_path' => '/',
//Session配置
'session_storage' => 'mysql',
'session_ttl' => 3600,
'session_savepath' => CACHE_PATH.'sessions/',
'session_n' => 0,
//Cookie配置
'cookie_domain' => '', //Cookie 作用域
'cookie_path' => '', //Cookie 作用路径
'cookie_pre' => 'KKM_', //Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
'cookie_ttl' => 36000, //Cookie 生命周期，0 表示随浏览器进程
//模板相关配置
'tpl_root' => 'templates/', //模板保存物理路径
'tpl_name' => 'default', //当前模板方案目录
'tpl_css' => 'default', //当前样式目录
'tpl_referesh' => 1,
'tpl_edit'=>0,//是否允许在线编辑模板
'alivulfix' => 'yes',
//附件相关配置
'upload_path' => SHUYANG_PATH.'uploadfile/',
'upload_url' => 'https://img.zhikunet.org/', //附件路径
'attachment_stat' => '1',//是否记录附件使用状态 0 统计 1 统计， 注意: 本功能会加重服务器负担
'js_path' => '//statics.zhikunet.org/statics/js/', //CDN JS
'css_path' => '//statics.zhikunet.org/statics/css/', //CDN CSS
'img_path' => '//statics.zhikunet.org/statics/images/', //CDN img
'passport_path' => 'https://passport.zhikunet.org/', //login
'so_path' => 'http://so.zhikunet.org/', //sousuo
'mobile_path' => 'https://wap.zhikunet.org/', //手机站域名
'mip_path' => 'https://mip.zhikunet.org/', //ipad域名
'app_path' => 'https://ww.zhikunet.org/',//动态域名配置地址
'charset' => 'utf-8', //网站字符集
'timezone' => 'Etc/GMT-8', //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8
'debug' => 1, //是否显示调试信息
'admin_log' => 1, //是否记录后台操作日志
'errorlog' => 0, //1、保存错误日志到 cache/error_log.php | 0、在页面直接显示
'gzip' => 1, //是否Gzip压缩后输出
'delpanel' => '1', //是否锁定快捷方式
'auth_key' => 'P6ABX0XA11OS8WCSW9VO', //密钥
'lang' => 'zh-cn',  //网站语言包
'lock_ex' => '1',  //写入缓存时是否建立文件互斥锁定（如果使用nfs建议关闭）
'logo_model' => 'hd', //LOGO图片地址
'admin_founders' => '1', //网站创始人ID，多个ID逗号分隔
'execution_sql' => 0, //EXECUTION_SQL
'festival_off' => '0',//节日开关，0关1开
'festival_url' => 'qingmingjie',
'phpsso' => '1',	//是否使用phpsso
'phpsso_appid' => '1',	//应用id	
'phpsso_api_url' => 'https://account.zhikunet.org',	//接口地址
'phpsso_auth_key' => 'nnrpude7e3bsmlp4l9gqnjl7lykleig4', //加密密钥
'phpsso_version' => '1', //phpsso版本
'html_root' => '',//生成静态文件路径
'safe_card'=>'1',//是否启用口令卡
'safe_model' => '普通模式',//网站防御模式
'safe_off' => '1', //是否开启防御系统,1开启，0关闭
'safe_key' => '63a598e318f5d1dd3bc33a8b6414cc63', //安全防御防御密钥
'connect_enable' => '1',	//是否开启外部通行证
'sina_akey' => '445594341',	//sina AKEY
'sina_skey' => 'c90ec3b1c77dac632ef9323688159543',	//sina SKEY
'qq_appid' => '200561',
'qq_appkey' => 'e256e18f4963dd2cc07cce6d357aa2bc',
'qq_callback' => 'https://passport.zhikunet.org/member-public_qq_loginnew.html',
'wap_qq_callback' => 'https://passport.zhikunet.org/member-public_qq_loginnew.html',
'xzh_appid' => 'EO0OZLDFxUIWPOmLe1pgsSm9d9S5z8TL',
'xzh_appkey' => 'MiX5dwgfu0ERNDWKHQQLcLLKuE5zK1Qx',
'xzh_callback' => 'https://passport.zhikunet.org/member-public_xzh.html',
'wap_xzh_callback' => 'https://wap.zhikunet.org/index.php?app=waplogin&controller=index&view=public_xzh',
'wx_appid' => 'wx9524143fc583dbda',
'wx_appkey' => '5c005cd898e8beade826adbfbe1ad4d2',
'wx_callback' => 'https://wap.zhikunet.org/index.php?app=waplogin&controller=index&view=public_wx',
'plugin_debug' => '0',
'admin_url' => '',	//允许访问后台的域名
//智能机器人配置
'shyrobots' => array('大美沭阳','沭阳新闻哥','指尖沭阳','龙腾盛世','互动沭阳','夕竹紫天','心之泪雨','我爱的人','沭阳吧','完善沭阳','陶小闲','妖猫妖妖','果冻宝贝','myedi','爱你','沭阳在线','沭阳视窗','擎天柱','今日沭阳','柳晓原','解月清'),
//附件CDN域名配置
'cdnws' => array('https://img.zhikunet.org/')
);
?>