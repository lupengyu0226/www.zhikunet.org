
<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>


<div class="col-tab">

<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：手动添加，群分图文消息
		</div>
		</td>
		</tr>
    </tbody>
</table>

<form action="?app=weixin&controller=typesmanage&view=edit_groupnews&id=<?php echo $id?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="weixin[title]" id="title" size="50" class="input-text" value="<?php echo $info['title']?>"></td>
	</tr>
    <tr>
		<th width="100">发布者：</th>
		<td><input type="text" name="weixin[author]" id="author" size="30" class="input-text" value="<?php echo $info['author']?>"></td>
	</tr>
     <tr>
		<th width="100">缩略图：</th>
		<td><?php echo form::images('weixin[thumb]', 'thumb', $info['thumb'], 'weixin','',50,'','','',array('0'=>'620','1'=>'320'))?></td>
        
	</tr>
	<tr>
		<th width="80">描述：</th>
		<td>
		<textarea  name="weixin[description]" rows="2" cols="90"  /> <?php echo $info['description']?></textarea>
		</td>
	</tr>
    <tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="weixin[content]" id="content" style="width:60%;height:300px;" /><?php echo $info['content'] ?></textarea><?php echo form::editor('content','full','','','',1);?>
		</td>
	</tr>
   
	
	
<tr>
		<th></th>
		<td>
        
         <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> "></td>
	</tr>

</table>
</form>



</div>
</div>
</div>
</div>


</div>
</body>
<script type="text/javascript">
function SwapTab(name,cls_show,cls_hide,cnt,cur){
    for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}

</script>
</html>