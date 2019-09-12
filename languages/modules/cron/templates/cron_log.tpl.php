<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
	$safe_edi = $_SESSION['safe_edi'];
?>
<div class="pad-10">
  <div class="table-list">
    <fieldset>
    <legend><?php echo L('Analysis')?></legend>
    <div class="bk15"></div>
    <table cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <th><?php echo L('cronname')?></th>
        <th width="120" align="center"><?php echo L('shouci')?></th>
        <th width="120"><?php echo L('moci')?></th>
        <th width="60"><?php echo L('yxcs')?></th>
        <th width="60"><?php echo L('cgcs')?></th>
        <th width="60"><?php echo L('ztcs')?></th>
        <th><?php echo L('zongji')?></th>
        <th><?php echo L('jgfx')?></th>
        <th width="220"><?php echo L('qlrz')?></th>
      </tr>
      <tr>
        <td width="100" style="text-align: center"><?php echo $cronname;?> </td>
        <td style="text-align: center"><?php if($begtime) {echo date( 'Y-m-d H:i', $begtime );}else{echo '未执行';}?></td>
        <td style="text-align: center"><?php if($endtime) {echo date( 'Y-m-d H:i', $endtime );}else{echo '未执行';}?></td>
        <td style="text-align: center"><?php echo $runtimes;?> </td>
        <td style="text-align: center"><?php echo $runok;?> </td>
        <td style="text-align: center"><?php echo $runerr;?> </td>
        <td width="200" style="text-align: center"><?php
	$rtime = SYS_TIME-$begtime;
	$rday = floor ( $rtime / (60 * 60 * 24) );
	$rhour = floor ( $rtime / (60 * 60) );
	$rmin = floor ( ($rtime/ 60) % 60 );
	$rh = $rhour -( $rday * 24);
	echo $rday . " 天 " . $rh . " 小时 " . $rmin . " 分钟 ";
	?>
        </td>
        <td style="text-align: center">
		<?php if ($counttime > 0) {?>
          <font class="xbtn btn-danger btn-xs"><?php echo L('tishis')?><?php echo $countmin;?><?php echo L('rmin')?></font>
        <?php } else {?>
          <font class="xbtn btn-white btn-xs"><?php echo L('shunli')?></font>
        <?php }?>
        </td>
        <td width="300" style="text-align: center"><?php
	$all = time ();
	$day = $all - 86400;
	$sday = $all - 86400 * 3;
	$week = $all - 86400 * 7;
	$mth = $all - 86400 * 30;
	?>
  <a class="xbtn btn-info btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=logdel', '<?php echo L('删除所有计划任务的日志')?>')"><?php echo L('所有')?></a> 
  <a class="xbtn btn-info btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=logdel&logcronid=<?php echo $logcronid;?>&deltype=<?php echo $all;?>', '<?php echo L('delquanbu')?>')"><?php echo L('quanbu')?></a> 
  <a class="xbtn btn-info btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=logdel&logcronid=<?php echo $logcronid;?>&deltype=<?php echo $day;?>', '<?php echo L('delyitian')?>')"><?php echo L('yitianqian')?></a> 
  <a class="xbtn btn-info btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=logdel&logcronid=<?php echo $logcronid;?>&deltype=<?php echo $sday;?>', '<?php echo L('delsantian')?>')"><?php echo L('santianqian')?></a> 
  <a class="xbtn btn-info btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=logdel&logcronid=<?php echo $logcronid;?>&deltype=<?php echo $week;?>', '<?php echo L('delyizhou')?>')"><?php echo L('yizhouqian')?></a> 
  <a class="xbtn btn-info btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=logdel&logcronid=<?php echo $logcronid;?>&deltype=<?php echo $mth;?>', '<?php echo L('delyiyue')?>')"><?php echo L('yiyueqian')?></a>
      </tr>
    </table>
    </fieldset>
    <fieldset>
    <legend><?php echo L('lists')?></legend>
    <div class="bk15"></div>
    <table width="100%" cellspacing="0">
        <thead>
      <tr>
        <th style="width: 10%"><?php echo L('rizhiid')?></th>
        <th style="width: 10%"><?php echo L('cronid')?></th>
        <th><?php echo L('crontype')?></th>
        <th><?php echo L('daxiao')?></th>
        <th><?php echo L('info')?></th>
        <th><?php echo L('rizhitime')?></th>
		<th><?php echo L('delete')?></th>
      </tr>
      </thead>
       <tbody>
<?php
if (is_array ( $cron ))
	foreach ( $cron as $cron ) {
?>
<?php if ($cron['loginfo']=='成功') {?>
   
      <tr height="22px;">
        <td style="text-align: center"><?php echo $cron['logid']; ?></td>
        <td style="text-align: center"><?php echo $cron['logcronid']; ?></td>
        <td style="text-align: center"><?php echo selcrontypes($cron['logcronid']); ?></td>
        <td style="text-align: center"><?php echo $cron['logsize']; ?></td>
        <td style="text-align: center"><?php echo $cron['loginfo']; ?></td>
        <td style="text-align: center"><?php echo date( "Y-m-d H:i:s", $cron ['logtime'] ); ?></td>
		<td style="text-align: center"><a class="xbtn btn-danger btn-xs" href="javascript:confirmurl('?app=cron&controller=cron&view=loglist&logid=<?php echo $cron['logid']; ?>', '删除此条日志？')"><?php echo L('delete')?></a>
		</td>
      </tr>
    
	  <?php }?>
<?php
	}
?>
</tbody>
    </table>
    <div id="pages"><?php echo $pages?></div>
    </fieldset>
  </div>
</div>
</body></html>
