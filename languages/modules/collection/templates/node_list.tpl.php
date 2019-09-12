<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		<?php echo L('所有分类')?>: &nbsp;&nbsp; <a href="?app=collection&controller=node&view=manage&typeid=0"><?php echo L('默认采集')?></a> &nbsp;
		<?php
	if(is_array($type_arr)){
	foreach($type_arr as $typeid => $type){
		?><a href="?app=collection&controller=node&view=manage&typeid=<?php echo $typeid;?>"><?php echo $type;?></a>&nbsp;
		<?php }}?>
		</div>
		</td>
		</tr>
    </tbody>
</table>
<form name="myform" action="?app=collection&controller=node&view=del" method="post" onsubmit="return confirm('<?php echo L('sure_delete')?>')">
<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('nodeid[]');"></th>
			<th align="left">ID</th>
			<th align="left"><?php echo L('nodename')?></th>
			<th align="left"><?php echo L('lastdate')?></th>
			<th align="left"><?php echo L('content').L('operation')?></th>
			<th width="45" align="center"><?php echo L('分类')?></th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($nodelist as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['nodeid']?>" name="nodeid[]"></td>
		<td align="left"><?php echo $v['nodeid']?></td>
		<td align="left"><?php echo $v['name']?></td>
		<td align="left"><?php echo format::date($v['lastdate'], 1)?></td>
		<td align="left"><a class="xbtn btn-white btn-xs" href="?app=collection&controller=node&view=col_url_list&nodeid=<?php echo $v['nodeid']?>"><?php echo L('collection_web_site')?></a> 
		<a class="xbtn btn-white btn-xs" href="?app=collection&controller=node&view=col_content&nodeid=<?php echo $v['nodeid']?>"><?php echo L('collection_content')?></a>
		 <a class="xbtn btn-danger btn-xs" href="?app=collection&controller=node&view=publist&nodeid=<?php echo $v['nodeid']?>&status=2"><?php echo L('public_content')?></a>
         <a class="xbtn btn-white btn-xs" href="?app=collection&controller=node&view=publist_list&nodeid=<?php echo $v['nodeid']?>"><?php echo L('publish_the_list')?></a>   
		</td>
		<td align="center" width="10%"><?php if($v['typeid']==0) {echo L('默认采集');}else{echo $type_arr[$v['typeid']];}?></td>
		<td align="left">
		<a class="xbtn btn-danger btn-xs" href="javascript:void(0)" onclick="test_spider(<?php echo $v['nodeid']?>)"><?php echo L('test')?></a>
		
		<a class="xbtn btn-inverse btn-xs" href="?app=collection&controller=node&view=edit&nodeid=<?php echo $v['nodeid']?>&menuid=957"><?php echo L('edit')?></a>
		 <a class="xbtn btn-white btn-xs" href="javascript:void(0)"  onclick="copy_spider(<?php echo $v['nodeid']?>)"><?php echo L('copy')?></a>
		 <a class="xbtn btn-info btn-xs" href="?app=collection&controller=node&view=export&nodeid=<?php echo $v['nodeid']?>"><?php echo L('export')?></a>
		
		 </td>
    </tr>
<?php
	}

?>
</tbody>
</table>

<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>"/>
 <input type="button" class="button" value="<?php echo L('import_collection_points')?>" onclick="import_spider()" />
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function test_spider(id) {
	window.top.art.dialog({id:'test'}).close();
	window.top.art.dialog({title:'<?php echo L('data_acquisition_testdat')?>',id:'test',iframe:'?app=collection&controller=node&view=public_test&nodeid='+id,width:'700',height:'500'}, '', function(){window.top.art.dialog({id:'test'}).close()});
}

function copy_spider(id) {
	window.top.art.dialog({id:'test'}).close();
	window.top.art.dialog({title:'<?php echo L('copy_node')?>',id:'test',iframe:'?app=collection&controller=node&view=copy&nodeid='+id,width:'420',height:'120'}, function(){var d = window.top.art.dialog({id:'test'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'test'}).close()});
}

function import_spider() {
	window.top.art.dialog({id:'test'}).close();
	window.top.art.dialog({title:'<?php echo L('import_collection_points')?>',id:'test',iframe:'?app=collection&controller=node&view=node_import',width:'420',height:'200'}, function(){var d = window.top.art.dialog({id:'test'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'test'}).close()});
}

window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>
