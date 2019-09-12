<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="email" name="app">
<input type="hidden" value="email" name="controller">
<input type="hidden" value="lists" name="view">
<input type="hidden" value="2808" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
			<select name="field">
				<option value='ids' <?php if($_GET['field']=='ids') echo 'selected';?> >邮箱</option>
			</select>
			<input name="ids" type="text" value="<?php echo stripslashes($_GET['ids'])?>" style="width:250px;" class="input-text" />
			<input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
<form action="" method="get">
<input type="hidden" name="app" value="email" />
<input type="hidden" name="controller" value="email" />
<input type="hidden" name="view" id="action" value="delete" />
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="50"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
		<th width="50">ID</th>
		<th>邮箱</th>
		<th>发布时间</th>
		<th>操作</th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($data))
	foreach($data as $v){
?>
<tr>
<td width="50" align="center"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
<td align="center"><?php echo $v['id']?></td>
<td align="center"><?php echo $v['ids']?></td>
<td align="center"><?php echo date('Y-m-d H:i', $v['addtime'])?></td>
<td align="center"><a class="xbtn btn-danger btn-xs" href="?app=email&controller=email&view=delete&id=<?php echo $v['id']?>" onclick="return confirm('<?php echo htmlspecialchars(new_addslashes(L('confirm', array('message'=>$v['id']))))?>')">删除</a>	<a class="xbtn btn-info btn-xs" href="javascript:call(<?php echo $v['id']?>);void(0);"><?php echo L('详情')?></a></td>
</tr>
<?php }  ?>
</tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('您确认删除么，该操作无法恢复！')"  /> 
</div>
</from>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
</body>
</html>
<script type="text/javascript">

function call(id) {
	window.top.art.dialog({id:'call'}).close();
	window.top.art.dialog({title:'<?php echo L('邮件详情')?>', id:'call', iframe:'?app=email&controller=email&view=call&id='+id, width:'600px', height:'420px'}, function(){window.top.art.dialog({id:'call'}).close();}, function(){window.top.art.dialog({id:'call'}).close();})
	}

</script>
