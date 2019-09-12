<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
	<form name="myform" id="myform" action="?app=book&controller=book&view=check" method="post" >
    <div class="table-list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
		    <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
            <th align="center">ID</th>
			<th align="center"><?php echo L('title');?></th>
			<th align="center"><?php echo L('username');?></th>
            <th align="center">E-mail</th>
            <th align="center"><?php echo L('mobile');?></th>
            <th align="center"><?php echo L('addtime');?></th>
            <th width="12%" align="center"><?php echo L('operation');?></th>
          </tr>
        </thead>
        <tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
          <tr>
		    <td align="center" width="35"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
			<td align="center"><?php echo $info['id']?></td>
            <td align="left"><a href="?app=book&controller=index&view=show&id=<?php echo $info['id'];?>" style="color:#004499" target="_blank"><?php echo str_cut($info['title'] ,'50');?></a></td>
            <td align="center"><?php echo $info['username']?></td>
            <td align="center" style="color:#004499"><?php echo $info['email'];?></td>
            <td align="center"><?php echo $info['mobile'];?></td>
            <td align="center"><?php echo date('Y-m-d H:i:s',$info['addtime']);?></td>
			<td align="center" width="12%"><a class="xbtn btn-info btn-xs" href="?app=book&controller=book&view=check&id=<?php echo $info['id']?>"
			onClick="return confirm('<?php echo L('certain_pass');?>')"><?php echo L('pass');?></a> 
			<a class="xbtn btn-danger btn-xs" href='?app=book&controller=book&view=delete&id=<?php echo $info['id']?>'
			onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes($info['title'])))?>')"><?php echo L('delete')?></a></td>
          </tr>
          <?php
	}
}
?>
        </tbody>
      </table>
    </div>
    <div class="btn">
	<label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
	&nbsp;&nbsp;
	<input name="dosubmit" type="submit" class="button" value="<?php echo L('pass');?>" onClick="document.myform.action='?m=book&c=book&a=check'">
	&nbsp;&nbsp;
 	<input type="submit" class="button" name="submit" onclick="document.myform.action='?app=book&controller=book&view=delete_all';return confirm('<?php echo L('confirm_delete');?>')" value="<?php echo L('delete')?>"/>
      &nbsp;&nbsp;
    </div>
    <div id="pages"><?php echo $pages?></div>
  </form>
</div>
</body>
</html>
