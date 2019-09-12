<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
	<div class="content-menu ib-a blue line-x">
        <a href="?app=admin&controller=manage_stats&view=viewByTime"><em>多用户统计</em></a>
        <span>|</span>
        <a  href="javascript:;" class="on"><em>单用户统计</em></a>
 	</div>
	<div class="explain-col">
		<form name="searchform" action="" method="get" >
		<input type="hidden" value="admin" name="app">
		<input type="hidden" value="manage_stats" name="controller">
		<input type="hidden" value="viewOneUser" name="view">
		<input type="hidden" value="<?php echo $username ?>" name="username">
		<?php echo $username ?> 从 <?php echo form::date('start_time',$start_time)?>
		到 <?php echo form::date('end_time',$end_time)?>
		<input type="submit" value="查看" class="button" name="dosubmit">
		</form>
	</div>
<div class="table-list">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
            </div>
</div>

    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th align="center">时间</th>
		<th align="center">添加数</th>
		<th align="center">编辑数</th>
		<th align="center">审核</th>
		<th align="center">删除</th>
		<th align="center">推荐</th>
		<th align="center">推送</th>
		<th align="center">排序</th>
		<th align="center">审核评论</th>
		<th align="center">删除评论</th>
		<th align="center">删除附件</th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?> 
<tr>
<td align="center"><?php echo $info['stat_time']?></td>
<td align="center"><?php echo $info['add']?> - <a href="?app=admin&controller=manage_stats&view=detail_add&username=<?php echo $info['username'];?>">查看</a></td>
<td align="center"><?php echo $info['edit']?></td>
<td align="center"><?php echo $info['check']?></td>
<td align="center"><?php echo $info['delete']?></td>
<td align="center"><?php echo $info['position']?></td>
<td align="center"><?php echo $info['push']?></td>
<td align="center"><?php echo $info['listorder']?></td>
<td align="center"><?php echo $info['check_comment']?></td>
<td align="center"><?php echo $info['delete_comment']?></td>
<td align="center"><?php echo $info['delete_attachment']?></td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
 <div id="pages"> <?php echo $pages?></div>

</div>
</div>
</body>
</html>
