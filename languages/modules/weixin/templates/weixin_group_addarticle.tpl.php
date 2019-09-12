
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
<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=catlist" >群发</a></li>
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=selfromcate" >站内内容</a></li>
             <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=addarticle" >手动添加</a></li>
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=havedset" >已发送</a></li>
            
            
			
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		<a href="?app=weixin&controller=typesmanage&view=addarticle" style=" font-weight:bold; padding:5px 15px 5px 15px; background-color:#eee;margin-right:30px;" >添加图文</a><a href="?app=weixin&controller=typesmanage&view=sent_group_message" >添加文本</a>
		</div>
		</td>
		</tr>
    </tbody>
</table>

<form action="?app=weixin&controller=typesmanage&view=addarticle" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="weixin[title]" id="title" size="50" class="input-text"></td>
	</tr>
    <tr>
		<th width="100">发布者：</th>
		<td><input type="text" name="weixin[author]" id="author" size="30" class="input-text"></td>
	</tr>
     <tr>
		<th width="100">缩略图：</th>
		<td><?php echo form::images('weixin[thumb]', 'thumb', '', 'weixin','',50,'','','',array('0'=>'620','1'=>'320'))?></td>
        
	</tr>
	<tr>
		<th width="80">描述：</th>
		<td>
		<textarea  name="weixin[description]" rows="2" cols="90"  /> </textarea>
		</td>
	</tr>
    <tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="weixin[content]" id="content" style="width:60%;height:300px;" /> </textarea><?php echo form::editor('content','full','','','',1);?>
		</td>
	</tr>
   
	
	
<tr>
		<th></th>
		<td>
        <input type="hidden" name="forward" value="?app=weixin&controller=usermanage&view=addarticle"> 
         <input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> "></td>
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