<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>
<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<a href="?app=content&controller=content_null&view=init&safe_edi=<?php echo $safe_edi;?>" <?php if($steps==0 && !isset($_GET['reject'])) echo 'class=on';?>><em>无效内容列表</em></a>
</div>
</form>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
             <th width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
            <th width="552"><?php echo L('title');?></th>
            <th width="93">分类</th>
            <th width="50"><?php echo L('hits');?></th>
            <th width="70"><?php echo L('publish_user');?></th>
            <th width="300"><?php echo L('keywords');?></th>
            <th width="200"><?php echo L('updatetime');?></th>
            </tr>
        </thead>
<tbody>
    <?php
    if(is_array($datas)) {
        foreach ($datas as $r) {
    ?>
        <tr>
        <td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
        <td align='center' ><?php echo $r['id'];?></td>
        <td><?php echo $r['title'];?></td>
        <td align='center'></td>
        <td align='center'></td>
        <td align='center'>
        <?php echo $r['username'];?></td>
		<td align='center'><?php echo $r['keywords'];?></td>
        <td align='center'><?php echo format::date($r['updatetime'],1);?></td>
     <?php }
    }
    ?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
        <input type="hidden" value="<?php echo $safe_edi;?>" name="safe_edi">
        <input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?app=content&controller=content_null&view=delete&dosubmit=1&status=<?php echo $r['status'];?>&steps=<?php echo $steps;?>';return confirm_delete()"/>
        </div>
    </div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
            <th width="40">ID</th>
            <th width="15%">url</th>
            <th width="20%"><?php echo L('title');?></th>
            <th width="15%">来源</th>
            <th width="15%">时间</th>
            <th>内容</th>
            </tr>
        </thead>
<tbody>
    <?php
    if(is_array($caijidatas)) {
        foreach ($caijidatas as $r) {
    ?>
        <tr>
        <td align='center' ><?php echo $r['id'];?></td>
         <td align='center' ><textarea style="width:98%;height:50px;"><?php echo $r['url'];?></textarea></td>
    <?php
    if(is_array(string2array($r['data']))) {
        foreach (string2array($r['data']) as $v) {
    ?>
        <td><textarea style="width:98%;height:50px;"><?php echo new_html_special_chars(print_r($v,true))?></textarea></td>
     <?php }
    }
  }
}
    ?>
</tbody>
     </table>
    <div id="pages"><?php echo $pages;?></div>
</div>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'<?php echo L('view_comment');?>：'+name,id:'view_comment',iframe:'index.php?app=comment&controller=comment_admin&view=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}

setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}
setInterval("refersh_window()", 3000);
//-->
</script>
</body>
</html>
