<?php
return array(
//网站路径
'web_path' => '/',
//Session配置
'session_storage' => 'mysql',
'session_ttl' => 1800,
'session_savepath' => CACHE_PATH.'sessions/',
'session_n' => 0,
//Cookie配置
'cookie_domain' => '.05273.cn', //Cookie 作用域
'cookie_path' => '/', //Cookie 作用路径
'cookie_pre' => 'dNkHg_', //Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
'cookie_ttl' => 0, //Cookie 生命周期，0 表示随浏览器进程

'js_path' => 'https://account.05273.cn/statics/js/', //CDN JS
'css_path' => 'https://account.05273.cn/statics/css/', //CDN CSS
'img_path' => 'https://account.05273.cn/statics/images/', //CDN img
'upload_path' => SHUYANG_PATH.'uploadfile/', //上传文件路径
'app_path' => 'https://account.05273.cn/',//动态域名配置地址
'safe_code' => 'xinxilan', //后台安全码
'charset' => 'UTF-8', //网站字符集
'timezone' => 'Etc/GMT-8', //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8
'debug' => 1, //是否显示调试信息
'admin_log' => 0, //是否记录后台操作日志
'errorlog' => 0, //是否保存错误日志
'gzip' => 1, //是否Gzip压缩后输出
'auth_key' => 'GVVDW8AXV09DWIS92E5H', // //Cookie密钥
'lang' => 'zh-cn',  //网站语言包
'admin_founders' => '1', //网站创始人ID，多个ID逗号分隔
'execution_sql' => 0, //EXECUTION_SQL
//UCenter配置开始
'ucuse'=>'1',//是否开启UC
'uc_api'=>'https://uc.05273.cn',//Ucenter api 地址
'uc_ip'=>'',//Ucenter api IP
'uc_dbhost'=>'localhost',//Ucenter 数据库主机名
'uc_dbuser'=>'shuyang',//Ucenter 数据库用户名
'uc_dbpw'=>'123456',//Ucenter 数据库密码
'uc_dbname'=>'shuyang',//Ucenter 数据库名
'uc_dbtablepre'=>'`shuyang`.uc_',//Ucenter 数据库表前缀
'uc_dbcharset'=>'utf8',//Ucenter 数据库字符集
'uc_appid'=>'28',//应用id(APP ID)
'uc_key'=>'shuyangwang2014',//Ucenter 通信密钥
);
?>
