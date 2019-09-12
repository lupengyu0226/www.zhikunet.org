<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}}); 

	$("#license_domain").formValidator({onshow:"<?php echo L("input").L('link_name')?>",onfocus:"<?php echo L("input").L('link_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('link_name')?>"}).ajaxValidator({type : "get",url : "",data :"app=link&controller=link&view=public_name&linkid=<?php echo $linkid;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('link_name').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed(); 

	$("#license_conten").formValidator({onshow:"<?php echo L("input").L('url')?>",onfocus:"<?php echo L("input").L('url')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('url')?>"}).regexValidator({regexp:"^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&]*([^<>])*$",onerror:"<?php echo L('link_onerror')?>"})
	
	})
//-->
</script>
<div class="pad-10">
<form method="post" action="?app=license&controller=admin_license&view=edit&aid=<?php echo $_GET['aid']?>" name="myform" id="myform">
<table class="table_form" width="100%">
<tbody>
	<tr>
		<th width="80"><?php echo L('license_domain')?>：</th>
		<td><input name="license[domain]" id="domain" value="<?php echo htmlspecialchars($an_info['domain'])?>" class="input-text" type="text" size="50" ></td>
	</tr>
	<tr>
		<th width="80"><?php echo L('license_content')?>：</th>
		<td >
		<input name="license[content]" id="content" value="<?php echo $an_info['content']?>" type="text" size="50" >
		</td>
	</tr>
	<tr>
		<th width="80"><?php echo L('webname')?>：</th>
		<td >
		<input name="license[webname]" id="webname" value="<?php echo $an_info['webname']?>" type="text" size="50" >
		</td>
	</tr>
	<tr>
		<th width="20%"><?php echo L('type')?>：</th>
		<td><select name="license[typeid]" id="">
		<?php
		  $i=0;
		  foreach($types as $type_key=>$type){
		  $i++;
		?>
		<option value="<?php echo $type['typeid'];?>" <?php if($type['typeid']==$typeid){echo "selected";}?>><?php echo $type['name'];?></option>
		<?php }?>
			 
		</select></td>
	</tr>
	<tr>
		<th><?php echo L('startdate')?>：</th>
		<td><?php echo form::date('license[starttime]', $an_info['starttime'], 1)?></td>
	</tr>
	<tr>
		<th><?php echo L('enddate')?>：</th>
		<td><?php $an_info['endtime'] = $an_info['endtime']=='0000-00-00' ? '' : $an_info['endtime']; echo form::date('license[endtime]', $an_info['endtime'], 1);?></td>
	</tr>
	<tr>
		<th><?php echo L('shouquanstart')?>：</th>
		<td><?php echo form::date('license[shouquanstart]', $an_info['shouquanstart'], 1)?></td>
	</tr>
	<tr>
		<th><?php echo L('shouquanend')?>：</th>
		<td><?php $an_info['shouquanend'] = $an_info['shouquanend']=='0000-00-00' ? '' : $an_info['shouquanend']; echo form::date('license[shouquanend]', $an_info['shouquanend'], 1);?></td>
	</tr>
	<tr>
		<th width="80"><?php echo L('icd')?>：</th>
		<td >
		<input name="license[icd]" id="icd" value="<?php echo $an_info['icd']?>" type="text" disabled="disabled" size="50" >
		</td>
	</tr>
	<tr>
		<th><?php echo L('license_status')?></th>
		<td><input name="license[passed]" type="radio" value="1" <?php if($an_info['passed']==1) {?>checked<?php }?>></input>&nbsp;<?php echo L('pass')?>&nbsp;&nbsp;<input name="license[passed]" type="radio" value="0" <?php if($an_info['passed']==0) {?>checked<?php }?>>&nbsp;<?php echo L('unpass')?></td>
	</tr>
    </tbody>
</table>
<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="dialog">&nbsp;<input type="reset" class="dialog" value=" <?php echo L('clear')?> ">
</form>
</div>
</body>
</html>
<script type="text/javascript">
function load_file_list(id) {
	$.getJSON('?app=admin&controller=category&view=public_tpl_file_list&style='+id+'&module=announce&templates=show&name=announce&safe_edi='+safe_edi, function(data){$('#show_template').html(data.show_template);});
}

$(document).ready(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$('#title').formValidator({onshow:"<?php echo L('input_announce_title')?>",onfocus:"<?php echo L('title_min_3_chars')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('title_cannot_empty')?>"}).ajaxValidator({type:"get",url:"",data:"app=announce&controller=admin_announce&view=public_check_title&aid=<?php echo $_GET['aid']?>",datatype:"html",cached:false,async:'true',success : function(data) {
        if( data == "1" )
		{
            return true;
		}
        else
		{
            return false;
		}
	},
	error: function(){alert("<?php echo L('server_no_data')?>");},
	onerror : "<?php echo L('announce_exist')?>",
	onwait : "<?php echo L('checking')?>"
	}).defaultPassed();
	$('#starttime').formValidator({onshow:"<?php echo L('select_stardate')?>",onfocus:"<?php echo L('select_stardate')?>",oncorrect:"<?php echo L('right_all')?>"}).defaultPassed();
	$('#endtime').formValidator({onshow:"<?php echo L('select_downdate')?>",onfocus:"<?php echo L('select_downdate')?>",oncorrect:"<?php echo L('right_all')?>"}).defaultPassed();
	$("#content").formValidator({autotip:true,onshow:"",onfocus:"<?php echo L('announcements_cannot_be_empty')?>"}).functionValidator({
	    fun:function(val,elem){
	    //获取编辑器中的内容
		var oEditor = CKEDITOR.instances.content;
		var data = oEditor.getData();
        if(data==''){
		    return "<?php echo L('announcements_cannot_be_empty')?>"
	    } else {
			return true;
		}
	}
	}).defaultPassed();
	$('#style').formValidator({onshow:"<?php echo L('select_style')?>",onfocus:"<?php echo L('select_style')?>",oncorrect:"<?php echo L('right_all')?>"}).inputValidator({min:1,onerror:"<?php echo L('select_style')?>"}).defaultPassed();
});
</script>
