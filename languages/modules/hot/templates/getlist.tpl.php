<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="hot" name="app">
<input type="hidden" value="hot" name="controller">
<input type="hidden" value="getlist" name="view">
<input type="hidden" value="1579" name="menuid">
<input type="hidden" name="modelid" value="1" id="modelid"/>
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
			<select name="field">
				<option value='title' <?php if($_GET['field']=='title') echo 'selected';?>>标题</option>
				<option value='tag' <?php if($_GET['field']=='tag') echo 'selected';?> >关键字</option>
				<option value='contentid' <?php if($_GET['field']=='contentid') echo 'selected';?>>内容ID</option>
			</select>
			<?php echo form::select_category('',$_GET['catid'],'name="catid"','','',0,1);?>
			<input name="keywords" type="text" value="<?php echo stripslashes($_GET['keywords'])?>" style="width:250px;" class="input-text" />
			<input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th >ID</th>
            <th >内容ID</th>
            <th >所属栏目</th>
            <th >关键字</th>
            <th >标题</th>
            <th >链接</th>
            <th width="100">添加时间</th>
            <th >相关操作</th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($infos as $r) { ?>
	<tr>
	    <td align='left' ><?php echo $r['id'];?></td>
	    <td align='left' ><?php echo $r['contentid'];?></td>
	    <td align='left' ><?php echo $this->categorys[$r['catid']]['catname'];?></td>
		<td align='left' ><?php echo $r['tag'];?></td>
		<td align='left' ><?php echo $r['title'];?></td>
		<td align='left' ><?php echo $r['url'];?></td>
		<td align='center'><?php echo date('Y-m-d', $r['updatetime']);?></td>
		<td align="center"><a class="xbtn btn-primary btn-xs" href="javascript:;" onclick="javascript:openwinx('?app=content&controller=content&view=edit&catid=<?php echo $r['catid'];?>&id=<?php echo $r['contentid']?>','')">编辑</a> <a class="xbtn btn-danger btn-xs" href="?app=hot&controller=hot&view=kacha&id=<?php echo $r['id']?>&catid=<?php echo $r['catid']?>&contentid=<?php echo $r['contentid']?>" onclick="return confirm('<?php echo htmlspecialchars(new_addslashes(L('confirm', array('message'=>$r['title']))))?>')">删除</a></td>
	</tr>
	 <?php }?>
	    </tbody>
    </table>
  <div id="pages"><?php echo $pages;?></div>
</div>
</div>

<input type="hidden" value="listdata" name="listdata" id="listdata">
<style type="text/css">
.line_ff9966{
	background-color:#FF9966;
}

</style>
<SCRIPT LANGUAGE="JavaScript">
	function select_list(obj,title,id,catid,url,thumb) {
		$('#listdata').val(title+'|'+id+'|'+catid+'|'+url+'|'+thumb);
		$(obj).addClass('line_ff9966');
		$(obj).siblings().removeClass('line_ff9966');
	}
</SCRIPT>
</body>
</html>
