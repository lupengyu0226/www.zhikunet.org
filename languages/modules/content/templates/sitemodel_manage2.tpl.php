<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?app=content&controller=content&view=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>&safe_edi=<?php echo $_SESSION['safe_edi'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
//-->
</SCRIPT>
<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<?php
$safe_edi = $_SESSION['safe_edi'];
foreach($datas2 as $r) {
	echo "<a href=\"?app=content&controller=content_all&view=init&modelid=".$r['modelid']."&menuid=822&safe_edi=".$safe_edi."\"";
	if($r['modelid']==$modelid) echo "class='on'";
	echo "><em>".$r['name']."</em></a>　";
}
?>
</div>
</div>
</body>
</html>