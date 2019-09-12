<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo L('shuyang_logon')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=5.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="stylesheet" type="text/css" href="//statics.zhikunet.org/statics/images/admin_img/oasisl.css" />
</head>
<link rel="stylesheet" type="text/css" href="//statics.zhikunet.org/statics/images/admin_img/login.css?V1.0.1" />
<link rel="stylesheet" type="text/css" href="//statics.zhikunet.org/statics/images/admin_img/login_new.css?V1.0.1" />
<script type="text/javascript" src="//statics.zhikunet.org/statics/images/admin_img/vendor.js"></script>
<script type="text/javascript" src="//statics.zhikunet.org/statics/images/admin_img/webpackJsonp.js"></script>
<body onload="javascript:document.myform.username.focus();">
	<div class="lg-page-container">
		<div class="lg-page-bd">
			<div class="bg-container"></div>
			<div id="particles"><canvas class="particles-js-canvas-el" width="1902" height="362" style="width: 100%; height: 100%;"></canvas></div>
			<div class="login-panel animated fadeInUp">
                <div class="login-hd"><i class="logo"></i></div>
                <div class="login-input-panel">
                <form action="index.php?app=admin&controller=index&view=login&dosubmit=1" method="post" name="myform">
						<div class="login-frm-bd">
                            <div class="mask"></div>
                            <div class="login-content-wrap clearfix">
                                <div class="login-type-btn input-wrap">
                                   <div class="opacity-bg"></div>
                                   <input type="text" title="请输入登录帐号" name="username" id="username" placeholder="<?php echo L('username')?>" />
                                </div>
                                <div class="login-type-btn input-wrap">
                                   <div class="opacity-bg"></div>
                                   <input type="password" title="请输入登录密码" name="password" id="password" placeholder="<?php echo L('password')?>" autocomplete="off" />
                                </div>
                                <div class="login-type-btn input-wrap">
                                   <div class="opacity-bg"></div>
                                   <input type="text" title="请输入验证码" name="code" id="code" placeholder="<?php echo L('security_code')?>" autocomplete="off"  onfocus="document.getElementById('yzm').style.display='block'"/>
                                   <div id="yzm" class="yzm"><?php echo form::checkcode('code_img')?><br /><a href="javascript:document.getElementById('code_img').src='<?php echo SITE_PROTOCOL.SITE_URL.WEB_PATH;?>index.php?app=api&controller=index&op=checkcode&app=admin&controller=index&view=checkcode&time='+Math.random();void(0);"><?php echo L('click_change_validate')?></a></div>
                                </div>				
								<div class="login-type-btn login-frm-btn">
                                <input name="dosubmit" value="" type="submit" class="loginBtn" />
								</div>
                    			</div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="copyRight">版权所有：智库联盟北京运营中心</p>
       </div>
    </div>
</body>
</body>
</html>