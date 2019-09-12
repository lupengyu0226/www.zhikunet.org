<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?app=jubao&controller=jubao&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="20" align="center"><?php echo L('userid')?></th>
			<th width="150" align="center"><?php echo L('title')?></th>
			<th width="15" align="center"><?php echo L('adddate')?></th>
			<th width="20"><?php echo L('status')?></th>
			<th width="20" align="center"><?php echo L('call')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $jubao){
?>   
	<tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo $jubao['id']?>"></td>
	<td width="20" align="center"><?php echo $jubao['userid']==0 ? L('游客') : $jubao['userid']?></td>
	<td width="150" align="center"><?php echo $jubao['title']?></td>
	<td width="30" align="center"><?php echo date('Y-m-d H:i:s', $jubao['adddate'])?></td>
    <td width="20" ><?php echo $jubao['status']==0 ? L('<font class="xbtn btn-warning btn-xs">未处理</font>') : L('<font class="xbtn btn-primary btn-xs">已处理</font>')?></td>
	<td align="center">
	<a class="xbtn btn-info btn-xs" href="javascript:call(<?php echo $jubao['id']?>);void(0);"><?php echo L('call')?></a>
	</td>

	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=jubao&controller=jubao&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">

function call(id) {
	window.top.art.dialog({id:'call'}).close();
	window.top.art.dialog({title:'<?php echo L('jubao_call')?>', id:'call', iframe:'?app=jubao&controller=jubao&view=call&id='+id, width:'550px', height:'570px'}, function(){window.top.art.dialog({id:'call'}).close();}, function(){window.top.art.dialog({id:'call'}).close();})
	}

</script>