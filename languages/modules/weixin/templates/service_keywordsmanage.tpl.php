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
        <input type="hidden" value="service" name="controller">
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
           
            <th width="10%" align="center">更新时间</th>
            <th width="20%" align="center">管理操作</th>		         			
		</tr>
	</thead>
    <tbody>
    <?php foreach($infos as $k=>$v){
		      
		?>
       
		<tr>
        <td align="center" width="5%"><input type="checkbox" name="id[]" value="<?php echo $v['id']?>"></td>
		<td width="10%" align="center"><?php echo $v['keyword'];?>
		</td>
        <td align="center" width="5%"><?php echo $v['views'] ;?></td>
      
        <td width="10%" align="center">  <?php echo date("Y-m-d H:i:s",$v['updatetime']) ;?> </td>
        <td width="20%" align="center">
      
        <a href="###"
			onclick="edit(<?php echo $v['id']?>, '<?php echo $v['keyword']?>')"
			title="<?php echo L('edit')?>"><font class="xbtn btn-info btn-xs"><?php echo L('修改')?></font></a>
           
        </td>
       
       
		</tr>
        <?php 
		
		}?>
    </tbody>
</table>

<div class="bk15"></div>

</div>
<div class="btn"> 
<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=service&view=delete'" value="<?php echo L('delete')?>"/></div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
function edit(id, name) {
	window.top.art.dialog({id:'editkeyword'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'editkeyword',iframe:'?app=weixin&controller=service&view=editkeyword&id='+id,width:'600',height:'200'}, function(){var d = window.top.art.dialog({id:'editkeyword'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editkeyword'}).close()});
}

</script>

</body>
</html>