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
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=usermanage&view=news_users" >今天新增用户</a></li>
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=usermanage&view=cancel_users" >已取消关注的用户<span style="color:#f60;margin-left:10px;">(<?php echo $usernembers;?>人)</span></a></li>		
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
	<table width="100%" cellspacing="0" class="search-form">
    	<thead>
		<tr>
			<th width="10%" align="center">昵称</th>
			<th width="5%" align="center">性别</th>
			<th width="15%" align="center">地址</th>
            <th width="10%" align="center">关注时间</th>
            <th width="10%" align="center">状态</th>
			<th width="10%" align="center">所属平台</th>
		</tr>
	</thead>
    <tbody>
    <?php foreach((array)$nouserinfos as $nk=>$nv){?>
		<tr>
		<td width="10%" align="center"><?php echo $nv['nickname'];?></td>
        <td width="5%" align="center"> <?php if($nv['sex']==1){echo '男';}elseif($nv['sex']==2){echo '女';}else{echo '保秘';}?> </td>
        <td width="15%" align="center"> <?php echo $nv['country'].$nv['province'].$nv['city'];?> </td>
        <td width="10%" align="center"> <?php echo date("Y-m-d H:i:s",$nv['subscribe_time']) ;?> </td>
        <td width="10%" align="center"><p class="xbtn btn-danger btn-xs"><?php if($nv['subscribe']==1){?><span style="color:#6C0;"><?php echo '关注';?></span><?php }else{echo '取消关注';}?></p></td>
		<td width="10%" align="center"><p class="xbtn btn-inverse btn-xs"><?php echo $nv['platform'];?></p></td>
		</tr>
        <?php }?>
    </tbody>
</table>
</fieldset>
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