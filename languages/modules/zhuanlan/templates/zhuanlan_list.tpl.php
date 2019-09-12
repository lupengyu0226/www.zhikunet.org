<?php 
defined('IN_ADMIN') or exit('The resource access forbidden.');
$show_dialog = 1; 
include $this->admin_tpl('header', 'admin');
?>
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="zhuanlan" name="app">
<input type="hidden" value="zhuanlan" name="controller">
<input type="hidden" value="search" name="view">
<input type="hidden" value="2829" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">	
				搜索沭阳号：
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('用户名')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('域名')?></option>
					<option value='3' <?php if(isset($_GET['type']) && $_GET['type']==3){?>selected<?php }?>><?php echo L('专栏名')?></option>
					<option value='4' <?php if(isset($_GET['type']) && $_GET['type']==4){?>selected<?php }?>><?php echo L('ID')?></option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="10%" align="center">ID</th>
            <th width="10%" align="center"><?php echo L('zhuanlan_name')?></th>
			<th width="10%" align="center"><?php echo L('domain')?></th>
			<th width='10%' align="center"><?php echo L('username')?></th>
			<th width="10%" align="center"><?php echo L('createtime')?></th>
			<th width="10%" align="center">统计</th>
			<th width="10%" align="center">审核</th>
			<th width="12%" align="center"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if (is_array($list)){
	foreach ($list as $d=>$r){
?>   
	<tr>
	<td align="center"><?php echo $r['id']?></td>
	<td align="center"><?php echo $r['name']?></td>
	<td align="center"><a href="http://<?php echo trim($r['domain'])?>.shuyanghao.com/" target="_blank"><?php echo trim($r['domain'])?></a></td>
	<td align="center"><?php echo trim($r['username'])?></td>
	<td align="center"><?php echo date('Y-m-d H:i:s',$r['creat_at'])?></td>
	<td align="center"><?php echo $r['total']?></td>
	<td align="center"><?php if ($r['status']==0) {echo "<p class='xbtn btn-primary btn-xs'>未审核</p>";} elseif ($r['status']==1) {echo "<p class='xbtn btn-info btn-xs'>通过</p>";} elseif ($r['status']==2) {echo "<p class='xbtn btn-danger btn-xs'>拒绝</p>";}?></td>
	<td align="center">
	  <a href="javascript:void(0);" class="xbtn btn-xs btn-warning" onclick="edit(<?php echo $r['id']?>, '<?php echo new_addslashes($r['name'])?>')"><i class="iconfont icon-xiugai icon-sm" "=""></i> <?php echo L('edit')?></a> <a class="xbtn btn-danger btn-xs" href='?app=zhuanlan&controller=zhuanlan&view=delete&id=<?php echo $r['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($r['name']))))?>')"><i class="iconfont icon-shanchu icon-sm"></i> <?php echo L('delete')?></a> 
	</td>
	</tr>
<?php 
		}
	}

?>
</tbody>
    </table>
    </div>
 <div id="pages"><?php echo $pages?></div>
</div>

<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?app=zhuanlan&controller=zhuanlan&view=edit&id='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
</script>
</body>
</html>
