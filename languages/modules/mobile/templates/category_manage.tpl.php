<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<form name="myform" action="?app=mobile&controller=category&view=listorder" method="post">
<div class="pad_10">
<div class="explain-col">
<?php echo L('category_cache_tips');?>，<a href="?app=mobile&controller=category&view=public_cache&menuid=43&module=mobile"><?php echo L('update_cache');?></a>
</div>
<div class="bk10"></div>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="38"><?php echo L('listorder');?></th>
            <th width="30">catid</th>
            <th align='left' width='250'><?php echo L('catname');?></th>
            <th align='left' width='100'><?php echo L('category_type');?></th>
            <th align='left' width="100"><?php echo L('modelname');?></th>
            <th align='left' width='100'><?php echo L('访问');?></th>
			<th ><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php echo $categorys;?>
    </tbody>
    </table>

    <div class="btn">
	<input type="hidden" name="safe_edi" value="<?php echo $_SESSION['safe_edi'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
</div>
</form>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>
