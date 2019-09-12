<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<form action="?app=api&controller=admin_api&view=update" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th align="left" >接口名称</th>
		<th align="left" >说明</th>
		<th align="left" >操作</th>
		</tr>
        </thead>
<tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
	$filename = basename($v);
?>
<tr>
<?php 
 		echo '<td align="left"><i class="iconfont icon-html"></i> '.$filename.'</td><td align="left"><input type="text" name="file_explan['.$encode_local.']['.$filename.']" value="'.(isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "").'"></td><td align="left"><a class="xbtn btn-warning btn-xs" href="javascript:;">编辑</a></td>';
?>    
</tr>
<?php 
	endforeach;
endif;
?></tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="提交" ></div> 
</form>
</div>
</div>
</body>
</html>