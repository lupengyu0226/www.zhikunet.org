<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<script type="text/javascript">
$(document).ready(function(){
	 if( $("#select").val() == 'click'){
		           $('#t').show();
                   $('#tuwen').show();
				   $('#text').hide();
                   $('#miniprogram').hide();
                    
                }
	if( $("#select").val() == 'view'){
		           $('#t').hide();
                   $('#tuwen').hide();
				   $('#text').show();
                   $('#miniprogram').hide();
                    
                }
	if( $("#select").val() == 'miniprogram'){
		           $('#t').hide();
                   $('#tuwen').hide();
				   $('#text').hide();
                   $('#miniprogram').show();
                    
                }
$("#select").change(function(){
	   if( $("#select").val() == 'click'){
		           $('#t').show();
                   $('#tuwen').show();
				   $('#text').hide();
                   $('#miniprogram').hide();
                    return;
                }
       if( $("#select").val() == 'view'){
		           $('#t').hide();
                   $('#tuwen').hide();
				   $('#text').show();
                   $('#miniprogram').hide();
                    return;
                }
	if( $("#select").val() == 'miniprogram'){
		           $('#t').hide();
                   $('#tuwen').hide();
                   $('#text').hide();
				   $('#miniprogram').show();
                    return;
                }
	   if( $("#select").val() == ''){
		        $('#t').show();
				$('#tuwen').show();
				$('#text').hide();
                $('#miniprogram').hide();
				  return;
			  }
	
	  });
	  })
</script>
<style type="text/css">
dd.box{float:left; width:40%;margin:5px;line-height:30px; background-color:#f5f5f5;padding-left:5px;}
</style>
<div class="pad_10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：有图标的为图文，没有的为文本
		</div>
		</td>
		</tr>
    </tbody>
</table>
<table width="100%" cellspacing="0" class="search-form">
   
</table>
<form action="?app=weixin&controller=weixin&view=addevent&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

    <tr>
		<th width="100" align="left">事件类型：</th>
		<td>
        <select name="weixin[type]" id="select" >
        <?php if($infos['type']=='click'){?>
		<option value="click" "selected">单拉取消息</option>
        <option value="view" >跳转链接</option>
        <option value="miniprogram" >小程序</option>
		<?php }elseif($infos['type']=='view'){ ?>
        <option value="view" "selected" >跳转链接</option>
        <option value="click" >单拉取消息</option>
        <option value="miniprogram" >小程序</option>
		<?php }elseif($infos['type']=='miniprogram'){ ?>
        <option value="miniprogram" "selected">小程序</option>
        <option value="view">跳转链接</option>
        <option value="click" >单拉取消息</option>
        <?php }else{?>
       <option value="">请选择事件类型</option>
       <option value="click">单拉取消息</option>
       <option value="view" >跳转链接</option>
       <option value="miniprogram">小程序</option>
        <?php }?>
		  
         </td>
	</tr>
	</table>
    <table cellpadding="2" cellspacing="1" class="table_form" width="100%" id="t">
    <tr>
		<th width="100" align="left"><b>请选择关键词</b></th>
		<td></td>
        </tr>
    </table>
    <table cellpadding="2" cellspacing="1" class="table_form" width="100%">
    <tr id="tuwen">
		
		<td>
        <div>
        <dl>
        <?php foreach($keywords as $k=>$v){?>
        <dd class="box"> 
         
            <label>
              <input type="radio" name="weixin[replyid]" value="<?php echo $v['id']?>" id="replyid_0" <?php if($v['id']==$infos['replyid']){echo " checked='checked'";}?> class="radio_style"/>
              <?php echo $v['keyword']?><?php if($v['type']==1){?><?php echo $thumb ?><?php }?></label>
           </label>
           
          
          </dd>
          <?php }?>
         
        </dl>
        </div>
        <div id="pages"><?php echo $pages?></div>
        </td>
     </tr>
     
    </table>
    <table cellpadding="2" cellspacing="1" class="table_form" width="100%" id="text" style="display:none;">
    <tr>
		<th width="100" align="left">链接网址</th>
		<td><input name="weixin[url]" type="text" size="50" value="<?php echo $infos['Url']?>" /></td>
        </tr>
    </table>
    <table cellpadding="2" cellspacing="1" class="table_form" width="100%" id="miniprogram" style="display:none;">
    <tr>
		<th width="100" align="left">小程序 APPID</th>
		<td><input name="weixin[program]" type="text" size="50" value="<?php echo $infos['program']?>" /></td>
        </tr>
    <tr>
		<th width="100" align="left">页面路径</th>
		<td><input name="weixin[pagepath]" type="text" size="50" value="<?php echo $infos['pagepath']?>" />示例：pages/lunar/index</td>
        </tr>
    <tr>
		<th width="100" align="left">最终页面</th>
		<td><input name="weixin[Url]" type="text" size="50" value="<?php echo $infos['Url']?>" />示例： http://www.05273.cn</td>
        </tr>
    </table>
     <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
    </form>

</div>
</body>
</html> 