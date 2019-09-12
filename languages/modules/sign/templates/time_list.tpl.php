<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
    </tbody>
</table>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>昵称</th>
			<th>签到时间</th>
			<th>签到IP</th>
			<th>签到积分</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $v){
		?>
	<tr align="center">
		<td><?php echo get_nickname($v['userid']); ?></td>
        <?php $weekday = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');?>
		<td><?php echo date("Y-m-d H:i:s",$v['signtime']); ?> <?php echo $weekday[date('w', $v['signtime'])];?></td>
		<td><?php echo $v['signip']; ?></td>
		<td><?php echo $v['signpoint']; ?></td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
</body>
</html>