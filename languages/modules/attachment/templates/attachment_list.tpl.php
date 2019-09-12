<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.sgallery1.2.js"></script>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="attachment" name="app">
<input type="hidden" value="manage" name="controller">
<input type="hidden" value="init" name="view">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"><?php echo L('name')?>  <input type="text" value="<?php echo $filename?>" class="input-text" name="info[filename]">  <?php echo L('uploadtime')?>  <?php echo form::date('info[start_uploadtime]',$start_uploadtime,'1','0','true','1')?><?php echo L('to')?>   <?php echo form::date('info[end_uploadtime]',$end_uploadtime)?>  <?php echo L('filetype')?>  <input type="text" value="<?php echo $fileext?>" class="input-text" name="info[fileext]">  <input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit"> <a href="?app=attachment&controller=manage&view=dir&menuid=<?php echo $_GET['menuid']?>"><?php echo L('dir_schema')?></a>
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
<form name="myform" action="?app=admin&controller=role&view=listorder" method="post" id="myform">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="3%"><?php echo L('delete')?></th>
		<th width="5%">ID</th>
		<th width="8%" ><?php echo L('moudle')?>
        <div class="tab-use">
        	<div style="position:relative">
        	<div class="arrows cu" onmouseover="hoverUse('module-div');" onmouseout="hoverUse();" onmouseover="this.style.display='block'"></div>
                <ul id="module-div" class="tab-web-panel" onmouseover="this.style.display='block'"  onmouseout="hoverUse('module-div');" style="height:150px; width:100px; text-align:left; overflow-y:scroll;">
                    <?php foreach ($modules as $module) {
                    	if(in_array($module['module'], array('pay','digg','search','scan','attachment','block','dbsource','template','release','cnzz','comment','mood'))) continue;
                        echo '<li><a href='.url_par('dosubmit=1&module='.$module['module']).'>'.$module['name'].'</a></li>';
                    }?>
                </ul>
            </div>
        </div>		
		</th>
		<th width="8%" ><?php echo L('catname')?></th>
		<th width="20%"><?php echo L('filename')?>
        <div class="tab-use">
        	<div style="position:relative">
        	<div class="arrows cu" onmouseover="hoverUse('use-div');" onmouseout="hoverUse();" onmouseover="this.style.display='block'"></div>
            <ul id="use-div" class="tab-web-panel" onmouseover="this.style.display='block'"  onmouseout="hoverUse('use-div');">
                <li><a href="<?php echo url_par('dosubmit=1&status=0')?>"><?php echo L('not_used')?></a></li>
                <li><a href="<?php echo url_par('dosubmit=1&status=1')?>"><?php echo L('used')?></a></li>
            </ul>
            </div>
        </div></th>
		<th width="10%" ><?php echo L('filesize')?></th>
		<th width="10%" ><?php echo L('uploadtime')?></th>
		<th width="10%" ><?php echo L('preview')?></th>
		<th width="10%" ><?php echo L('operations_manage')?></th>

		</tr>
        </thead>
        
    <tbody>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
		$thumb = glob(dirname($this->upload_path.$info['filepath']).'/thumb_*'.basename($info['filepath']));
?>
<tr>
<td width="3%" align="center"><input type="checkbox" name="aid[]" value="<?php echo $info['aid']?>" id="att_<?php echo $info['aid']?>" /></td>
<td width="5%"  align="center"><?php echo $info['aid']?></td>
<td width="8%" align="center"><?php echo $modules[$info['module']]['name']?></td>
<td width="8%"  align="center"><?php echo $category[$info['catid']]['catname']?></td>
<td width="20%"><i class="iconfont icon-<?php echo $info['fileext']?>"></i> <?php echo $info['filename']?> <?php echo $thumb ? '<a onclick="showthumb('.$info['aid'].', \''.new_addslashes($info['filename']).'\')"/> <i class="iconfont icon-img" style="color:green"></i></a>':''?> <?php echo $info['status'] ? ' <i class="iconfont icon-wailian"></i>':''?></td>
<td width="10%" align="center"><?php echo $this->attachment->size($info['filesize'])?></td>
<td width="10%"  align="center"><?php echo date('Y-m-d H:i:s',$info['uploadtime'])?></td>
<td width="8%" align="center"><img src="<?php echo $this->upload_url.$info['filepath']?>" height="40" width="40"></td>
<td width="8%" align="center"><a class="xbtn btn-warning btn-xs" href="javascript:;" onclick="att_delete(this,'<?php echo $info['aid']?>')"><?php echo L('delete')?></a></td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
<div class="btn"><a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', true)"><?php echo L('selected_all')?></a>/<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', false)"><?php echo L('cancel')?></a> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onClick="document.myform.action='?app=attachment&controller=manage&view=public_delete_all';return confirm('<?php echo L('del_confirm')?>')"/></div>
 <div id="pages"> <?php echo $pages?></div>
</form>

</div>
</div>
</body>
</html>
<script type="text/javascript">
<!--
window.top.$('#display_center_id').css('display','none');
function preview(id, name,filepath) {
	if(IsImg(filepath)) {
		window.top.art.dialog({title:'<?php echo L('preview')?>',fixed:true, content:'<img src="'+filepath+'" onload="$(this).LoadImage(true, 500, 500,\'<?php echo IMG_PATH?>s_nopic.gif\');"/>'});	
	} else {
		window.top.art.dialog({title:'<?php echo L('preview')?>',fixed:true, content:'<a href="'+filepath+'" target="_blank"><img src="<?php echo IMG_PATH?>admin_img/down.gif"><?php echo L('click_open')?></a>'});
	}
}

function att_delete(obj,aid){
	 window.top.art.dialog({content:'<?php echo L('del_confirm')?>', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?app=attachment&controller=manage&view=delete&aid='+aid+'&safe_edi=<?php echo $_SESSION['safe_edi']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};

function showthumb(id, name) {
	window.top.art.dialog({title:'<?php echo L('att_thumb_manage')?>--'+name, id:'edit', iframe:'?app=attachment&controller=manage&view=pullic_showthumbs&aid='+id ,width:'500px',height:'400px'});
}
function hoverUse(target){
	if($("#"+target).css("display") == "none"){
		$("#"+target).show();
	}else{
		$("#"+target).hide();
	}
}
function member_infomation(userid, modelid, name) {
	window.top.art.dialog({id:'modelinfo'}).close();
	window.top.art.dialog({title:'个人信息',id:'modelinfo',iframe:'?app=member&controller=member&view=memberinfo&userid='+userid+'&modelid='+modelid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}

function IsImg(url){
	  var sTemp;
	  var b=false;
	  var opt="jpg|gif|png|bmp|jpeg";
	  var s=opt.toUpperCase().split("|");
	  for (var i=0;i<s.length ;i++ ){
	    sTemp=url.substr(url.length-s[i].length-1);
	    sTemp=sTemp.toUpperCase();
	    s[i]="."+s[i];
	    if (s[i]==sTemp){
	      b=true;
	      break;
	    }
	  }
	  return b;
}
//-->
</script>