<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET?>" />
<title>沭阳网提示</title>
<script language="JavaScript" src="<?php echo JS_PATH?>admin_common.js"></script>
<link href="https://statics.05273.cn/statics/css/tips.css" rel="stylesheet" />
</head>
<body>
<div class="wrap">
  <div id="error_tips">
    <h2>沭阳网提示</h2>
    <div class="error_cont">
      <ul>
        <li><?php echo $msg?></li>
      </ul>
      <div class="error_return">
    <?php if($url_forward=='goback' || $url_forward=='') {?>
	<a href="javascript:history.back();" ><?php echo L('go_history')?></a>
	<?php } elseif($url_forward=="close") {?>
	<input type="button" name="close" value=" 关闭 " onClick="window.close();">
	<?php } elseif($url_forward=="blank") {?>
	<?php } elseif($url_forward) { ?>
	<a href="<?php echo url($url_forward, 1)?>"><?php echo L('jump_message')?></a>
	<script language="javascript">setTimeout("redirect('<?php echo url($url_forward, 1)?>');",<?php echo $ms?>);</script> 
	<?php }?>
	<?php if ($dialog):?><script style="text/javascript">window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();</script><?php endif;?>
</div>
    </div>
  </div>
</div>
<script style="text/javascript">
	function close_dialog() {
		window.top.right.location.reload();window.top.art.dialog({id:"<?php echo $dialog?>"}).close();
	}
</script>
</body>
</html>