<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-lr-10">
<form name="myform" id="myform" action="" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
			<th width="50" align="center">ID</th>
			<th align="center">标题</th>
			<th width="150" align="center">添加时间</th>
			<th align="center">操作</th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($data)){
	foreach($data as $r){
?>   
	<tr>
	<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
	<td align='center' ><?php echo $r['id'];?></td>
	<td align='left' > <a href="?app=shuyangtoday&controller=manages&view=edit&id=<?php echo $r['id']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo $r['name'];?></a></td>
	<td align="center"><?php echo date('Y-m-d H:i:s', $r['addtime'])?></td>
	<td align="center">
	  <a class="xbtn btn-info btn-xs"  href="?app=shuyangtoday&controller=manages&view=edit&id=<?php echo $r['id']?>&menuid=<?php echo $_GET['menuid']?>">修改</a>  <a class="xbtn btn-danger btn-xs" href="?app=shuyangtoday&controller=manages&view=delete&id=<?php echo $r['id']?>" onClick="return confirm('<?php echo L('确认要删除吗？');?>')"><?php echo L('删除')?></a>
	</td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    <div class="btn">
		<label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
		<input type="hidden" value="YVt4Dk" name="safe_edi">
		<input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?app=shuyangtoday&controller=manages&view=delete&dosubmit=1';return confirm_delete()"/>
	</div>  

</div>
 <div id="pages"><?php echo $this->db->pages;?></div>
</form>
</div>
<script type="text/javascript">
window.top.$("#display_center_id").css("display","none");
function confirm_delete(){
	if(confirm('<?php echo L('确认要删除『选中』吗？');?>')) $('#myform').submit();
}
</script>
</body>
</html>
