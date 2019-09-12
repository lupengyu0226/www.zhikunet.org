<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?app=content&controller=content&view=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>&safe_edi=<?php echo $_SESSION['safe_edi'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
//-->
</SCRIPT>
<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<a class="add fb" href="javascript:;" onclick=javascript:openwinx('?app=content&controller=content&view=add&menuid=&catid=<?php echo $catid;?>&safe_edi=<?php echo $_SESSION['safe_edi'];?>','')><em><i class="iconfont icon-tianjia icon-sm"></i> <?php echo L('add_content');?></em></a>　
<a href="?app=content&controller=content&view=init&catid=<?php echo $catid;?>&safe_edi=<?php echo $safe_edi;?>" <?php if($steps==0 && !isset($_GET['reject'])) echo 'class=on';?>><em><?php echo L('check_passed');?></em></a><span>|</span>
<?php echo $workflow_menu;?> <a href="javascript:;" onclick="javascript:$('#searchid').css('display','');"><em><?php echo L('search');?></em></a> 
<?php if($category['ishtml']) {?>
<span>|</span><a href="?app=content&controller=create_html&view=category&pagesize=30&dosubmit=1&modelid=0&catids[0]=<?php echo $catid;?>&safe_edi=<?php echo $safe_edi;?>&referer=<?php echo urlencode($_SERVER['QUERY_STRING']);?>"><em><?php echo L('update_htmls',array('catname'=>$category['catname']));?></em></a>
<?php }?>
</div>
<div id="searchid" style="display:<?php if(!isset($_GET['search'])) echo 'none';?>">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="app">
<input type="hidden" value="content" name="controller">
<input type="hidden" value="init" name="view">
<input type="hidden" value="<?php echo $catid;?>" name="catid">
<input type="hidden" value="<?php echo $steps;?>" name="steps">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $safe_edi;?>" name="safe_edi">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 
				<?php echo L('addtime');?>：
				<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?>
				
				<select name="posids"><option value='' <?php if($_GET['posids']=='') echo 'selected';?>><?php echo L('all');?></option>
				<option value="1" <?php if($_GET['posids']==1) echo 'selected';?>><?php echo L('elite');?></option>
				<option value="2" <?php if($_GET['posids']==2) echo 'selected';?>><?php echo L('no_elite');?></option>
				</select>				
				<select name="searchtype">
					<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>><?php echo L('title');?></option>
					<option value='1' <?php if($_GET['searchtype']==1) echo 'selected';?>><?php echo L('intro');?></option>
					<option value='2' <?php if($_GET['searchtype']==2) echo 'selected';?>><?php echo L('username');?></option>
					<option value='3' <?php if($_GET['searchtype']==3) echo 'selected';?>>ID</option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="1%"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="2%"><?php echo L('listorder');?></th>
            <th width="3%">ID</th>
            <th width="25%"><?php echo L('title');?></th>
            <th width="5%"><?php echo L('hits');?></th>
            <th width="4%"><?php echo L('微信分享');?></th>
            <th width="6%"><?php echo L('publish_user');?></th>
            <th width="8%"><?php echo L('updatetime');?></th>
            <th width="17%"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = shy_base::load_model('hits_model');
		
		foreach ($datas as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$r['id']));
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
        <td align='center'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		<td align='center' ><?php echo $r['id'];?></td>
		<td><a href="javascript:;" onclick="javascript:openwinx('?app=content&controller=content&view=edit&catid=<?php echo $catid;?>&id=<?php echo $r['id']?>','')"><?php echo $r['title'];?></a><?php if($r['thumb']!='') {echo ' <i class="iconfont icon-img" style="color:green"></i>'; } if($r['posids']) {echo ' <i class="iconfont icon-lliconrecommend" style="color:red"></i>';} if($r['islink']) {echo ' <i class="iconfont icon-wailian"></i>';}?></td>
		<td align='center' title="<?php echo L('today_hits');?>：<?php echo $hits_r['dayviews'];?>&#10;<?php echo L('yestoday_hits');?>：<?php echo $hits_r['yesterdayviews'];?>&#10;<?php echo L('week_hits');?>：<?php echo $hits_r['weekviews'];?>&#10;<?php echo L('month_hits');?>：<?php echo $hits_r['monthviews'];?>"><?php echo $hits_r['views'];?></td>
		<td align='center'><?php echo $hits_r['weixinview'];?></td>
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
		<td align='center'>
		        <a class="xbtn btn-primary btn-xs" href="javascript:;" onclick="javascript:openwinx('?app=content&controller=content&view=edit&catid=<?php echo $r['catid'];?>&id=<?php echo $r['id']?>','')">修改</a>
		            <?php
				if($status==99) {
					if($r['islink']) {
						echo '<a class="xbtn btn-info btn-xs" href="'.$r['url'].'" target="_blank">';
					} elseif(preg_match('/^(http(s)?:)?\/\//', $r['url'])) {
						echo '<a class="xbtn btn-info btn-xs" href="'.$r['url'].'" target="_blank">';
					} else {
						echo '<a class="xbtn btn-info btn-xs" href="'.$release_siteurl.$r['url'].'" target="_blank">';
					}
				} else {
					echo '<a class="xbtn btn-info btn-xs" href="javascript:;" onclick=\'window.open("?app=content&controller=content&view=public_preview&steps='.$steps.'&catid='.$catid.'&id='.$r['id'].'","manage")\'>';
				}?>访问</a>  <a class="xbtn btn-danger btn-xs" href="javascript:view_comment('<?php echo id_encode('content_'.$r['catid'],$r['id'],$this->siteid);?>','<?php echo safe_replace($r['title']);?>')"><?php echo L('comment');?></a> <a class="xbtn btn-warning btn-xs" href="?app=content&controller=content&view=pushyuanchuang&safe_edi=<?php echo $_SESSION['safe_edi'];?>&bdurls=https://wap.05273.cn/mip-<?php echo $r['catid'];?>-<?php echo $r['id'];?>-1.html">原创推送</a></td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
     <style type="text/css">
     #pages { padding:14px 0 10px;font-family:宋体; text-align:right;margin-top: -45px;}
     </style>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $safe_edi;?>" name="safe_edi">
    	<input type="button" class="button" value="<?php echo L('listorder');?>" onclick="myform.action='?app=content&controller=content&view=listorder&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php if($category['content_ishtml']) {?>
		<input type="button" class="button" value="<?php echo L('createhtml');?>" onclick="myform.action='?app=content&controller=create_html&view=batch_show&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }
		if($status!=99) {?>
		<input type="button" class="button" value="<?php echo L('passed_checked');?>" onclick="myform.action='?app=content&controller=content&view=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }?>
		<input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?app=content&controller=content&view=delete&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';return confirm_delete()"/>
		<?php if(!isset($_GET['reject'])) { ?>
		<input type="button" class="button" value="<?php echo L('push');?>" onclick="push();"/>
		<?php if($workflow_menu) { ?><input type="button" class="button" value="<?php echo L('reject');?>" onclick="reject_check()"/>
		<div id='reject_content' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:1px;display:none;'>
		<table cellpadding='0' cellspacing='1' border='0'><tr><tr><td colspan='2'><textarea name='reject_c' id='reject_c' style='width:300px;height:46px;'  onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;"><?php echo L('reject_msg');?></textarea></td><td><input type='button' value=' <?php echo L('submit');?> ' class="button" onclick="reject_check(1)"></td></tr>
		</table>
		</div>
		<?php }}?>
		<input type="button" class="button" value="<?php echo L('remove');?>" onclick="myform.action='?app=content&controller=content&view=remove&catid=<?php echo $catid;?>';myform.submit();"/>
		 <div id="pages"><?php echo $edi_pages;?></div>
	</div>
</div>
</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
function push() {
	var str = 0;
	var id = tag = '';
	$("input[name='ids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		alert('<?php echo L('you_do_not_check');?>');
		return false;
	}
	window.top.art.dialog({id:'push'}).close();
	window.top.art.dialog({title:'<?php echo L('push');?>：',id:'push',iframe:'?app=content&controller=push&action=position_list&catid=<?php echo $catid?>&modelid=<?php echo $modelid?>&id='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'push'}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'push'}).close()});
}
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'<?php echo L('view_comment');?>：'+name,id:'view_comment',iframe:'index.php?app=comment&controller=comment_admin&view=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function reject_check(type) {
	if(type==1) {
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') {
				str = 1;
			}
		});
		if(str==0) {
			alert('<?php echo L('you_do_not_check');?>');
			return false;
		}
		document.getElementById('myform').action='?app=content&controller=content&view=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&reject=1';
		document.getElementById('myform').submit();
	} else {
		$('#reject_content').css('display','');
		return false;
	}	
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