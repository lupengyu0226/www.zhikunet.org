<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<script type="text/javascript">
</script>
<style type="text/css">
dd.box{float:left; width:30%;margin:5px;}
</style>


<div class="pad_10">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col"> 
		提示：添加多个关键词，请用空格隔开。
		</div>
		</td>
		</tr>
    </tbody>
</table>
<form action="?app=weixin&controller=reply&view=edittext&id=<?php echo $id; ?>" method="post" name="myform" id="myform">

    <table cellpadding="2" cellspacing="1" class="table_form" width="100%">
  
      <tr>
		<th width="100">关键词：</th>
		<td><input type="text" name="weixin[keyword]" id="keyword" size="50" value="<?php echo $infos['keyword']?>" class="input-text"></td>
	</tr>
      <tr>
      <th width="100">内容：</th>
		<td align="left" >
        <textarea name="weixin[content]" cols="80" rows="20" style="margin-top:20px;"><?php echo $infos['content']?></textarea>
		</td>
        </tr>
    </table>
    </table>
    <input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
    </form>

</div>
</body>
</html> 