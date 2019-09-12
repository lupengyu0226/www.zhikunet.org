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
	$("#cronname").formValidator({onshow:"<?php echo L('cron_no_1')?>",onfocus:"<?php echo L('cron_no_2')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('cron_no_3')?>"});
	$("#crontime").formValidator({onshow:"<?php echo L('start_time_no_1')?>",onfocus:"<?php echo L('start_time_no_2')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('time_no_1')?>"}).regexValidator({regexp:"^(([1-9]{1}\\d*)|([0]{1}))?$",onerror:"<?php echo L('time_no_1')?>"});
	$("input[name='info[start_time]']").formValidator({onshow:"<?php echo L('start_time')?>",onfocus:"<?php echo L('start_time')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('time_no_2')?>"}).regexValidator({regexp:date,onerror:"<?php echo L('time_no_2')?>"});
	$("input[name='info[end_time]']").formValidator({onshow:"<?php echo L('end_time')?>",onfocus:"<?php echo L('end_time')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('time_no_2')?>"}).regexValidator({regexp:date,onerror:"<?php echo L('time_no_2')?>"});
			
});
//-->
</script>

<div class="pad-10">
  <div class="common-form">
    <form name="myform" action="?app=cron&controller=cron&view=add" method="post" id="myform">
      <fieldset>
      <legend><?php echo L('addcron')?></legend>
      <div class="bk15"></div>
      <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
        <tr>
          <th width="80"><strong><?php echo L('crontype')?></strong></th>
          <td><select name="info[crontype]" style="width:100px;">
              <?php echo utility::option(crontypes());?>
            </select></td>
        </tr>
        <tr>
          <th width="80"><strong><?php echo L('parm')?></strong></th>
          <td><input type="text" name="info[parm]" size="20"  class="input-text" id="parm" value=""></td>
        </tr>
        <tr>
          <th width="80"><strong><?php echo L('cronname')?></strong></th>
          <td><input type="text" name="info[cronname]" size="20"  class="input-text" id="cronname"></td>
        </tr>
        <tr>
          <th><strong><?php echo L('startendtime')?></strong></th>
          <td><?php echo form::date('info[start_time]','',1)?> - <?php echo form::date('info[end_time]','',1)?></td>
        </tr>

        <tr>
          <th><strong><?php echo L('mode')?></strong></th>
          <td><input type="radio" name="info[mode]" value="0" checked><?php echo L('xunhuan')?><input type="radio" name="info[mode]" value="1"><?php echo L('yici')?></td>
        </tr>
        
        <tr>
          <th><strong><?php echo L('crontime')?></strong></th>
          <td><input  type="text" name="info[crontime]" size="20" class="input-text" id="crontime"></td>
        </tr>
        <tr>
          <th><strong><?php echo L('info')?></strong></th>
          <td valign="middle"><textarea name="info[info]" cols="40" rows="5" id="croninfo"></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit"  class="button"  value="<?php echo L('ok')?>" name="dosubmit">
            <input type="reset"  class="button"  value="<?php echo L('clear')?>" name="reset"></td>
        </tr>
      </table>
    </form>
    </fieldset>
    <div class="bk15"></div>
  </div>
</div>
</body></html>
