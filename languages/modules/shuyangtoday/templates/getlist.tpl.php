<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="shuyangtoday" name="app">
<input type="hidden" value="manages" name="controller">
<input type="hidden" value="getlist" name="view">
<input type="hidden" name="modelid" value="1" id="modelid"/>
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
			<select name="field">
				<option value='title' <?php if($_GET['field']=='title') echo 'selected';?>>标题</option>
				<option value='keywords' <?php if($_GET['field']=='keywords') echo 'selected';?> >关键字</option>
				<option value='description' <?php if($_GET['field']=='description') echo 'selected';?>>导读</option>
				<option value='id' <?php if($_GET['field']=='id') echo 'selected';?>>ID</option>
			</select>
			<?php echo form::select_category('',$_GET['catid'],'name="catid"','不限栏目','',0,1);?>
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
            <th >标题</th>
            <th width="100">添加时间</th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($infos as $r) { ?>
	<tr onclick="select_list(this,'<?php echo safe_replace($r['title']);?>','<?php echo $r['id'];?>','<?php echo $r['catid'];?>','<?php echo $r['url'];?>','<?php echo $r['thumb'];?>')"  title="点击选择">
		<td align='left' ><?php echo $r['title'];?><?php if($r['thumb']!='') {echo '<img src="'.IMG_PATH.'icon/small_img.gif" title="'.L('thumb').'">'; } ?></td>
		<td align='center'><?php echo date('Y-m-d', $r['inputtime']);?></td>
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
