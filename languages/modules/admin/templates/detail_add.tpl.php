<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">
<div class="table-list">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='?app=admin&controller=manage_stats&view=viewOneUser&username=<?php echo $username;?>' ><em>管理概况</em></a><span>|</span><a href='?app=admin&controller=manage_stats&view=detail_add&username=<?php echo $username;?>' class="on"><em>添加的信息列表</em></a> 当前用户：<?php echo $username;?></div>
</div>
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th >标题</th>
		<th width="100">所属栏目</th>
		<th >总点击</th>
		<th >今天</th>
		<th >昨日</th>
		<th >本周</th>
		<th >本月</th>
		<th width="120" align="left" >添加时间</th>
		</tr>
        </thead>
        <tbody>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
		$hits_r = $this->hits_db->get_one(array('hitsid'=>$info['hitsid']));
?>
<tr>
<td  align="left"><a href="<?php echo $info['url'];?>" target="_blank"><?php echo $info['title'];?></a></td>
<td  align="left"><?php echo $CATEGORYS[$info['catid']]['catname']?></td>
<td  align="left"><?php echo $hits_r['views'];?></td>
<td  align="left"><?php echo $hits_r['dayviews'];?></td>
<td  align="left"><?php echo $hits_r['yesterdayviews'];?></td>
<td  align="left"><?php echo $hits_r['weekviews'];?></td>
<td  align="left"><?php echo $hits_r['monthviews'];?></td>
<td  align="left"><?php echo date('Y-m-d H:i:s',$info['inputtime'])?></td>

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
