<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#unit").formValidator({onshow:"<?php echo "输入变动的资金"?>",onfocus:"<?php echo "变动的资金不能为空"?>"}).inputValidator({min:1,max:999,onerror:"<?php echo "变动的资金不能为空"?>"}).regexValidator({regexp:"^(([1-9]{1}\\d*)|([0]{1}))(\\.(\\d){1,2})?$",onerror:"<?php echo L('must_be_price')?>"});
	$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('username').L('empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('username').L('empty')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"app=pay&controller=payment&view=public_checkname_ajax",
		datatype : "html",
		async:'false',
		success : function(data){	
            if(data!= 'FALSE')
			{
            	$("#balance").html(data);
                return true;
			}
            else
			{
            	$("#balance").html('');
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('user_not_exist')?>",
		onwait : "<?php echo L('checking')?>"
	});
	$("#usernote").formValidator({onshow:"<?php echo L('input').L('reason_of_modify')?>",onfocus:"<?php echo L('usernote').L('empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('usernote').L('empty')?>"});
})
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?app=pay&controller=payment&view=<?php echo $_GET['a']?>" method="post" id="myform">
<table width="100%" class="table_form">
<tr>
<td  width="80"><?php echo L('username')?></td> 
<td><input type="text" name="username" size="15" value="<?php echo $username?>" id="username"><span id="balance"><span></td>
</tr>
<tr>
<td  width="80"><?php echo L('recharge_quota')?></td> 
<td><input name="pay_unit" value="1" type="radio" checked> <?php echo L('increase')?>  <input name="pay_unit" value="0" type="radio"> <?php echo L('reduce')?> <input type="text" name="unit" size="10" value="<?php echo $unit?>" id="unit"></td>
</tr>
<tr>
<td  width="80"><?php echo L('trading').L('usernote')?></td> 
<td><textarea name="usernote" id="usernote" rows="5" cols="50"></textarea></td>
</tr>
</table>
<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
</form>
</div>
</body>
</html>
<script type="text/javascript">
function category_load(obj)
{
	var modelid = $(obj).attr('value');
	$.get('?app=admin&controller=position&view=public_category_load&modelid='+modelid,function(data){
			$('#load_catid').html(data);
		  });
}
</script>


