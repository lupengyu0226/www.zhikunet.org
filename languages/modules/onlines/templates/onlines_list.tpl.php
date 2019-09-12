<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		所有分类: &nbsp;&nbsp; <a href="?app=onlines&controller=onlines&m=init">所有</a> &nbsp;&nbsp; <a href="?app=onlines&controller=onlines&m=member">电脑</a> &nbsp;&nbsp;
		<a href="?app=onlines&controller=onlines&m=waplogin">手机</a>&nbsp;
				</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="pad-lr-10">
<form name="myform" action="?app=onlines&controller=onlines&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('sessionid[]');"></th>
			<th width="150" align="center">SessionID</th>
			<th width="150" align="center">用户</th>
			<th width="15" align="center"> IP</th>
			<th width="15" align="center">地区</th>
			<th width="15" align="center">记录时间</th>
			<th width="20">模块</th>
			<th width="20">控制器</th>
			<th width="20">方法</th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $onlines){
?>   
	<tr>
	<td align="center"><input type="checkbox" name="sessionid[]" value="<?php echo $onlines['sessionid']?>"></td>
	<td width="150" align="center"><?php echo $onlines['sessionid']?></td>
	<td width="150" align="center"><?php if ($onlines['userid']== '0') {?>游客<?php } else {?><?php echo get_nickname($onlines['userid']); ?><?php }?></td>
	<td width="150" align="center"><?php echo $onlines['ip']?></td>
	<td width="150" align="center"><?php echo $ip_area->get($onlines['ip']); ?></td>
	<td width="150" align="center"><?php echo date('Y-m-d H:i:s', $onlines['lastvisit'])?></td>
    <td width="150" align="center"><?php echo $onlines['m']?></td>
	<td width="150" align="center"><?php echo $onlines['c']?></td>
	<td width="150" align="center"><?php echo $onlines['a']?></td>

	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=onlines&controller=onlines&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>