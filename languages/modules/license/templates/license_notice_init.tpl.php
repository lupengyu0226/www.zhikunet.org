<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?app=license&controller=admin_license&view=notice_listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('aid[]');"></th>
			<th width="35" align="center"><?php echo L('listorder')?></th>
			<th width="68" align="center"><?php echo L('title')?></th>
			<th width="68" align="center"><?php echo L('content')?></th>
			<th width='68' align="center"><?php echo L('username')?></th>
			<th width='68' align="center"><?php echo L('license_tui')?></th>
			<th width="120" align="center"><?php echo L('inputtime')?></th>
			<th width="69" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $notice){
?>   
	<tr>
	<td align="center">
	<input type="checkbox" name="aid[]" value="<?php echo $notice['aid']?>">
	</td>
	<td align="center" width="35"><input name='listorders[<?php echo $notice['aid']?>]' type='text' size='3' value='<?php echo $notice['listorder']?>' class="input-text-c"></td>
	<td><?php echo $notice['title']?></td>
	<td><?php echo $notice['content']?></td>
	<td align="center"><?php echo $notice['username']?></td>
	<td align="center"><?php if($notice['tui'] =='1') {echo L('tui');}else{echo L('untui');}?></a></td>
	<td align="center"><?php echo date('Y-m-d H:i:s', $notice['addtime'])?></td>
	<td align="center">
	<a class="xbtn btn-info btn-xs"  href="javascript:notice_edit('<?php echo $notice['aid']?>', '<?php echo safe_replace($notice['title'])?>');void(0);"><?php echo L('edit')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
<input name="dosubmit" type="submit" class="button"
	value="<?php echo L('listorder')?>">&nbsp;&nbsp;<?php if($_GET['s']==1) {?><input name='submit' type='submit' class="button" value='<?php echo L('cancel_all_selected')?>' onClick="document.myform.action='?app=license&controller=admin_license&view=public_passed&passed=0'"><?php } elseif($_GET['s']==2) {?><input name='submit' type='submit' class="button" value='<?php echo L('pass_all_selected')?>' onClick="document.myform.action='?app=license&controller=admin_license&view=public_passed&passed=1'"><?php }?>&nbsp;&nbsp;
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=license&controller=admin_license&view=notice_delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function notice_edit(id, domain) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({domain:'<?php echo L('edit_license')?>--'+domain, id:'edit', iframe:'?app=license&controller=admin_license&view=notice_edit&aid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function checkuid() {
	var ids='';
	$("input[name='aid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operations')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

function listorder_up(id) {
	$.get('?app=license&controller=admin_license&view=listorder_up&aid='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		alert('<?php echo L('move_success')?>');
	} else {
	alert(msg); 
	} 
	}); 
} 
</script>
