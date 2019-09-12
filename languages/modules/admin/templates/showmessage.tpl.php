<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo L('message_tips');?></title>
<style type="text/css">
<!--
*{padding:0; margin:0; font:12px/1.5 Microsoft Yahei;}
a:link,a:visited{text-decoration:none;color:#000}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{background: #fff; zoom:1; width:450px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px;border-radius: 2px;box-shadow: 1px 1px 50px rgba(0,0,0,.3);}
.showMsg h5{padding: 17px 15px;color:#fff;background: #3B4658;font-size:14px;border-radius: 2px;}
.showMsg .content{padding: 45px;line-height: 24px;word-break: break-all;overflow: hidden;font-size: 14px;overflow-x: hidden;overflow-y: auto;}
.showMsg .bottom{padding: 10px;text-align: center;border-top: 1px solid #E9E7E7;}
.showMsg .ok,.showMsg .guery{background: url(<?php echo IMG_PATH?>msg_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
-->
</style>
<script type="text/javaScript" src="<?php echo JS_PATH?>jquery.js"></script>
<script language="JavaScript" src="<?php echo JS_PATH?>admin_common.js"></script>
</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5>提示信息</h5>
    <div class="content guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:330px"><?php echo $msg?></div>
    <div class="bottom">
    <?php if($url_forward=='goback' || $url_forward=='') {?>
	<a href="javascript:history.back();" >[<?php echo L('return_previous');?>]</a>
	<?php } elseif($url_forward=="close") {?>
	<input type="button" name="close" value="<?php echo L('close');?> " onClick="window.close();">
	<?php } elseif($url_forward=="blank") {?>
	
	<?php } elseif($url_forward) { 
		if(strpos($url_forward,'&safe_edi')===false) $url_forward .= '&safe_edi='.$_SESSION['safe_edi'];
	?>
	<a href="<?php echo $url_forward?>"><?php echo L('click_here');?></a>
	<script language="javascript">setTimeout("redirect('<?php echo $url_forward?>');",<?php echo $ms?>);</script> 
	<?php }?>
	<?php if($returnjs) { ?> <script style="text/javascript"><?php echo $returnjs;?></script><?php } ?>
	<?php if ($dialog):?><script style="text/javascript">window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();</script><?php endif;?>
        </div>
</div>
<script style="text/javascript">
	function close_dialog() {
		window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();
	}
</script>
</body>
</html>