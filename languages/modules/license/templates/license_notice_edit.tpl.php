<?php 
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}}); 

	$("#title").formValidator({onshow:"<?php echo L("input").L('link_name')?>",onfocus:"<?php echo L("input").L('link_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('link_name')?>"}).ajaxValidator({type : "get",url : "",data :"app=link&controller=link&view=public_name&linkid=<?php echo $linkid;?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('link_name').L('exists')?>",onwait : "<?php echo L('connecting')?>"}).defaultPassed(); 

	$("#conten").formValidator({onshow:"<?php echo L("input").L('url')?>",onfocus:"<?php echo L("input").L('url')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('url')?>"}).regexValidator({regexp:"^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&]*([^<>])*$",onerror:"<?php echo L('link_onerror')?>"})
	
	})
//-->
</script>
<div class="pad-10">
<form method="post" action="?app=license&controller=admin_license&view=notice_edit&aid=<?php echo $_GET['aid']?>" name="myform" id="myform">
<table class="table_form" width="100%">
<tbody>
	<tr>
		<th width="80"><?php echo L('title')?>：</th>
		<td><input name="notice[title]" id="title" value="<?php echo htmlspecialchars($an_info['title'])?>" class="input-text" type="text" size="50" ></td>
	</tr>
	<tr>
		<th width="80"><?php echo L('content')?>：</th>
		<td >
		<input name="notice[content]" id="content" value="<?php echo $an_info['content']?>" type="text" size="50" >  只能发布50字内
		</td>
	</tr>
	<tr>
		<th width="80"><?php echo L('url')?>：</th>
		<td >
		<input name="notice[url]" id="url" value="<?php echo $an_info['url']?>" type="text" size="50" >
		</td>
	</tr>
	<tr>
		<th><?php echo L('notice_starttime')?>：</th>
		<td><?php echo form::date('notice[starttime]', $an_info['starttime'], 1)?></td>
	</tr>
	<tr>
		<th><?php echo L('notice_endtime')?>：</th>
		<td><?php $an_info['endtime'] = $an_info['endtime']=='0000-00-00' ? '' : $an_info['endtime']; echo form::date('notice[endtime]', $an_info['endtime'], 1);?></td>
	</tr>
	<tr>
		<th><?php echo L('license_tui')?></th>
		<td><input name="notice[tui]" type="radio" value="1" <?php if($an_info['tui']==1) {?>checked<?php }?>></input>&nbsp;<?php echo L('tui')?>&nbsp;&nbsp;<input name="notice[tui]" type="radio" value="0" <?php if($an_info['tui']==0) {?>checked<?php }?>>&nbsp;<?php echo L('untui')?></td>
	</tr>
	<tr>
		<th><?php echo L('license_status')?></th>
		<td><input name="notice[passed]" type="radio" value="1" <?php if($an_info['passed']==1) {?>checked<?php }?>></input>&nbsp;<?php echo L('pass')?>&nbsp;&nbsp;<input name="notice[passed]" type="radio" value="0" <?php if($an_info['passed']==0) {?>checked<?php }?>>&nbsp;<?php echo L('unpass')?></td>
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
	if (id=='') return false;
	$.getJSON('?app=admin&controller=category&view=public_tpl_file_list&style='+id+'&module=license&templates=show&name=license&safe_edi='+safe_edi, function(data){$('#show_template').html(data.show_template);});
}

$(document).ready(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$('#title').formValidator({onshow:"<?php echo L('input_license_domain')?>",onfocus:"<?php echo L('domain_min_3_chars')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('domain_cannot_empty')?>"}).ajaxValidator({type:"get",url:"",data:"app=license&controller=admin_license&view=public_check_notice",datatype:"html",cached:false,async:'true',success : function(data) {
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
	onerror : "<?php echo L('license_exist')?>",
	onwait : "<?php echo L('checking')?>"
	});
	$("#content").formValidator({autotip:true,onshow:"",onfocus:"<?php echo L('licensements_cannot_be_empty')?>"}).functionValidator({
	    fun:function(val,elem){
	    //获取编辑器中的内容
		var oEditor = CKEDITOR.instances.content;
		var data = oEditor.getData();
        if(data==''){
		    return "<?php echo L('licensements_cannot_be_empty')?>"
	    } else {
			return true;
		}
	}
	});
});
</script>
