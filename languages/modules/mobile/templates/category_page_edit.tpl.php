<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script type="text/javascript"> 
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#catname").formValidator({onshow:"<?php echo L('input_catname');?>",onfocus:"<?php echo L('input_catname');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_catname');?>"}).defaultPassed();
		$("#catdir").formValidator({onshow:"<?php echo L('input_dirname');?>",onfocus:"<?php echo L('input_dirname');?>"}).regexValidator({regexp:"^([a-zA-Z0-9]|[_-]){0,30}$",onerror:"<?php echo L('enter_the_correct_catname');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_dirname');?>"}).ajaxValidator({type : "get",url : "",data :"app=admin&controller=category&view=public_check_catdir&old_dir=<?php echo $catdir;?>",datatype : "html",cached:false,getdata:{parentid:'parentid'},async:'true',cached:false,success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('catname_have_exists');?>",onwait : "<?php echo L('connecting');?>"}).defaultPassed();
	})
//-->
</script>

<form name="myform" id="myform" action="?app=mobile&controller=category&view=edit" method="post">
<div class="pad-10">
<div class="col-tab">

<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',3,1);"><i class="iconfont icon-shezhi"></i> <?php echo L('catgory_basic');?></li>
            <li id="tab_setting_2" onclick="SwapTab('setting','on','',3,2);"><i class="iconfont icon-html"></i> <?php echo L('catgory_createhtml');?></li>
            <li id="tab_setting_3" onclick="SwapTab('setting','on','',3,3);"><i class="iconfont icon-seo"></i> <?php echo L('catgory_seo');?></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<table width="100%" class="table_form ">
<tr>
  <th width="200"><?php echo L('available_styles');?>：</th>
        <td>
		<?php echo form::select($template_list, $mobilesetting['template_list'], 'name="mobilesetting[template_list]" id="template_list" onchange="load_file_list(this.value)"', L('please_select'))?> 
		</td>
</tr>
		<tr>
        <th width="200"><?php echo L('page_templates')?>：</th>
        <td  id="page_template">
		</td>
      </tr> 	  
</table>

</div>
<div id="div_setting_2" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
      <input type="hidden" name='mobilesetting[ishtml]' value='0' <?php if(!$mobilesetting['ishtml']) echo 'checked';?>  onClick="$('#category_php_ruleid').css('display','');$('#category_html_ruleid').css('display','none');$('#tr_domain').css('display','none');">
	<tr>
      <th width="200"><?php echo L('category_urlrules');?>：</th>
      <td><div id="category_php_ruleid" style="display:<?php if($mobilesetting['ishtml']) echo 'none';?>">
	<?php
		echo form::urlrule('mobile','category',0,$mobilesetting['category_ruleid'],'name="category_php_ruleid"');
	?>
	</div>
	<div id="category_html_ruleid" style="display:<?php if(!$mobilesetting['ishtml']) echo 'none';?>">
	<?php
		echo form::urlrule('mobile','category',1,$mobilesetting['category_ruleid'],'name="category_html_ruleid"');
	?>
	</div>
	</td>
    </tr>
</table>
</div>
<div id="div_setting_3" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
	<tr>
      <th width="200"><?php echo L('meta_title');?></th>
      <td><input name='mobilesetting[meta_title]' type='text' id='meta_title' value='<?php echo $mobilesetting['meta_title'];?>' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th ><?php echo L('meta_keywords');?></th>
      <td><textarea name='mobilesetting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"><?php echo $mobilesetting['meta_keywords'];?></textarea></td>
    </tr>
    <tr>
      <th ><strong><?php echo L('meta_description');?></th>
      <td><textarea name='mobilesetting[meta_description]' id='meta_description' style="width:90%;height:50px"><?php echo $mobilesetting['meta_description'];?></textarea></td>
    </tr>
</table>
</div>
 <div class="bk15"></div>
	<input name="catid" type="hidden" value="<?php echo $catid;?>">
	<input name="type" type="hidden" value="<?php echo $type;?>">
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">

</form>
</div>

</div>
<!--table_form_off-->
</div>

<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
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
	function load_file_list(id) {
		if(id=='') return false;
		$.getJSON('?app=mobile&controller=category&view=public_tpl_file_list&style='+id+'&catid=<?php echo $catid?>&type=1', function(data){$('#page_template').html(data.page_template);});
	}
	<?php if(isset($mobilesetting['template_list']) && !empty($mobilesetting['template_list'])) echo "load_file_list('".$mobilesetting['template_list']."')"?>
//-->
</script>