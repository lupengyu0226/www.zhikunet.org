<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		<?php echo L('所有分类')?>: &nbsp;&nbsp; <a href="?app=ssi&controller=ssi"><?php echo L('all')?></a> &nbsp;&nbsp;
		<a href="?app=ssi&controller=ssi&typeid=0">默认分类</a>&nbsp;
		<?php
	if(is_array($type_arr)){
	foreach($type_arr as $typeid => $type){
		?><a href="?app=ssi&controller=ssi&typeid=<?php echo $typeid;?>"><?php echo $type;?></a>&nbsp;
		<?php }}?>
		</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
        <th width="5%"><?php echo L('id')?></th>
		<th width="15%"><?php echo L('name')?></th>
		<th width="15%"><?php echo L('display_position')?></th>
		<th width="45" align="center"><?php echo L('分类')?></th>
		<th width="65%"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($infos)):
	foreach($infos as $v):
?>
<tr>
<td align="center"><?php echo $v['id']?></td>
<td align="center"><?php echo $v['name']?></td>
<td align="center"><?php echo $v['tag']?></td>
<td align="center" width="10%"><?php echo $type_arr[$v['typeid']];?></td>
<td align="center">
	<a class="xbtn btn-primary btn-xs" href="javascript:call(<?php echo $v['id']?>);void(0);"><?php echo L('explain'); ?></a>   
	<a class="xbtn btn-info btn-xs" href="javascript:ssi_update(<?php echo $v['id']?>, '<?php echo $v['name']?>')"><?php echo L('updates')?></a>   
	<a class="xbtn btn-warning btn-xs" href="javascript:edit(<?php echo $v['id']?>, '<?php echo $v['name']?>')"><?php echo L('edit')?></a>   
	<a class="xbtn btn-danger btn-xs" href="?app=ssi&controller=ssi&view=del&id=<?php echo $v['id']?>" onclick="return confirm('<?php echo L('confirm', array('message'=>$v['name']))?>')"><?php echo L('delete')?></a>
</td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
</div>
</div>
<div id="pages" class="text-c"><?php echo $pages;?></div>
<div id="closeParentTime" style="display:none"></div>
<script type="text/javascript">
<!--

function ssi_update(id, name) {
	window.top.art.dialog({id:'update'}).close();
	window.top.art.dialog({title:'<?php echo L('更新')?>《'+name+'》',id:'update',iframe:'?app=ssi&controller=ssi&view=ssi_update&id='+id,width:'450',height:'210'}, function(){window.top.art.dialog({id:'update'}).close()});
}
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?>《'+name+'》',id:'edit',iframe:'?app=ssi&controller=ssi&view=edit&id='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

	function call(id) {
		window.top.art.dialog({id:'call'}).close();
		window.top.art.dialog({title:'<?php echo L('get_code')?>', id:'call', iframe:'?app=ssi&controller=ssi&view=public_call&id='+id, width:'600px', height:'470px'}, function(){window.top.art.dialog({id:'call'}).close();}, function(){window.top.art.dialog({id:'call'}).close();})
	}
//-->
</script>
</body>
</html>
