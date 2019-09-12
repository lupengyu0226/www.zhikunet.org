<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
.attachment-list{ width:480px}
.attachment-list .cu{dispaly:block;float:right; background:url(http://statics.05273.cn/statics/images/admin_img/cross.png) no-repeat 0px 100%;width:20px; height:16px; overflow:hidden;}
.attachment-list li{ width:120px;height: 120px; padding:0 20px 10px; float:left}
.attachment-list li img{width:120px;height: 80px;}
</style>
<div class="pad-10">
<ul class="attachment-list">
	<?php foreach($thumbs as $thumb) {
    ?>
    <li>
            <img src="<?php echo $thumb['thumb_url']?>" alt="<?php echo $thumb['width']?> X <?php echo $thumb['height']?>" />
            <span class="cu" title="<?php echo L('delete')?>" onclick="thumb_delete('<?php echo urlencode($thumb['thumb_filepath'])?>',this)"></span>
            <?php echo $thumb['width']?> X <?php echo $thumb['height']?>
    </li>
    <?php } ?>
</ul>
</div>
<script type="text/javascript">
<!--
function thumb_delete(filepath,obj){
	 window.top.art.dialog({content:'<?php echo L('del_confirm')?>', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?app=attachment&controller=manage&view=pullic_delthumbs&filepath='+filepath+'&safe_edi=<?php echo $_SESSION[safe_edi]?>',function(data){
				if(data == 1) $(obj).parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
//-->
</script>
</html>