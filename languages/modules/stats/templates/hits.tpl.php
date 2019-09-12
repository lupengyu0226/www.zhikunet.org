<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">
 <div class="content-menu ib-a blue line-x">
        <a href='javascript:;' class="on"><em>当前栏目：<?php echo $catname;?> ，前100排名</em></a> </div>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
            <th width="40">名次</th>
            <th width="40">ID</th>
			<th>标题</th>
            <th width="40">今日</th>
            <th width="40">昨日</th>
            <th width="40">本周</th>
            <th width="40">本月</th>
            <th width="40">总点击</th>
			<th width="40">weixin</th>
            <th width="70">发布者</th>
            <th width="118">更新时间</th>
			<th width="172">操作</th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(APP_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$n = 1;
		foreach ($datas as $r) {
	?>
        <tr>
		<td align='center' ><?php echo $n;?></td>
		<td align='center' ><?php echo $r['id'];?></td>
		<td>
		<?php
		
			if($r['islink']) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} elseif(strpos($r['url'],'http://')!==false) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} else {
				echo '<a href="'.$release_siteurl.$r['url'].'" target="_blank">';
			}
		?><span<?php echo title_style($r['style'])?>><?php echo $r['title'];?></span></a> <?php if($r['thumb']!='') {echo '<img src="'.IMG_PATH.'icon/small_img.gif" title="'.L('thumb').'">'; } if($r['posids']) {echo '<img src="'.IMG_PATH.'icon/small_elite.gif" title="'.L('elite').'">';} if($r['islink']) {echo ' <img src="'.IMG_PATH.'icon/link.png" title="'.L('islink_url').'">';}?></td>

		<td align='center' ><?php echo $r['dayviews'];?></td>
		<td align='center' ><?php echo $r['yesterdayviews'];?></td>
		<td align='center' ><?php echo $r['weekviews'];?></td>
		<td align='center' ><?php echo $r['monthviews'];?></td>
		<td align='center' ><?php echo $r['views'];?></td>
		<td align='center' ><?php echo $r['weixinview'];?></td>
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?app=member&controller=member&view=memberinfo&username=".urlencode($r['username'])."&safe_edi=".$_SESSION['safe_edi']."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center'><?php echo format::date($r['updatetime'],1);?></td>
		<td align='center'><a class='xbtn btn-info btn-xs' href="javascript:;" onclick="javascript:openwinx('?app=content&controller=content&view=edit&catid=<?php echo $catid;?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a>   <a class='xbtn btn-danger btn-xs' href="javascript:view_comment('<?php echo id_encode('content_'.$catid,$r['id'],$this->siteid);?>','<?php echo safe_replace($r['title']);?>')"><?php echo L('comment');?></a></td>
	</tr>
     <?php 
		$n++;	
		}
	}
	?>
</tbody>
     </table>
   
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--

function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'查看评论：'+name,id:'view_comment',iframe:'index.php?app=comment&controller=comment_admin&view=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}

//-->
</script>
</body>
</html>