<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<form name="myform" action="?app=search&controller=search_type&view=listorder" method="post">
<div class="pad_10">
<div class="table-list">

<div class="explain-col">
<?php echo L('searh_notice')?>
</div>
<div class="bk10"></div>
    <table width="100%" cellspacing="0" >
        <thead>
			<tr>
			<th width="55"><?php echo L('sort')?></td>
			<th width="35">ID</th>
			<th width="120"><?php echo L('catname')?></th>
			<th width="80"><?php echo L('modulename')?></th>
			<th width="80"><?php echo L('modlename')?></th>
			<th width="*"><?php echo L('catdescription')?></th>
			<th width="80"><?php echo L('opreration')?></th>
			</tr>
        </thead>
    <tbody>
    

<?php
foreach($datas as $r) {
?>
<tr>
<td align="center"><input type="text" name="listorders[<?php echo $r['typeid']?>]" value="<?php echo $r['listorder']?>" size="3" class='input-text-c'></td>
<td align="center"><?php echo $r['typeid']?></td>
<td align="center"><?php echo $r['name']?></td>
<td align="center"><?php echo $r['modelid'] && $r['typedir'] !='yp' ? L('content_module') : $r['typedir'];?></td>
<td align="center"><?php echo $this->model[$r['modelid']]['name'] ? $this->model[$r['modelid']]['name'] : $this->yp_model[$r['modelid']]['name']?></td>
<td ><?php echo $r['description']?></td>
<td align="center"><a class="xbtn btn-info btn-xs"  href="javascript:edit('<?php echo $r['typeid']?>','<?php echo $r['name']?>')"><?php echo L('modify')?></a>   <a class="xbtn btn-danger btn-xs" href="?app=search&controller=search_type&view=delete&typeid=<?php echo $r['typeid']?>" onclick="return confirm('<?php echo L('sure_delete', '', 'member')?>')"><?php echo L('delete')?></a> </td>
</tr>
<?php } ?>
	</tbody>
    </table>

    <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
<div id="pages"><?php echo $pages;?></div>
</div>
</form>

<script type="text/javascript"> 
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit_cat')?>《'+name+'》',id:'edit',iframe:'?app=search&controller=search_type&view=edit&typeid='+id,width:'580',height:'400'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function data_delete(obj,id,name){
	window.top.art.dialog({content:name, fixed:true, style:'confirm', id:'data_delete'}, 
	function(){
	$.get('?app=search&controller=search_type&view=delete&typeid='+id+'&safe_edi='+safe_edi,function(data){
				if(data) {
					$(obj).parent().parent().fadeOut("slow");
				}
			}) 	
		 }, 
	function(){});
};
//-->
</script>
</body>
</html>
