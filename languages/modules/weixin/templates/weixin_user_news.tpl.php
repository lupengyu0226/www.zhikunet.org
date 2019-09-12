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
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
           <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=usermanage&view=init" >全部用户</a></li>
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=usermanage&view=news_users" >今天新增用户<span style="color:#f60;margin-left:10px;">(<?php echo $usernembers;?>人)</span></a></li>
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=usermanage&view=cancel_users" >已取消关注的用户</a></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
        <form name="searchform" action="" method="get" >
        <input type="hidden" value="weixin" name="app">
        <input type="hidden" value="usermanage" name="controller">
        <input type="hidden" value="init" name="view">
		用户名 <input type="text" value="" name="nickname"> 
            <input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
		  </form>
		 </div>
		</td>
		</tr>
    </tbody>
</table>
<fieldset>
<form action="?app=weixin&controller=usermanage&view=move" method="post" name="myform" id="myform">
	<table width="100%" cellspacing="0" class="search-form">
    	<thead>
		<tr>
			<th width="5%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="10%" align="center">昵称</th>
			<th width="5%" align="center">性别</th>
			<th width="15%" align="center">地址</th>
            <th width="10%" align="center">关注时间</th>
            <th width="10%" align="center">状态</th>
             <th width="10%" align="center">所在分组</th>
			 <th width="10%" align="center">所属平台</th>
            <th width="20%" align="center">操作管理</th>
		</tr>
	</thead>
    <tbody>
    <?php foreach((array)$tinfos as $tk=>$tv){?>
		<tr>
        <td align="center" width="5%"><input type="checkbox" name="id[]" value="<?php echo $tv['userid']?>"></td>
		<td width="10%" align="center"><?php echo $tv['nickname'];?></td>
        <td width="5%" align="center"> <?php if($tv['sex']==1){echo '男';}elseif($tv['sex']==2){echo '女';}else{echo '保秘';}?> </td>
		<td width="15%" align="center"> <?php echo $tv['country'].$tv['province'].$tv['city'];?> </td>
        <td width="10%" align="center"> <?php echo date("Y-m-d H:i:s",$tv['subscribe_time']) ;?> </td>
        <td width="10%" align="center"><?php if($tv['subscribe']==1){?><span style="color:#6C0;"><?php echo '<i class="iconfont icon-checkbox" style="color:red"></i>';?></span><?php }else{echo '<i class="iconfont icon-cuowu1" style="color:red"></i>';}?>  </td>
         <td width="10%" align="center"><font class="xbtn btn-white btn-xs"><?php echo $tv['name']?></font></td>
		 <td width="10%" align="center"><font class="xbtn btn-inverse btn-xs"><?php echo $tv['platform']?></font></td>
        <td width="20%" align="center"><?php if($tv['platform']=='微信'){?><a class="xbtn btn-info btn-xs" href="###" onclick="addusermessage('<?php echo $tv['openid']?>', '<?php echo $tv['nickname']?>')"
			title="向用户发送文本消息">发送文本</a>  <a class="xbtn btn-warning btn-xs" href="###" onclick="sentnews('<?php echo $tv['openid']?>', '<?php echo $tv['nickname']?>')"
			title="向用户发送图文消息">发送图文</a><?php }else{?><a class="xbtn btn-info btn-xs" href="###" onclick="addxzhmessage('<?php echo $tv['openid']?>', '<?php echo $tv['nickname']?>')"
			title="向用户发送文本消息">发送文本</a>  <a class="xbtn btn-warning btn-xs" href="###" onclick="sentxzhnews('<?php echo $tv['openid']?>', '<?php echo $tv['nickname']?>')"
			title="向用户发送图文消息">发送图文</a><?php }?></td>
		</tr>
        <?php }?>
    </tbody>
</table>
</fieldset>
<div class="btn"> 移动用户到
<select name="groupid" id="">
		<option value="0">分组名称</option>
		<?php
		  foreach($grouplist as $k=>$v){
		?>
		<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
		<?php }?>
		</select>
<input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  移动  ">
</form>
</div>
<div id="pages"><?php echo $pages?></div>
<div class="bk15"></div>
</div>
</div>
</div>
</div>
<div class="bk15"></div>
</body>
<!--end tab-->
<script type="text/javascript">
function addusermessage(id, name) {
	window.top.art.dialog({id:'sent_user_message'}).close();
	window.top.art.dialog({title:'添加文本消息 '+name+' ',id:'sent_user_message',iframe:'?app=weixin&controller=usermanage&view=sent_user_message&openid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'sent_user_message'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'sent_user_message'}).close()});
}
function sentnews(id, name) {
	window.top.art.dialog({id:'sent_news'}).close();
	window.top.art.dialog({title:'添加图文消息 '+name+' ',id:'sent_news',iframe:'?app=weixin&controller=usermanage&view=sent_news&openid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'sent_news'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'sent_news'}).close()});
}
function addxzhmessage(id, name) {
	window.top.art.dialog({id:'sent_xzh_message'}).close();
	window.top.art.dialog({title:'发送文本消息给 '+name+' ',id:'sent_xzh_message',iframe:'?app=weixin&controller=usermanage&view=sent_xzh_message&openid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'sent_xzh_message'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'sent_xzh_message'}).close()});
}
function sentxzhnews(id, name) {
	window.top.art.dialog({id:'sent_xzh_news'}).close();
	window.top.art.dialog({title:'发送图文消息给 '+name+' ',id:'sent_xzh_news',iframe:'?app=weixin&controller=usermanage&view=sent_xzh_news&openid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'sent_xzh_news'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'sent_xzh_news'}).close()});
}
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