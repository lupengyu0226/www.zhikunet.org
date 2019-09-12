<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1; 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';?>
    <?php echo admin::submenu($_GET['menuid'],$big_menu); ?><span>|</span><a href="javascript:window.top.art.dialog({id:'setting',iframe:'?app=formguide&controller=formguide&view=setting', title:'<?php echo L('module_setting')?>', width:'540', height:'350'}, function(){var d = window.top.art.dialog({id:'setting'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'setting'}).close()});void(0);"><em><?php echo L('module_setting')?></em></a>
    </div>
</div>
<div class="pad-lr-10">
<form name="myform" action="?app=formguide&controller=formguide&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('formid[]');"></th>
            <th align="center">ID</th>
			<th align="center"><?php echo L('name_items')?></th>
			<th width='100' align="center"><?php echo L('tablename')?></th>
			<th width='150' align="center"><?php echo L('introduction')?></th>
			<th width="140" align="center"><?php echo L('create_time')?></th>
			<th width="160" align="center"><?php echo L('call')?></th>
			<th width="520" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $form){
?>   
	<tr>
	<td align="center">
	<input type="checkbox" name="formid[]" value="<?php echo $form['modelid']?>">
	</td>
	<td align="center"><?php echo $form['modelid']?></td>
	<td><?php echo $form['name']?> [<a href="<?php echo APP_PATH?>index.php?app=formguide&controller=index&view=show&formid=<?php echo $form['modelid']?>&siteid=<?php echo $form['siteid']?>" target="_blank"><?php echo L('visit_front')?></a>] <?php if ($form['items']) {?>(<font color="red"><?php echo $form['items']?></font>)<?php }?></td>
	<td align="center"><?php echo $form['tablename']?></td>
	<td align="center"><?php echo $form['description']?></td>
	<td align="center"><?php echo date('Y-m-d H:i:s', $form['addtime'])?></td>
	<td align="center"><input type="text" value="<script language='javascript' src='{APP_PATH}index.php?app=formguide&controller=index&view=show&formid=<?php echo $form['modelid']?>&action=js&siteid=<?php echo $form['siteid']?>'></script>"></td>
	<td width="520" align="center">
		<a class="xbtn btn-primary btn-xs" href="?app=formguide&controller=formguide_info&view=init&formid=<?php echo $form['modelid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('info_list')?></a>  
		<a class="xbtn btn-primary btn-xs" href="?app=formguide&controller=formguide_field&view=add&formid=<?php echo $form['modelid']?>"><?php echo L('field_add')?></a>  
		<a class="xbtn btn-warning btn-xs" href="?app=formguide&controller=formguide_field&view=init&formid=<?php echo $form['modelid']?>"><?php echo L('field_manage')?></a> 
		<a class="xbtn btn-info btn-xs" href="?app=formguide&controller=formguide&view=public_preview&formid=<?php echo $form['modelid']?>"><?php echo L('preview')?></a>  
		<a class="xbtn btn-inverse btn-xs" href="javascript:edit('<?php echo $form['modelid']?>', '<?php echo safe_replace($form['name'])?>');void(0);"><?php echo L('modify')?></a> 
		<a class="xbtn btn-white btn-xs" href="?app=formguide&controller=formguide&view=disabled&formid=<?php echo $form['modelid']?>&val=<?php echo $form['disabled'] ? 0 : 1;?>"><?php if ($form['disabled']==0) { echo L('field_disabled'); } else { echo L('field_enabled'); }?></a>  
		<a class="xbtn btn-danger btn-xs"  href="?app=formguide&controller=formguide&view=delete&formid=<?php echo $form['modelid']?>" onClick="return confirm('<?php echo L('confirm', array('message' => addslashes(new_html_special_chars($form['name']))))?>')"><?php echo L('del')?></a> 
		<a class="xbtn btn-info btn-xs"  href="javascript:stat('<?php echo $form['modelid']?>', '<?php echo safe_replace($form['name'])?>');void(0);"><?php echo L('stat')?></a></td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=formguide&controller=formguide&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function edit(id, title) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit_formguide')?>--'+title, id:'edit', iframe:'?app=formguide&controller=formguide&view=edit&formid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function stat(id, title) {
	window.top.art.dialog({id:'stat'}).close();
	window.top.art.dialog({title:'<?php echo L('stat_formguide')?>--'+title, id:'stat', iframe:'?app=formguide&controller=formguide&view=stat&formid='+id ,width:'700px',height:'500px'}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
