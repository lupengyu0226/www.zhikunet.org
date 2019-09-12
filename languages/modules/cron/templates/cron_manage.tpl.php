<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-10 pad-lr-10">
<form name="myform" action="?app=cron&controller=cron&view=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('cronid[]');"></th>
			<th align="left"><?php echo L('cronid')?></th>
			<th align="left"><?php echo L('crontype')?></th>
			<th align="left"><?php echo L('cronname')?></th>
            <th align="left"><?php echo L('parm')?></th>
			<th align="left"><?php echo L('crontime')?></th>
			<th align="left"><?php echo L('cronon')?></th>
			<th align="left"><?php echo L('addtime')?></th>
			<th align="left"><?php echo L('info')?></th>
			<th align="left"><?php echo L('croncz')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(!empty($cron)){

foreach($cron as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['cronid']?>" name="cronid[]"></td>
		<td align="left"><?php echo $v['cronid']?></td>
		<td align="left"><?php echo crontype($v['crontype'])?></td>
		<td align="left"><?php echo $v['cronname']?></td>
		<td align="left"><?php echo $v['parm']?></td>
        <td align="left"><?php echo $v['crontime']?> <?php echo L('rmin')?></td>
		<td align="left">
		<?php
		if($v['cronon']==0) {
          echo L('pause');

		}else {
			$rtime = SYS_TIME-$v ['addtime'];
			$rday = floor ( $rtime / (60 * 60 * 24) );
			$rhour = floor ( $rtime / (60 * 60) );
			$rmin = floor ( ($rtime / 60) % 60 );
			$rh = $rhour -( $rday * 24);
			echo "$rday 天$rh 小时$rmin 分";
			if ($v['cronwitch'] == 0)
			echo L('waitstop');
		}
		?>
        </td>

		<td align="left"><?php
			$ftime = floor ( (SYS_TIME - $v['addtime']) / 86400 );
		if ($ftime < 11) {
			if ($ftime == 0) {
				echo L('today'). date ( "H:i:s", $v['addtime'] );
			}
			if ($ftime == 1) {
				echo L('yesterday') . date ( "H:i:s", $v['addtime'] );
			}
			if ($ftime > 1)
				echo $ftime . '天前' . date ( "H:i:s", $v ['addtime'] );
		} else {
			echo date ( "Y-m-d H:i:s", $v ['addtime'] );
		}
		?></td>
		<td align="left"><?php echo $v ['info']?></td>

		<td align="left">
		<?php if ($v['cronon'] == 0) {?>
            <a class="xbtn btn-danger btn-xs" href="?app=cron&controller=cron&view=start&cronid=<?php echo $v['cronid'];?>"><?php echo L('start')?></a>
        <?php } else { ?>
            <a class="xbtn btn-danger btn-xs" href="?app=cron&controller=cron&view=stop&cronid=<?php echo $v['cronid'];?>"><?php echo L('pauses')?></a>
        <?php }?>
			<a class="xbtn btn-inverse btn-xs" href="?app=cron&controller=cron&view=edit&cronid=<?php echo $v['cronid'];?>"><?php echo L('edit')?></a>
            <a class="xbtn btn-info btn-xs" href="?app=cron&controller=cron&view=log&cronid=<?php echo $v['cronid'];?>"><?php echo L('jurnal')?></a>
            </td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
</div>
<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function checkuid() {
	var ids='';
	$("input[name='cronid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('cron')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
//-->
</script>
</body>
</html>
