<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<div class="table-list">
<form action="" method="get">
<input type="hidden" name="app" value="hot" />
<input type="hidden" name="controller" value="hot" />
<input type="hidden" name="view" id="action" value="delete" />
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="100">关键词</th>
		<th>关键字</th>
		<th>使用次数</th>
		<th>内容ID</th>
		<th>栏目</th>
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
<td align="center"><?php echo $v['tag']?></td>
<td align="center"><?php echo $v['url']?></td>
<td align="center"><?php echo $v['title']?></td>
<td align="center"><?php echo $v['contentid']?></td>
<td align="center"><?php echo $v['catid']?></td>
<td align="center"><?php echo date('Y-m-d H:i:s', $v['updatetime'])?></td>
<td align="center"><a href="?app=hot&controller=hot&view=kacha&catid=<?php echo $v['catid']?>&contentid=<?php echo $v['contentid']?>" onclick="return confirm('<?php echo htmlspecialchars(new_addslashes(L('confirm', array('message'=>$v['title']))))?>')">删除</a></td>
</tr>
<?php }  ?>
</tbody>
</table>

</from>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
</body>
</html>
