<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<form name="myform" action="?app=admin&controller=position&view=listorder" method="post">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"  align="left"><?php echo L('listorder');?></th>
             <th width="5%"  align="left">ID</th>
            <th width="15%"><?php echo L('posid_name');?></th>
            <th width="15%"><?php echo L('posid_catid');?></th>
            <th width="15%"><?php echo L('posid_modelid');?></th>
            <th width="20%"><?php echo L('posid_operation');?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td width="10%">
	<input name='listorders[<?php echo $info['posid']?>]' type='text' size='2' value='<?php echo $info['listorder']?>' class="input-text-c">
	</td>
	<td width="5%"  align="left"><?php echo $info['posid']?></td>
	<td  width="15%" align="center"><?php echo $info['name']?></td>
	<td width="15%" align="center"><?php echo $info['catid'] ? $category[$info['catid']]['catname'] : L('posid_all')?></td>
	<td width="15%" align="center"><?php echo $info['modelid'] ? $model[$info['modelid']]['name'] : L('posid_all')?></td>
	<td width="20%" align="center">
	<a class="xbtn btn-info btn-xs" href="?app=admin&controller=position&view=public_item&posid=<?php echo $info['posid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('posid_item_manage')?></a> 
	<a class="xbtn btn-warning btn-xs" href="javascript:edit(<?php echo $info['posid']?>, '<?php echo new_addslashes($info['name'])?>')"><?php echo L('edit')?></a>   
	<?php if($info['siteid']=='0' && $_SESSION['roleid'] != 1) {?>
	<font color="#ccc"><?php echo L('delete')?></font>
	<?php } else {?>
	<a class="xbtn btn-danger btn-xs" href="javascript:confirmurl('?app=admin&controller=position&view=delete&posid=<?php echo $info['posid']?>', '<?php echo L('posid_del_cofirm')?>')"><?php echo L('delete')?></a>	 
	<?php } ?>
	<?php if($info['thumb']!=""){?>
	<a class="xbtn btn-white btn-xs" href="javascript:preview('<?php echo $info['thumb'];?>','<?php echo $info['name'];?>')"><font color="green"><?php echo L('priview')?></font></a>
	<?php }else{?> <font class="xbtn btn-white btn-xs"><?php echo L('no_priview')?><?php } ?></font>
	
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
  
    <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>

 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
<script type="text/javascript">
<!--
	window.top.$('#display_center_id').css('display','none');
	function edit(id, name) {
	window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?app=admin&controller=position&view=edit&posid='+id ,width:'500px',height:'360px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

//预览视频
function preview(thumb, name) {
	window.top.art.dialog({id:'preview'}).close();
	window.top.art.dialog({title:'预览 '+name+' ',id:'preview',iframe:'?app=admin&controller=position&view=preview&thumb='+thumb,width:'530',height:'400'}, '', function(){window.top.art.dialog({id:'preview'}).close()});
}
//-->
</script>
