<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%"  align="left">SITEID</th>
            <th width="10%"><?php echo L('mobile_logo')?></th>
            <th width="10%"><?php echo L('mobile_sitename')?></th>
            <th width="20%"><?php echo L('status')?></th>
            <th width="15%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td width="10%"><?php echo $info['siteid']?></td>
	<td width="10%"><?php if($info['logo']): ?><img src="<?php echo $info['logo']; ?>" width="200" height="60" /><?php endif; ?></td>
	<td width="10%" align="center"><a class="xbtn btn-white btn-xs" href="<?php echo APP_PATH?>index.php?app=mobile&siteid=<?php echo $info['siteid']?>" target="_blank"><?php echo $info['sitename']?></a></td>
	<td width="20%" align="center"><a class="xbtn btn-white btn-xs" href="?app=mobile&controller=mobile_admin&view=public_status&siteid=<?php echo $info['siteid']?>&status=<?php echo $info['status']==0 ? 1 : 0?>"><?php echo $info['status']==0 ? L('mobile_close') : L('mobile_open')?></a></td>
	<td width="15%" align="center">
	<a class="xbtn btn-info btn-xs" href="javascript:edit(<?php echo $info['siteid']?>, '<?php echo new_addslashes($info['sitename'])?>')"><?php echo L('edit')?></a>   <a class="xbtn btn-inverse btn-xs" href="?app=mobile&controller=category&view=init&siteid=<?php echo $info['siteid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('mobile_type_manage')?></a>  
	<a class="xbtn btn-danger btn-xs" href="javascript:confirmurl('?app=mobile&controller=mobile_admin&view=delete&siteid=<?php echo $info['siteid']?>', '<?php echo L('mobile_del_cofirm')?>')"><?php echo L('delete')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
 </div>

 <div id="pages"> <?php echo $pages?></div>
</div>
<div class="col-2 col-auto">
	<h6><?php echo L('系统信息')?></h6>
	<div class="content">
	<?php echo L('系统版本：')?>飞天系统 <?php echo SHY_VERSION?>  Release <?php echo SHY_RELEASE?>  <?php echo L('授权类型：')?><span id="phpcms_license"></span> <?php echo L('序列号：')?><span id="phpcms_sn"></span> <br />
	</div>
</div>
</div>
</body>
<a href="javascript:edit(<?php echo $v['siteid']?>, '<?php echo $v['name']?>')">
</html>
<script type="text/javascript">
<!--
	function edit(siteid, name) {
	window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?app=mobile&controller=mobile_admin&view=edit&siteid='+siteid ,width:'400px',height:'380px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>