<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		快讯仅能一条，多条只显示最新一条
		</div>
		</td>
		</tr>
    </tbody>
</table>
<form name="myform" id="myform" action="?app=kuaixun&controller=kuaixun&view=listorder" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('kuaixunid[]');"></th>
			<th width="35" align="center"><?php echo L('listorder')?></th>
			<th><?php echo L('kuaixun_name')?></th>
			<th width="10%" align="center"><?php echo L('url')?></th>
			<th width='10%' align="center"><?php echo L('type')?></th>
			<th width="8%" align="center"><?php echo L('status')?></th>
			<th width="12%" align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" width="35"><input type="checkbox" name="kuaixunid[]" value="<?php echo $info['kuaixunid']?>"></td>
		<td align="center" width="35"><input name='listorders[<?php echo $info['kuaixunid']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
		<td><?php echo new_html_special_chars($info['name'])?></td>
		<td align="center" width="10%"><a href="<?php echo $info['url'];?>" target="_blank"><?php echo $info['url'];?></a></td>
		<td align="center" width="10%"><?php echo $info['lx'];?></td>
		<td width="8%" align="center"><?php if($info['passed']=='0'){?><a class="xbtn btn-warning btn-xs" 
			href='?app=kuaixun&controller=kuaixun&view=check&kuaixunid=<?php echo $info['kuaixunid']?>'
			onClick="return confirm('<?php echo L('pass_or_not')?>')"><?php echo L('audit')?></font><?php }else{echo L('<font class="xbtn btn-info btn-xs">通过</font>');}?></td>
		<td align="center" width="12%"><a class="xbtn btn-info btn-xs" href="###"
			onclick="edit(<?php echo $info['kuaixunid']?>, '<?php echo new_addslashes(new_html_special_chars($info['name']))?>')"
			title="<?php echo L('edit')?>"><?php echo L('edit')?></a>    <a class="xbtn btn-danger btn-xs"
			href='?app=kuaixun&controller=kuaixun&view=delete&kuaixunid=<?php echo $info['kuaixunid']?>'
			onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_htmlentities($info['name']))))?>')"><?php echo L('delete')?></a> 
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div class="btn"> 
<input name="dosubmit" type="submit" class="button"
	value="<?php echo L('listorder')?>">&nbsp;&nbsp;<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=kuaixun&controller=kuaixun&view=delete'" value="<?php echo L('delete')?>"/></div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?app=kuaixun&controller=kuaixun&view=edit&kuaixunid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function checkuid() {
	var ids='';
	$("input[name='kuaixunid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operations')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
//向下移动
function listorder_up(id) {
	$.get('?app=kuaixun&controller=kuaixun&view=listorder_up&kuaixunid='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		alert('<?php echo L('move_success')?>');
	} else {
	alert(msg); 
	} 
	}); 
} 
</script>
</body>
</html>
