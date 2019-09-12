<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<form action="?app=sign&controller=sign&view=set&siteid=<?php echo $siteid; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100">开始时间：</th>
		<td><input type="text" name="starttime" size="30" value="<?php echo $starttime; ?>" class="starttime"></td>
	</tr>
    <tr>
		<th width="100">结束时间：</th>
		<td><input type="text" name="endtime" size="30" value="<?php echo $endtime; ?>" class="endtime"></td>
	</tr>
     <tr>
		<th width="100"></th>
		<td>开始时间和结束时间都不填，默认为每天24小时之内签到都有效，填写则为签到在固定时间段。</td>
	</tr>
	<tr>
		<th width="100">每次签到得积分：</th>
		<td><input type="text" name="setpoint" size="30" value="<?php echo $setpoint; ?>" ></td>
	</tr>
	<tr>
		<th width="100">连续积分限制：</th>
		<td><input type="text" name="limit" size="30" value="<?php echo $limit; ?>" ></td>
	</tr>
    <tr>
		<th width="100"></th>
		<td>例如填写5，每次签到积分为1，那么第一次签到得1积分，第二次得2积分，... ，第五次得5积分，超过五次的都是5积分</td>
	</tr>
    <tr>
		<th></th>
		<td><input type="submit" name="dosubmit" value=" <?php echo L('submit')?> "></td>
	</tr>
</table>
</form>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>datetime.js"></script>
</div>
</body>
</html>