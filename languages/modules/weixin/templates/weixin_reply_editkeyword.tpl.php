<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
</script>

<div class="pad_10">
<form action="?app=weixin&controller=reply&view=editkeyword&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
	<th width="100">关键词：</th>
	<td><input type="text" name="weixin[keyword]" value="<?php echo $infos['keyword'] ?>" id="keyword" size="50" class="input-text">
        
		
        </td>
	</tr>
</table>
<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
</form>

</div>
<div class="col-tab" style="margin-top:10px;">
<ul class="tabBut cu-li">
     <li id="tab_setting_1" class="on" onclick="SwapTab('setting','','',1,1);"><a href="#" >图文列表</a></li>
 
     <li id="tab_setting_1" class="" onclick="SwapTab('setting','on','',1,1);"><a href="?app=weixin&controller=reply&view=addarticle&id=<?php echo $id; ?>" >追加图文</a></li>
          
  
</ul>
<div id="div_setting_1" class="contentList pad-10">
<div class="table-list">
<table width="100%" cellspacing="0" class="table_form">
    <tbody>
    <tr>
           
   <td width="20%" align="center">标题</td>
            <td width="20%" align="center">更新时间</td>
            <td width="20%" align="center">管理操作　</td>	         
  </tr>
    <?php foreach($lists as $k=>$v){?>
  <tr> 
              
  <td width="20%" align="center"><?php if($v['thumb']){echo $v['title'].$thumb; }else{echo $v['title'].$warning;}?></td>      
        <td width="20%" align="center">  <?php echo date("Y-m-d H:i:s",$v['updatetime']) ;?> </td>
        <td width="20%" align="center">
       
   <a href="?app=weixin&controller=reply&view=editarticle&id=<?php echo $v['id']?>&replyid=<?php echo $v['replyid']?>"  title="<?php echo $v['title']?>"><?php echo L('edit')?></a><?php if($v['default'] ==1){ ?> | <span style="color:#999;">删除</span><?php }else{?> | <a href='?app=weixin&controller=reply&view=delarcticle&id=<?php echo $v['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => $v['keyword']))?>')"><?php echo L('delete')?></a>
 <?php }?>	  
   
        </td>  
  </tr>
        <?php }?>
    </tbody>
</table>
</div>
</div>
</div>

</div>
</body>
</html> 