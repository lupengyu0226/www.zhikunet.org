<?php 
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
<table width="100%" cellspacing="0" class="table-list">
	<thead>
		<tr>
			<th width="15%" align="right"><?php echo L('selects')?></th>
			<th align="left"><?php echo L('values')?></th>
		</tr>
	</thead>
<tbody>
<?php
if ( is_array( $forminfos_data ) ) {
	foreach($forminfos_data as $key => $form){
?>   
	<tr>
		<?php if( $key === 'logo') { //判断单图字段，其中imga为你的字段名 ?>
			<td><?php echo $fields[$key]['name']?>:</td>
			<td><a href="<?php echo $form ;?>" target="_blank"><img src="<?php echo $form ;?>" style=" height: 50px; float: left; margin-right: 5px; margin-bottom: 5px;"></a></td>
		<?php }elseif( $key === 'images') { //判断多图字段，其中imgb为你的字段名   ?>
			<td><?php echo $fields[$key]['name']?>:</td>
			<td>
			<?php foreach( $form as $v ){ ?>
				<a href="<?php echo $v['url'] ;?>" target="_blank"><img src="<?php echo $v['url'] ;?>" style=" height: 50px; float: left; margin-right: 5px; margin-bottom: 5px;"></a>
				<?php } ?>
			</td>
		<?php }else{ ?>
			<td><?php echo $fields[$key]['name']?>:</td>
			<td><?php echo $form?></td>
		<?php  } ?>
		</tr>
<?php 
	}
}
?>
	</tbody>
</table>

</div>
</body>
</html>