<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
</script>

<div class="col-tab">
<ul class="tabBut cu-li">
      <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=catlist" >分组群发</a></li>
      <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=selfromcate" >栏目中选取</a></li>
       <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=addarticle" >手动添加</a></li>
      <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=havedset" >已发送消息</a></li>
            
            
			
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		<a href="?app=weixin&controller=typesmanage&view=addarticle" >添加图文</a><a href="?app=weixin&controller=typesmanage&view=sent_group_message" style=" font-weight:bold; padding:5px 15px 5px 15px; background-color:#eee;margin-left:30px;">添加文本</a>
		</div>
		</td>
		</tr>
    </tbody>
</table>
<form action="?app=weixin&controller=usermanage&view=sent_group_message&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="80">内容：</th>
		<td>
		<textarea  name="group[content]" rows="15" cols="80"  /> </textarea>
		</td>
	</tr>
                    
</table>
<div class="btn"> 选择分组
<select name="group_id" id="">
		<option value="">分组名称</option>
		<?php
		 
		  foreach($array as $k=>$v){
		 
		?>
		<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
		<?php }?>
		</select>
<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=preview&view=sent_group_message'" value=" 预览 "/><input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  发布  ">
</form>

</div>
</form>
</div>
</div>
</body>
</html> 