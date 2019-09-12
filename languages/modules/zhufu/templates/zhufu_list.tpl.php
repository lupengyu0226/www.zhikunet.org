<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<form name="myform" action="?app=zhufu&controller=admin_zhufu&view=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('edi_id[]');"></th>
			<th align="center">ID</th>
			<th width="75" align="center">发布人</th>
			<th width="75" align="center">接受人</th>
			<th align="center">祝福内容</th>
			<th width="75" align="center">祝福次数</th>
			<th width="120" align="center">发表时间</th>
			<th width="69" align="center">管理操作</th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $zhufu){
?>   
	<tr>
	<td align="center">
	<input type="checkbox" name="edi_id[]" value="<?php echo $zhufu['edi_id']?>">
	</td>
	<td><?php echo $zhufu['edi_id']?></td>
	<td><?php echo $zhufu['edi_sign']?></td>
	<td><?php echo $zhufu['edi_head']?></td>
	<td><?php echo $zhufu['edi_lr']?></td>
	<td><?php echo $zhufu['edi_cs']?></td>
	<td align="center"><?php echo $zhufu['edi_date']?></td>
	<td align="center">
	<?php if ($_GET['s']==1) {?><a class="xbtn btn-info btn-xs" href="http://www.05273.cn/zhufu/zhufu-<?php echo $zhufu['edi_id']?>.shtml" title="<?php echo L('preview')?>"  target="_blank"> <?php }?><?php echo L('index')?><?php if ($_GET['s']==1) {?></a><?php }?>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn"><label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input name="submit" type="submit" class="button" value="<?php echo L('remove_all_selected')?>" onClick="document.myform.action='?app=zhufu&controller=admin_zhufu&view=delete';return confirm('<?php echo L('affirm_delete')?>')">&nbsp;&nbsp;</div>  </div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
</body>
</html>
<script type="text/javascript">
function edit(id, title) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit_zhufu')?>--'+title, id:'edit', iframe:'?app=zhufu&controller=admin_zhufu&view=edit&edi_id='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
