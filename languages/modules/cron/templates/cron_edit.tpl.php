<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#cronname").formValidator({onshow:"任务名称不能为空",onfocus:"任务名称不能为空"}).inputValidator({min:1,max:999,onerror:"任务名称不能为空"});
	$("#crontime").formValidator({onshow:"任务时间不能为空",onfocus:"任务时间不能为空"}).inputValidator({min:1,max:999,onerror:"必须为整数"}).regexValidator({regexp:"^(([1-9]{1}\\d*)|([0]{1}))?$",onerror:"必须为整数"});
});
//-->
</script>

<div class="pad-10">
  <div class="common-form">
    <form name="myform" action="?app=cron&controller=cron&view=edit" method="post" id="myform">
      <fieldset>
      <legend>修改计划任务</legend>
      <div class="bk15"></div>
      <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
        <tr>
          <th width="80"><strong>任务类型</strong></th>
          <td><select name="info[crontype]" style="width:100px;">
              <?php echo utility::option(crontypes(),$croninfo['crontype']);?>
            </select></td>
        </tr>
        <tr>
          <th width="80"><strong>任务参数</strong></th>
          <td><input type="text" name="info[parm]" size="20"  class="input-text" id="parm" value="<?php echo $croninfo['parm']?>">栏目ID,起始页面,终止页面</td>
        </tr>
        <tr>
          <th width="80"><strong>任务名称</strong></th>
          <td><input type="text" name="info[cronname]" size="20"  class="input-text" id="cronname" value="<?php echo $croninfo['cronname']?>"></td>
        </tr>
        <tr>
          <th><strong>终始时间</strong></th>
          <td><?php echo form::date('info[start_time]', $croninfo['start_time'] ? date('Y-m-d H:i:s',$croninfo['start_time']) : '',1)?> - <?php echo form::date('info[end_time]', $croninfo['end_time'] ? date('Y-m-d H:i:s',$croninfo['end_time']) : '',1)?></td>
        </tr>
        
        <tr>
          <th><strong>执行方式</strong></th>
          <td><input type="radio" name="info[mode]" value="0" <?php echo !$croninfo['mode']?'checked':''?>>循环执行<input type="radio" name="info[mode]" value="1" <?php echo $croninfo['mode']?'checked':''?>>仅执行一次</td>
        </tr>
                
        <tr>
          <th><strong>间隔时间</strong></th>
          <td><input type="text"  name="info[crontime]" size="20" class="input-text" id="crontime" value="<?php echo $croninfo['crontime']?>">
            分钟</td>
        </tr>
        <tr>
          <th><strong>任务备注</strong></th>
          <td valign="middle"><textarea name="info[info]" cols="40" rows="5" id="croninfo"><?php echo $croninfo['info']?></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input class="button"  type="submit" value=" 确定 " name="dosubmit">
            <input class="button"  type="hidden" name="cronid" value="<?php echo $croninfo['cronid']?>"></td>
        </tr>
      </table>
    </form>
    </fieldset>
    <div class="bk15"></div>
  </div>
</div>
</body></html>
