<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?app=license&controller=admin_license&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('aid[]');"></th>
			<th width="35" align="center"><?php echo L('listorder')?></th>
			<th width="68" align="center"><?php echo L('domain')?></th>
			<th width="68" align="center"><?php echo L('startdate')?></th>
			<th width='68' align="center"><?php echo L('enddate')?></th>
			<th width="68" align="center"><?php echo L('shouquanstart')?></th>
			<th width='68' align="center"><?php echo L('shouquanend')?></th>
			<th width='68' align="center"><?php echo L('inputer')?></th>
			<th width='68' align="center"><?php echo L('webname')?></th>
			<th width="120" align="center"><?php echo L('inputtime')?></th>
			<th width="69" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $license){
?>   
	<tr>
	<td align="center">
	<input type="checkbox" name="aid[]" value="<?php echo $license['aid']?>">
	</td>
	<td align="center" width="35"><input name='listorders[<?php echo $license['aid']?>]' type='text' size='3' value='<?php echo $license['listorder']?>' class="input-text-c"></td>
	<td><?php echo $license['domain']?></td>
	<td align="center"><?php echo $license['starttime']?></td>
	<td align="center"><?php if ($license['endtime']=='0000-00-00') {?><?php echo L('noenddate')?><?php } else {?><?php echo $license['endtime']?><?php }?></td>
	<td align="center"><?php echo $license['shouquanstart']?></td>
	<td align="center"><?php if ($license['shouquanend']=='0000-00-00') {?><?php echo L('noshouquan')?><?php } else {?><?php echo $license['shouquanend']?><?php }?></td>
	<td align="center"><?php echo $license['username']?></td>
	<td align="center"><?php echo $license['webname']?></td>
	<td align="center"><?php echo date('Y-m-d H:i:s', $license['addtime'])?></td>
	<td align="center">
	<?php if ($_GET['s']==1) {?><a href="?app=license&view=certificate&domain=<?php echo $license['domain']?>" domain="<?php echo L('preview')?>"  target="_blank"><?php }?><font class="xbtn btn-info btn-xs"><?php echo L('index')?></font><?php if ($_GET['s']==1) {?></a><?php }?>  
	<a class="xbtn btn-warning btn-xs" href="javascript:edit('<?php echo $license['aid']?>', '<?php echo safe_replace($license['domain'])?>');void(0);"><?php echo L('edit')?></a>
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
	value="<?php echo L('listorder')?>">&nbsp;&nbsp;<?php if($_GET['s']==1) {?><input name='submit' type='submit' class="button" value='<?php echo L('cancel_all_selected')?>' onClick="document.myform.action='?app=license&controller=admin_license&view=public_approval&passed=0'"><?php } elseif($_GET['s']==2) {?><input name='submit' type='submit' class="button" value='<?php echo L('pass_all_selected')?>' onClick="document.myform.action='?app=license&controller=admin_license&view=public_approval&passed=1'"><?php }?>&nbsp;&nbsp;
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=license&controller=admin_license&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function edit(id, domain) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({domain:'<?php echo L('edit_license')?>--'+domain, id:'edit', iframe:'?app=license&controller=admin_license&view=edit&aid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
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
