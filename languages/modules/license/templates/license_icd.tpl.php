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
			<th width="68" align="center"><?php echo L('icd')?></th>
			<th width="68" align="center"><?php echo L('icddomain')?></th>
			<th width="68" align="center"><?php echo L('startdate')?></th>
			<th width='68' align="center"><?php echo L('enddate')?></th>
			<th width="68" align="center"><?php echo L('shouquanstart')?></th>
			<th width='68' align="center"><?php echo L('shouquanend')?></th>
			<th width='68' align="center"><?php echo L('inputer')?></th>
			<th width='68' align="center"><?php echo L('webname')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $license){
?>   
<?php if ($license['icd']) {?>
	<tr>
	<td align="center"><?php echo $license['icd']?></td>
	<td align="center"><?php echo $license['domain']?></td>
	<td align="center"><?php echo $license['starttime']?></td>
	<td align="center"><?php if ($license['endtime']=='0000-00-00') {?><?php echo L('noenddate')?><?php } else {?><?php echo $license['endtime']?><?php }?></td>
	<td align="center"><?php echo $license['shouquanstart']?></td>
	<td align="center"><?php if ($license['shouquanend']=='0000-00-00') {?><?php echo L('noshouquan')?><?php } else {?><?php echo $license['shouquanend']?><?php }?></td>
	<td align="center"><?php echo $license['username']?></td>
	<td align="center"><?php echo $license['webname']?></td>
	</td>
	</tr>
	<?php }?>
<?php 
	}
}
?>
</tbody>
    </table>
</div>
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
