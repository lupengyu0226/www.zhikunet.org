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
<div class="col-tab">
<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=catlist" >群发</a></li>
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=selfromcate" >站内内容</a></li>
             <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=addarticle" >手动添加</a></li>
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=havedset" >已发送</a></li>	
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：选择要发布消息的分组，发布的图文控制在7条以内。
		</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="table-list">
<form name="myform" id="myform" action="?app=weixin&controller=typesmanage&view=sent_colnews_togroup" method="post" >
<table width="100%" cellspacing="0" class="search-form">
    	<thead>
		<tr>
            <th width="10%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');">全选/反选</th>
			<th width="40%" align="left">标题</th>
            <th width="20%" align="center">更新时间</th>
            <th width="30%" align="center">管理操作</th>		         			
		</tr>
	</thead>
    <tbody>
    <?php foreach($group_news as $k=>$v){?>
		<tr> 
        <td align="center" width="10%"><input type="checkbox" name="id[]" value="<?php echo $v['id']?>"></td>      
		<td width="10%" align="left"><?php if(time()-$v['updatetime']<259200){echo $v['title'].$thumb; }else{echo $v['title'].$warning;}?></td>      
        <td width="20%" align="center">  <?php echo date("Y-m-d H:i:s",$v['inputtime']) ;?> </td>
        <td width="30%" align="center">
        <a href="###" onclick="edit(<?php echo $v['id']?>, '<?php echo $v['title']?>')" title="<?php echo L('edit')?>"><?php echo L('edit')?></a> 
        </td>
		</tr>
        <?php }?>
    </tbody>
</table>
<table>
<tr>
		<th></th>
		<td>
        <input name="catid" type="hidden" value="<?php echo $catid;?>" />
         </td>
	</tr>
</table>
<div class="btn"> 选择分组
<select name="group_id" id="">
		<option value="0">分组名称</option>
		<?php
		  foreach($grouplist as $k=>$v){
		?>
		<option value="<?php echo $v['id'];?>"><?php echo $v['name']."(".$v['count'].")";?></option>
		<?php }?>
		</select>
<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=preview&view=init'" value=" 预览 "/><input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  发布  "><input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=typesmanage&view=delete'" value=" <?php echo L('delete')?> "/><input type="button" class="button" name="b" onClick="javascript:history.go(-1);" value="返回"/>
</form>
</div>
<div id="pages"><?php echo $datas['pages']?></div>
<div class="bk15"></div>
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
<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'edit_groupnews'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit_groupnews',iframe:'?app=weixin&controller=typesmanage&view=edit_groupnews&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'edit_groupnews'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit_groupnews'}).close()});
}
</script>
</html>