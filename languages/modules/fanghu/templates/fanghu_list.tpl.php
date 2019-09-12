<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?app=fanghu&controller=fanghu&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="35" align="center"><?php echo L('wangzhi')?></th>
			<th width="35" align="center"><?php echo L('ttime')?></th>
			<th width="40" align="center"><?php echo L('ip')?></th>
			<th width="40" align="center"><?php echo L('iparea')?></th>
			<th width="20" align="center"><?php echo L('page')?></th>
			<th width="20" align="center"><?php echo L('method')?></th>
			<th width="20" align="center"><?php echo L('rkey')?></th>
			<th width="20" align="center"><?php echo L('call')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $fanghu){
?>   
	<tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo $fanghu['id']?>"></td>
	<td width="35" align="center"><?php echo $fanghu['wangzhi']?></td>
	<td width="35" align="center"><?php echo $fanghu['ttime']?></td>
	<td width="20" align="center"><?php echo L(addslashes(htmlspecialchars($fanghu['ip'])))?></td>
	<td width="10" align="center"><?php echo $ip_area->get($fanghu['ip']); ?></td>
	<td width="20" align="center"><?php echo L(addslashes(htmlspecialchars($fanghu['page'])))?></td>
	<td width="20" align="center"><?php echo L(addslashes(htmlspecialchars($fanghu['method'])))?></td>
	<td width="20" align="center"><?php echo L(addslashes(htmlspecialchars($fanghu['rkey'])))?></td>
	<td align="center">
	<a class="xbtn btn-info btn-xs" href="javascript:call(<?php echo $fanghu['id']?>);void(0);"><?php echo L('call')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=fanghu&controller=fanghu&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">

function call(id) {
	window.top.art.dialog({id:'call'}).close();
	window.top.art.dialog({title:'<?php echo L('fanghu_call')?>', id:'call', iframe:'?app=fanghu&controller=fanghu&view=call&id='+id, width:'600px', height:'470px'}, function(){window.top.art.dialog({id:'call'}).close();}, function(){window.top.art.dialog({id:'call'}).close();})
	}

</script>
