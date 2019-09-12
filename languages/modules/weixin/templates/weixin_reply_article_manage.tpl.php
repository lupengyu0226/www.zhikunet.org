<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<table width="100%" cellspacing="0" class="search-form">
<tr>
<td><input type="submit" class="button" name="dosubmit" onclick="addarticle(<?php echo $replyid?>, ' ')" title="<?php echo L('edit')?>" value="添加图文"/></td>
</tr>
</table>
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：微信公号自动回复支持八条以下图文消息
		</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="table-list">
<form name="myform" id="myform" action="?app=weixin&controller=reply&view=listorder" method="post" >
<table width="100%" cellspacing="0" class="search-form">
    	<thead>
		<tr>
           
			<th width="10%" align="center">标题</th>
            <th width="10%" align="center">更新时间</th>
            <th width="30%" align="center">管理操作　</th>		         			
		</tr>
	</thead>
    <tbody>
    <?php foreach($lists as $k=>$v){?>
		<tr> 
              
		<td width="10%" align="center"><?php if($v['thumb']){echo $v['title'].$thumb; }else{echo $v['title'].$warning;}?></td>      
        <td width="10%" align="center">  <?php echo date("Y-m-d H:i:s",$v['updatetime']) ;?> </td>
        <td width="30%" align="center">
       
   <a href="###" onclick="edit(<?php echo $v['id']?>, '<?php echo $v['title']?>')" title="<?php echo L('edit')?>"><?php echo L('edit')?></a><?php if($v['default'] ==1){}else{?> | <a href='?app=weixin&controller=reply&view=delarcticle&id=<?php echo $v['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => $v['keyword']))?>')"><?php echo L('delete')?></a>
	<?php }?>		
			
			
			
        </td>
       
       
		</tr>
        <?php }?>
    </tbody>
</table>
</form>

<table width="100%" cellspacing="0" class="search-form">
<tr>
<td><input type="submit" class="button" name="dosubmit" onClick="javascript:history.go(-1);" value="返回"/></td>
</tr>
</table>
<div class="bk15"></div>

</div>

</div>

<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'editarticle'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editarticle',iframe:'?app=weixin&controller=reply&view=editarticle&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'editarticle'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editarticle'}).close()});
}
function addarticle(id, name) {
	window.top.art.dialog({id:'addarticle'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'addarticle',iframe:'?app=weixin&controller=reply&view=addarticle&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'addarticle'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'addarticle'}).close()});
}
</script>

</body>
</html>