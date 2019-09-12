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
            <li id="tab_setting_1" class="on">消息列表</li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<fieldset>
<form name="myform" id="myform" action="?app=weixin&controller=weixin&view=listorder" method="post" >
	<table width="100%" cellspacing="0" class="search-form">
    	<thead>
		<tr>
			<th width="5%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th width="10%" align="center">ID</th>
			<th width="5%" align="center">关键词</th>
			<th width="15%" align="center">所属平台</th>
            <th width="10%" align="center">发送时间</th>
            <th width="10%" align="center">发送者</th>
             <th width="10%" align="center">状态</th>
		</tr>
	</thead>
    <tbody>
    <?php foreach((array)$data as $uk=>$uv){?>
		<tr>
        <td align="center" width="5%"><input type="checkbox" name="id[]" value="<?php echo $uv['id']?>"></td>
		<td width="10%" align="center"><?php echo $uv['id']?></td>
        <td width="5%" align="center"><?php echo $uv['keyword']?></td>
        <td width="15%" align="center"><font class="xbtn btn-inverse btn-xs"><?php echo $uv['name']?></font></td>
        <td width="10%" align="center"><?php echo $uv['inputtime']?></td>
        <td width="10%" align="center"><?php echo $uv['username']?></td>
		<td width="20%" align="center"><a href="?app=weixin&controller=weixin&view=replyword_status&id=<?php echo $uv['id']?>&passed=<?php echo $uv['passed']==0 ? 1 : 0?>"><?php echo $uv['passed']==0 ? L('<p class="xbtn btn-danger btn-xs">未审</p>') : L('<p class="xbtn btn-white btn-xs">通过</p>')?></a></td>
        <?php }?>
    </tbody>
</table>
</fieldset>
<div class="btn"><input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?app=weixin&controller=weixin&view=replyword_delete'" value="<?php echo L('delete')?>"/></div>
</form>
</div>
<div id="pages"><?php echo $pages?></div>
<div class="bk15"></div>
</div>
</div>
</div>
</div>
</body>
</html>