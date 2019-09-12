<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<div class="table-list">

<div class="explain-col">
<?php echo L('move_member_model_index_alert')?>
</div>

<div class="bk10"></div>
<form name="myform" id="myform" action="?app=member&controller=member_model&view=delete" method="post" onsubmit="check();return false;">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="30px"><input type="checkbox" value="" id="check_box" onclick="selectall('modelid[]');"></th>
			<th align="left">ID</th>
			<th><?php echo L('sort')?></th>
			<th align="left"><?php echo L('model_name')?></th>
			<th align="left"><?php echo L('model_description')?></th>
			<th align="left"><?php echo L('table_name')?></th>
			<th align="center"><?php echo L('status')?></th>
			<th><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($member_model_list as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['modelid']?>" name="modelid[]" <?php if($v['modelid']==10) echo "disabled";?>></td>
		<td align="left"><?php echo $v['modelid']?></td>
		<td align="center"><input type="text" name="sort[<?php echo $v['modelid']?>]" class="input-text" size="1" value="<?php echo $v['sort']?>"></th>
		<td align="left"><?php echo $v['name']?></td>
		<td align="left"><?php echo $v['description']?></td>
		<td align="left"><?php echo $this->db->db_tablepre.$v['tablename']?></td>
		<td align="center"><?php echo $v['disabled'] ? L('icon_locked') : L('icon_unlock')?></td>
		<td align="center">
		<a class="xbtn btn-info btn-xs"  onclick="_M(892);" href="?app=member&controller=member_modelfield&view=manage&modelid=<?php echo $v['modelid']?>&menuid=892"><?php echo L('field').L('manage')?></a>   <a class="xbtn btn-primary btn-xs" href="javascript:edit(<?php echo $v['modelid']?>, '<?php echo $v['name']?>')"><?php echo L('edit')?></a>   <a class="xbtn btn-inverse btn-xs" href="?app=member&controller=member_model&view=export&modelid=<?php echo $v['modelid']?>"><?php echo L('export')?></a>   <a class="xbtn btn-warning btn-xs" href="javascript:move(<?php echo $v['modelid']?>, '<?php echo $v['name']?>')"><?php echo L('move')?></a>
		</td>
    </tr>
<?php
	}
?>
</tbody>
</table>

<div class="btn"><label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?app=member&controller=member_model&view=sort'" value="<?php echo L('sort')?>"/>
</div> 
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</form>
<div id="PC__contentHeight" style="display:none">160</div>

<script language="JavaScript">
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member_model')?>《'+name+'》',id:'edit',iframe:'?app=member&controller=member_model&view=edit&modelid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function move(id, name) {
	window.top.art.dialog({id:'move'}).close();
	window.top.art.dialog({title:'<?php echo L('move')?>《'+name+'》',id:'move',iframe:'?app=member&controller=member_model&view=move&modelid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'move'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'move'}).close()});
}

function check() {
	if(myform.action == '?app=member&controller=member_model&view=delete') {
		var ids='';
		$("input[name='modelid[]']:checked").each(function(i, n){
			ids += $(n).val() + ',';
		});
		if(ids=='') {
			window.top.art.dialog({content:'<?php echo L('plsease_select').L('member_model')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
			return false;
		}
	}
	myform.submit();
}

//修改菜单地址栏
function _M(menuid) {
	$.get("?app=admin&controller=index&view=public_current_pos&menuid="+menuid, function(data){
		parent.$("#current_pos").html(data);
	});
}

//-->
</script>
</body>
</html>
