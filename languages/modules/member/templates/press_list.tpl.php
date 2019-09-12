<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<form name="myform" id="myform" action="?app=member&controller=admin_press&view=listorder" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="10%">用户</th>
			<th width="25%" >标题</th>
			<th width="10%">状态</th>
			<th width="13%">提交时间</th>
			<th width="12%" align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" width="35"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
		<td><?php echo $info['username']?></td>
		<td align="center" width="12%"><a href="<?php echo $info['url'];?>" target="_blank"><?php echo $info['title']?></a></td>
		<td align="center"><?php if($info['passed']=='0'){ echo "未处理";}else{echo "已处理";}?></td>
		<td  align="center"><?php echo date("Y-m-d H:i:s",$info['addtime']);?></td>
		<td align="center" width="12%"><a class="xbtn btn-info btn-xs" href="###"
			onclick="view(<?php echo $info['id']?>, '<?php echo new_addslashes($info['name'])?>')">查看</a>
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
<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=member&controller=admin_press&view=delete'" value="<?php echo L('delete')?>"/></div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">

function view(id) {
	window.top.art.dialog({id:'view'}).close();
	window.top.art.dialog({title:'<?php echo L('view')?>', id:'view', iframe:'?app=member&controller=admin_press&view=view&id='+id, width:'550px', height:'420px'}, function(){window.top.art.dialog({id:'view'}).close();}, function(){window.top.art.dialog({id:'view'}).close();})
	}
</script>



</body>
</html>
