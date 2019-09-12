<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
</script>

<div class="pad_10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
		</div>
		</td>
		</tr>
    </tbody>
</table>
<form action="?app=weixin&controller=weixin&view=add" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	
	<tr>
		<th width="80"><?php echo L('weixin_menu_add')?>：</th>
		<td>
		<textarea  name="weixin[menu]" rows="30" cols="80"  /><?php echo  isset($jsonmenu) ? $jsonmenu : '0'?> </textarea>
		</td>
	</tr>
	
	
<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?app=weixin&controller=weixin&view=add"> <input
		type="submit" name="dosubmit" id="dosubmit" class="dialog"
		value=" <?php echo L('submit')?> "></td>
	</tr>

</table>
</form>
</div>
</body>
</html> 
