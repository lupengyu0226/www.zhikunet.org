<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET?>" />
<title><?php echo L('shuyang_logon')?></title>
<link href="<?php echo IMG_PATH?>admin_img/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo IMG_PATH?>admin_img/jquery.js"></script>
<script src="<?php echo IMG_PATH?>admin_img/cloud.js" type="text/javascript"></script>
<script language="javascript">
	$(function(){
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
    })  
});  
</script> 
<STYLE type=text/css>
img{ list-style:none;width: 90px;height: 28px;}
	.yzms{position:absolute; background:url(<?php echo IMG_PATH?>admin_img/login_ts140x89.gif) no-repeat; width:140px; height:89px;right:56px;top:-96px; text-align:center; font-size:12px; display:none;}
	.yzms a:link,.yzm a:visited{color:#036;text-decoration:none;}
	.yzms a:hover{color:#C30;}
	.yzms img{cursor:pointer; margin:4px auto 7px; width:130px; height:50px; border:1px solid #fff;}
</STYLE>
</head>
<body style="background-color:#1c77ac; background-image:url(<?php echo IMG_PATH?>admin_img/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  
<div class="logintop">    
    <span>欢迎登录后台管理界面平台</span>    
    <ul>
    <li><a href="http://www.05273.cn/">回首页</a></li>
    <li><a href="http://www.05273.cn/about/weixin/">微信</a></li>
    <li><a href="http://www.05273.cn/about/aboutus/">关于</a></li>
    </ul>    
    </div>
    <div class="loginbody">
    <span class="systemlogo"></span>      
    <div class="loginbox">
<form action="index.php?app=admin&controller=index&view=public_card&card=1&dosubmit=1" method="post" name="myform">
    <ul>
	<li><input type="hidden" name="rand" value="<?php echo $rand['rand']?>" /></li>
    <li><img src="<?php echo $rand['url']?>" height="24" class="kouling"/></li>
    <li><input type=code name=code class="loginpwd"/></li>
	<li><INPUT class="loginbtn" type=image src="<?php echo IMG_PATH?>admin_img/tomsix.gif" value=提交 name=dosubmit><label><?php echo L('please_input_your_password_the_picture_corresponding_location_6_digits')?></label></li>
    </ul>
    </FORM>
    </div>   
    </div> 
    <div class="loginbm">版权所有  2015  <a href="http://www.05273.cn/">沭阳网</a> </div>   
</body>
</html>