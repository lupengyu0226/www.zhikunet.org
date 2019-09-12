<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		<form name="searchform" action="" method="get" >
        <input type="hidden" value="weixin" name="app">
        <input type="hidden" value="reply" name="controller">
        <input type="hidden" value="init" name="view">
		关键词名称:<input name="keyword" type="text" />
            <input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
		  </form>
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
			<th width="5%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="10%" align="center">关键词</th>
            <th width="5%" align="center">被调用次数</th>
            <th width="5%" align="center">图文数量</th>
            <th width="10%" align="center">更新时间</th>
            <th width="20%" align="center">管理操作</th>		         			
		</tr>
	</thead>
    <tbody>
    <?php foreach($infos as $k=>$v){?>
		<tr>
        <td align="center" width="5%"><input type="checkbox" name="id[]" value="<?php echo $v['id']?>"></td>
		<td width="10%" align="center"><?php echo $v['keyword'];?><?php if($v['type']==1){?><i class='iconfont icon-img' style='color:green'></i><?php }elseif($v['type']==5){echo "<i class='iconfont icon-wailian'></i>";}elseif($v['type']==6){echo "<i class='iconfont icon-wailian'></i>";}else{echo "<i class='iconfont icon-neirong'></i>";}?></td>
        <td align="center" width="5%"><?php echo $v['views'] ;?></td>
        <td width="10%" align="center">  <?php echo $v['num'] ;?> </td>
        <td width="10%" align="center">  <?php echo date("Y-m-d H:i:s",$v['updatetime']) ;?> </td>
        <td width="30%" align="center">
       <?php if($v['type']==1){?>
        <a href="###"
			onclick="edit(<?php echo $v['id']?>, '<?php echo $v['keyword']?>')"
			title="<?php echo L('edit')?>"><font class="xbtn btn-info btn-xs"><?php echo L('keyword_manage')?></font></a>
            <?php  }elseif($v['type']==5){?>
				<a href="###"
			onclick="editbandingcat(<?php echo $v['id']?>, '<?php echo $v['keyword']?>')"
			title="<?php echo L('edit')?>"><font class="xbtn btn-info btn-xs"><?php echo L('keyword_manage')?></font></a>
				<?php }elseif($v['type']==6){?>
				<a href="###"
			onclick="editsearchtag(<?php echo $v['id']?>, '<?php echo $v['keyword']?>')"
			title="<?php echo L('edit')?>"><font class="xbtn btn-info btn-xs"><?php echo L('keyword_manage')?></font></a>
				<?php }else{?><a href="###"
			onclick="edittext(<?php echo $v['id']?>, '<?php echo $v['keyword']?>')"
			title="<?php echo L('edit')?>"><font class="xbtn btn-info btn-xs"><?php echo L('keyword_manage')?></font></a><?php }?> <a
			href='?app=weixin&controller=reply&view=delete&id=<?php echo $v['id']?>'
			onClick="return confirm('<?php echo L('confirm', array('message' => $v['keyword']))?>')"><font class="xbtn btn-danger btn-xs"><?php echo L('delete')?></font></a> 
        </td>
       
       
		</tr>
        <?php }?>
    </tbody>
</table>

<div class="bk15"></div>

</div>
<div class="btn"> 
<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=reply&view=delete'" value="<?php echo L('delete')?>"/></div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'editkeyword'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editkeyword',iframe:'?app=weixin&controller=reply&view=editkeyword&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'editkeyword'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editkeyword'}).close()});
}
function editbandingcat(id, name) {
	window.top.art.dialog({id:'editbandingcat'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editbandingcat',iframe:'?app=weixin&controller=reply&view=editbandingcat&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'editbandingcat'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editbandingcat'}).close()});
}
function editsearchtag(id, name) {
	window.top.art.dialog({id:'editsearchtag'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editsearchtag',iframe:'?app=weixin&controller=reply&view=editsearchtag&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'editsearchtag'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editsearchtag'}).close()});
}
function addarticle(id, name) {
	window.top.art.dialog({id:'addarticle'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'addarticle',iframe:'?app=weixin&controller=reply&view=addarticle&id='+id,width:'1000',height:'600'}, function(){var d = window.top.art.dialog({id:'addarticle'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'addarticle'}).close()});
}
function edittext(id, name) {
	window.top.art.dialog({id:'edittext'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edittext',iframe:'?app=weixin&controller=reply&view=edittext&id='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'edittext'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edittext'}).close()});
}
</script>

</body>
</html>