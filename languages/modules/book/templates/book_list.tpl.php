<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="explain-col search-form">
<a href="?app=book&controller=book"><?php echo L('all');?></a>&nbsp;&nbsp;&nbsp;
<a href="?app=book&controller=book&open=1"><?php echo L('open');?></a>&nbsp;&nbsp;&nbsp;
<a href="?app=book&controller=book&open=99"><?php echo L('not_open');?></a>
</div>
	<form name="myform" id="myform" action="" method="post" >
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
	foreach($infos as $k=>$info){
		$reply = $info['reply'];
		?>
          <tr>
		    <td align="center" width="35"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
			<td align="center"><?php echo $info['id']?></td>
			<td align="left"><a href="?app=book&controller=index&view=show&id=<?php echo $info['id'];?>" style="color:#004499" target="_blank"><?php echo str_cut($info['title'] ,'50');?></a></td>
            <td align="center"><?php echo $info['username']?></td>
            <td align="center" style="color:#004499"><?php echo $info['email'];?></td>
            <td align="center"><?php echo $info['mobile'];?></td>
            <td align="center"><?php echo date('Y-m-d H:i:s',$info['addtime']);?></td>
			<td align="center" width="12%"><a href="?app=book&controller=book&view=reply&id=<?php echo $info['id']?>&menuid=<?php echo $_GET['menuid'];?>">
			<?php if($reply =='') {echo L('<font class="xbtn btn-warning btn-xs">未回复</font>');}else{echo L('<font class="xbtn btn-info btn-xs">已回复</font>');}?></a>  
			<a class="xbtn btn-danger btn-xs" href='?app=book&controller=book&view=delete&id=<?php echo $info['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes($info['title'])))?>')"><?php echo L('delete')?></a></td>
          </tr>
          <?php
	}
}
?>
        </tbody>
      </table>
    </div>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
      &nbsp;&nbsp;
      <input type="submit" class="button" name="submit" onClick="document.myform.action='?app=book&controller=book&view=delete_all';return confirm('<?php echo L('confirm_delete');?>')" value="<?php echo L('delete')?>"/>
    </div>
  </form>
  <div id="pages" class="text-c"><?php echo $pages;?></div>
</div>
</body></html>
