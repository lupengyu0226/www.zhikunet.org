<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<style type="text/css">
<!--
.showMsg{border: 1px solid #3B4658; zoom:1; width:450px; height:265px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px;border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;}
.showMsg h5{border-radius: 3px 3px 0 0;-webkit-border-radius: 3px 3px 0 0;background: #3B4658; color:#fff; padding-left:15px; height:40px; line-height:40px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .footer{border-radius:0 0 3px 3px;-webkit-border-radius:0 0 3px 3px;background: #3B4658; color:#fff; padding-left:5px; height:40px; line-height:40px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ margin-top:85px; font-size:14px; height:100px; position:relative}
#search_div{ position:absolute; top:23px; border:1px solid #dfdfdf; text-align:left; padding:1px; left:89px;*left:88px; width:263px;*width:260px; background-color:#FFF; display:none; font-size:12px}
#search_div li{ line-height:24px;}
#search_div li a{  padding-left:6px;display:block}
#search_div li a:hover{ background-color:#e2eaff}
-->
</style>
<div class="showMsg" style="text-align:center">
	<h5><?php echo L('quick_into');?></h5>
    <div class="content">
	<input type="text" size="41" id="cat_search" value="<?php echo L('search_category');?>" onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;">
    <ul id="search_div"></ul>
	</div>
<div class='footer'></div>
</div>
<script type="text/javascript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?app=content&controller=content&view=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>&safe_edi=<?php echo $_SESSION['safe_edi'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
$(document).ready(function(){
	setInterval(closeParent,5000);
});
function closeParent() {
	if($('#closeParentTime').html() == '') {
		window.top.$(".left_menu").addClass("left_menu_on");
		window.top.$("#openClose").addClass("close");
		window.top.$("html").addClass("on");
		$('#closeParentTime').html('1');
		window.top.$("#openClose").data('clicknum',1);
	}
}
$().ready(
function(){
	$('#cat_search').keyup(
		function(){
			var value = $("#cat_search").val();
			if (value.length > 0){
				$.getJSON('?app=admin&controller=category&view=public_ajax_search', {catname: value}, function(data){
					if (data != null) {
						var str = '';
						$.each(data, function(i,n){
							if(n.type=='0') {
								str += '<li><a href="?app=content&controller=content&view=init&menuid=822&catid='+n.catid+'&safe_edi='+safe_edi+'">'+n.catname+'</a></li>';
							} else {
								str += '<li><a href="?app=content&controller=content&view=add&menuid=822&catid='+n.catid+'&safe_edi='+safe_edi+'">'+n.catname+'</a></li>';
							}
						});
						$('#search_div').html(str);
						$('#search_div').show();
					} else {
						$('#search_div').hide();
					}
				});
			} else {
				$('#search_div').hide();
			}
		}
	);
}
)

//-->
</script>
</body>
</html>
