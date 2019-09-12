<?php 
	defined('IN_SHUYANG') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
  <table cellpadding="0" cellspacing="1" class="table_form" width="100%">
	<caption>启动任务</caption>
	<tr>
		<td style="text-align: center"><img src="<?php echo IMG_PATH?>msg_img/loading_d.gif"></td>
	</tr>
	<tr>
		<td style="text-align: center">
		<div id="box">正在启动任务</div>
		</td>
	</tr>
</table>
<iframe src="?app=cron&controller=cron&view=<?php echo $crontype;?>&cronid=<?php echo $cronid;?>" width="0" height="0"></iframe>
<br>
<script type="text/javascript">
setTimeout("display()",5000);
setTimeout("goback()",8000);
function display() 
{
	box.innerHTML="成功完成启动,3秒后自动返回";	
}
function goback()
{
	location.href='?app=cron&controller=cron&view=init&safe_edi=<?php echo $_SESSION['safe_edi'];?>'
}
</script>
</div>
</body></html>
