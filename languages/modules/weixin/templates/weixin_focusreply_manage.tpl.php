<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<style type="text/css">
body{ padding:0;font:12px "宋体";  }
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
<!--tab-->
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
    <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',2,1);">图文消息</li>
    <li id="tab_setting_2" onclick="SwapTab('setting','on','',2,2);"><a href="?app=weixin&controller=focusreply&view=addtext" >文本消息</a></li>
            			
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
 <form action="?app=weixin&controller=focusreply&view=addgraphic" method="post" name="myform" id="myform">
    <dl>
        <?php foreach($keywords as $k=>$v){?>
        <dd class="box"> 
         
            <label>
              <input type="radio" name="weixin[replyid]" value="<?php echo $v['id']?>" id="replyid_0" <?php if($v['id']==$infos['replyid']){echo " checked='checked'";}?> class="radio_style"/>
             <?php echo $thumb.$v['keyword'].'['.$v['num'].']'?></label>
           </label>
           
          
          </dd>
          <?php }?>
          
        </dl>
    <div style="clear:both;height:15px;"></div>
         <input name="weixin[content]" type="hidden" value="" />
         <div id="pages"><?php echo $pages?></div>
        <div class="btn"> 
       <input type="submit" class="button" name="dosubmit" value=" <?php echo L('submit')?> "/>
       </div>
         </form>


<div class="bk15"></div>

</div><!--/table-list-->
</div><!--/#div_setting_1-->


</div><!--/table-list-->
</div><!--/#div_setting_2-->
<div class="bk15"></div>

</div><!--/col-tab-->
</div><!--/pad-10-->
<!--end tab-->
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