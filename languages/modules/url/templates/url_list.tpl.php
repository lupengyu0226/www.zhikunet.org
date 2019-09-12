<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?app=url&controller=admin_url&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('aid[]');"></th>
			<th width="68" align="center">ID</th>
			<th align="center"><?php echo L('title')?></th>
			<th width="68" align="center"><?php echo L('startdate')?></th>
			<th width='68' align="center"><?php echo L('enddate')?></th>
			<th width='68' align="center"><?php echo L('inputer')?></th>
			<th width="50" align="center"><?php echo L('hits')?></th>
			<th width="120" align="center"><?php echo L('inputtime')?></th>
			<th width="119" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $url){
?>   
	<tr>
	<td align="center">
	<input type="checkbox" name="aid[]" value="<?php echo $url['aid']?>">
	</td>
	<td><?php echo $url['aid']?></td>
	<td><?php echo $url['title']?></td>
	<td align="center"><?php echo $url['starttime']?></td>
	<td align="center"><?php echo $url['endtime']?></td>
	<td align="center"><?php echo $url['username']?></td>
	<td align="center"><?php echo $url['hits']?></td>
	<td align="center"><?php echo date('Y-m-d H:i:s', $url['addtime'])?></td>
	<td align="center">
	<?php if ($_GET['s']==1) {?><a href="?app=url&controller=index&view=show&aid=<?php echo $url['aid']?>" title="<?php echo L('preview')?>"  target="_blank"><?php }?><font class="xbtn btn-info btn-xs"><?php echo L('index')?></font><?php if ($_GET['s']==1) {?></a><?php }?>   
	<a class="xbtn btn-warning btn-xs" href="javascript:edit('<?php echo $url['aid']?>', '<?php echo safe_replace($url['title'])?>');void(0);"><?php echo L('edit')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
        <?php if($_GET['s']==1) {?><input name='submit' type='submit' class="button" value='<?php echo L('cancel_all_selected')?>' onClick="document.myform.action='?app=url&controller=admin_url&view=public_approval&passed=0'"><?php } elseif($_GET['s']==2) {?><input name='submit' type='submit' class="button" value='<?php echo L('pass_all_selected')?>' onClick="document.myform.action='?app=url&controller=admin_url&view=public_approval&passed=1'"><?php }?>&nbsp;&nbsp;
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=url&controller=admin_url&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function edit(id, title) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit_url')?>--'+title, id:'edit', iframe:'?app=url&controller=admin_url&view=edit&aid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
