<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div class="table-list">
<div class="explain-col"> 
		提示：点击更新按纽，获取微信公号的分组列表
		</div>
        <div class="bk15"></div>
<fieldset>
	<legend>用户分组</legend>
	<table width="100%" cellspacing="0" class="search-form">
    <thead>
		<tr>
			<th width="10%" align="center">分组名称(成员个数)</th>
            <th width="10%" align="center">操作</th>
		</tr>
	</thead>
    <tbody>
    <?php foreach($grouplists as $k=>$v){?>
		<tr>
		<td width="10%" align="center">
        <?php echo $v['name']."(".$v['count'].")";?>
		</td>
        <td width="10%" align="center">
       <a href="###" style="color:#999;" onclick="editgroup(<?php echo $v['id']?>, '<?php echo $v['name']?>')"
			title="<?php echo L('edit')?>"><font class="xbtn btn-white btn-xs" ><?php echo L('edit')?></font></a>
        </td>
		</tr>
        <?php }?>
    </tbody>
</table>
</fieldset>
<div class="btn"> 
<form action="?app=weixin&controller=usermanage&view=groupupdate" method="post" name="myform" id="myform">
        <input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  更新  ">
</form>
</div>
</div>
<script type="text/javascript">
function editgroup(id, name) {
	window.top.art.dialog({id:'editgroup'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editgroup',iframe:'?app=weixin&controller=usermanage&view=editgroup&id='+id+'&name='+name,width:'400',height:'200'}, function(){var d = window.top.art.dialog({id:'editgroup'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editgroup'}).close()});
}
</script>
</body>
</html>
