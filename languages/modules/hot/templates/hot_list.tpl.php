<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="hot" name="app">
<input type="hidden" value="hot" name="controller">
<input type="hidden" value="init" name="view">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
			<select name="field">
				<option value='tag' <?php if($_GET['field']=='tag') echo 'selected';?> >关键字</option>
				<option value='tagid' <?php if($_GET['field']=='tagid') echo 'selected';?>>关键字ID</option>
			</select>
			<input name="keywords" type="text" value="<?php echo stripslashes($_GET['keywords'])?>" style="width:250px;" class="input-text" />
			<input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
<form action="" method="get">
<input type="hidden" name="app" value="hot" />
<input type="hidden" name="controller" value="hot" />
<input type="hidden" name="view" id="action" value="delete" />
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="50"><input type="checkbox" value="" id="check_box" onclick="selectall('tagid[]');"></th>
		<th width="50">排序</th>
		<th width="50">TAGID</th>
		<th>关键字</th>
		<th>使用次数</th>
		<th>最后使用时间</th>
		<th>点击次数</th>
		<th>最近访问时间</th>
		<th>相关操作</th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($data))
	foreach($data as $v){
?>
<tr>
<td width="50" align="center"><input type="checkbox" value="<?php echo $v['tagid']?>" name="tagid[]"></td>
<td><input type="text" name="listorder[]" value="<?php echo $v['listorder']?>" size="5" /></td>
<td align="center"><?php echo $v['tagid']?></td>
<td align="center"><?php echo $v['tag']?></td>
<td align="center"><?php echo $v['usetimes']?></td>
<td align="center"><?php echo date('Y-m-d H:i:s', $v['lastusetime'])?></td>
<td align="center"><?php echo $v['hits']?></td>
<td align="center"><?php echo date('Y-m-d H:i:s', $v['lasthittime'])?></td>
<td align="center"><a class="xbtn btn-info btn-xs" href="?app=hot&controller=hot&view=edit&tagid=<?php echo $v['tagid']?>">修改</a>   <a class="xbtn btn-danger btn-xs" href="?app=hot&controller=hot&view=delete&tagid=<?php echo $v['tagid']?>" onclick="return confirm('<?php echo htmlspecialchars(new_addslashes(L('confirm', array('message'=>$v['tag']))))?>')">删除</a></td>
</tr>
<?php }  ?>
</tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('您确认删除么，该操作无法恢复！')"  /> <input type="submit" class="button" name="dosubmit" onclick="$('#action').val('listorder')" value=" 更新排序 " 
</div>
</from>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
</body>
</html>
