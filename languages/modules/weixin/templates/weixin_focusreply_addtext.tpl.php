<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<style type="text/css">
body{ padding:0;font:12px "宋体"; }

dd.box{float:left; width:30%;margin:5px;line-height:30px; background-color:#f5f5f5;padding-left:5px;}
</style>
<div class="pad-10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：微信关注回复信息是指用户在关注微信公众号时，自动回复给用户的信息，一般是图文和文本两种，例：欢迎关注xxx。
		</div>
		</td>
		</tr>
    </tbody>
</table>
</div>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
    <li id="tab_setting_1"  onclick="SwapTab('setting','on','',2,1);"><a href="?app=weixin&controller=focusreply&view=init" >图文消息</a></li>
    <li id="tab_setting_2" class="on" onclick="SwapTab('setting','on','',2,2);">文本消息</li>    			
</ul>
<fieldset>
   <form action="?app=weixin&controller=focusreply&view=addtext" method="post" name="myform2" id="myform2">
   <textarea name="weixin[content]" cols="100" rows="20" style="margin-top:20px;"><?php echo $infos['content']?></textarea>
    <div class="btn"> 
<input type="submit" class="button" name="dosubmit" value=" <?php echo L('submit')?> "/>
    </form>
   </div>
</fieldset>
<div class="bk15"></div>
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