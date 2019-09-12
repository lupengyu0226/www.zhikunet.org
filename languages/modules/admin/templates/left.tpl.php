<?php
defined('IN_ADMIN') or exit('No permission resources.');
$safe_edi = $_SESSION['safe_edi'];
foreach($datas as $_value) {
	echo '<h3 class="f14"><span class="switchs cu on" title="'.L('expand_or_contract').'">'.L($_value['name']).'</span></h3>';
	echo '<ul>';
	$sub_array = admin::admin_menu($_value['id']);
	foreach($sub_array as $_key=>$_m) {
		//附加参数
		$data = $_m['data'] ? '&'.$_m['data'] : '';
		if($menuid == 5) { //左侧菜单不显示选中状态
			$classname = 'class="sub_menu"';
		} else {
			$classname = 'class="sub_menu"';
		}
		echo '<li id="_MP'.$_m['id'].'" '.$classname.'><a href="javascript:_MP('.$_m['id'].',\'?app='.$_m['m'].'&controller='.$_m['c'].'&view='.$_m['a'].$data.'\');" hidefocus="true" style="outline:none;">'.L($_m['name']).'</a></li>';
	}
	echo '</ul>';
}
?>
<script type="text/javascript">
$(".switchs").each(function(i){
	var ul = $(this).parent().next();
	$(this).click(
	function(){
		if(ul.is(':visible')){
			ul.hide();
			$(this).removeClass('on');
				}else{
			ul.show();
			$(this).addClass('on');
		}
	})
});
</script>
