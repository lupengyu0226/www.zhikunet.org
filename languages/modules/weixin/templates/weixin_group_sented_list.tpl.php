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
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=catlist" >群发</a></li>
            <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=selfromcate" >站内内容</a></li>
             <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=addarticle" >手动添加</a></li>
             <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=typesmanage&view=havedset" >已发送</a></li>
            
            
			
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：图文群发历史回收站，启用后将回到分组群发。
		</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="table-list">
<form name="myform" id="myform" action="?app=weixin&controller=typesmanage&view=havedset" method="post" >
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
		<td width="10%" align="left"><?php echo $v['title'];?></td>      
        <td width="20%" align="center">  <?php echo date("Y-m-d H:i:s",$v['inputtime']) ;?> </td>
        <td width="30%" align="center">
       <a href="?app=weixin&controller=typesmanage&view=delete&id=<?php echo $v['id'];?> "><font class="xbtn btn-danger btn-xs"><?php echo L('delete')?></font></a>
 
        </td>
       
       
		</tr>
        <?php }?>
        
    </tbody>
</table>

<div class="btn"> 
<input type="submit" name="dosubmit" id="dosubmit"  class="button" value="  启用  ">&nbsp;&nbsp;<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=typesmanage&view=delete'" value="<?php echo L('delete')?>"/>
</form>

</div>
<div id="pages"><?php echo $pages?></div>

</div>
</div>

</div>
</div>
<div class="bk15"></div>

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