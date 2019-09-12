<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<div class="bk15"></div>

<div class="explain-col">
<?php echo L('card_msg')?>
</div>
<div class="bk15"></div>
<?php 
if (empty($pic_url)) {
	echo '<input type="button" class="button" value="'.L('apply_for_a_password_card').'" onclick="location.href=\'?app=admin&controller=admin_manage&view=creat_card&userid='.$userid.'&safe_edi='.$_SESSION['safe_edi'].'\'">';
} else {
	echo '<input type="button" class="button" value="'.L('the_password_card_binding').'" onclick="location.href=\'?app=admin&controller=admin_manage&view=remove_card&userid='.$userid.'&safe_edi='.$_SESSION['safe_edi'].'\'"><div class="bk15"></div><img src="'.$pic_url.'">';
}
?>
</div>
</body>
</html>
