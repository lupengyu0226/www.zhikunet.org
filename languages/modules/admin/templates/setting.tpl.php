<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript">
<!--
	$(function(){
		SwapTab('setting','on','',6,<?php echo $_GET['tab'] ? $_GET['tab'] : '1'?>);
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});		
		$("#js_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_js_path')?>",onfocus:"<?php echo L('setting_js_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_js_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_js_path').L('setting_end_with_x')?>"});
		$("#css_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_css_path')?>",onfocus:"<?php echo L('setting_css_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_css_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_css_path').L('setting_end_with_x')?>"});
		
		$("#img_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_img_path')?>",onfocus:"<?php echo L('setting_img_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_img_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_img_path').L('setting_end_with_x')?>"});
		
		$("#passport_path").formValidator({onshow:"<?php echo L('setting_input').L('setting_passport_path')?>",onfocus:"<?php echo L('setting_passport_path').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_passport_path').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_passport_path').L('setting_end_with_x')?>"});
	
		$("#upload_url").formValidator({onshow:"<?php echo L('setting_input').L('setting_upload_url')?>",onfocus:"<?php echo L('setting_upload_url').L('setting_end_with_x')?>"}).inputValidator({onerror:"<?php echo L('setting_upload_url').L('setting_input_error')?>"}).regexValidator({regexp:"(.+)\/$",onerror:"<?php echo L('setting_upload_url').L('setting_end_with_x')?>"});
		
		$("#errorlog_size").formValidator({onshow:"<?php echo L('setting_errorlog_hint')?>",onfocus:"<?php echo L('setting_input').L('setting_error_log_size')?>"}).inputValidator({onerror:"<?php echo L('setting_error_log_size').L('setting_input_error')?>"}).regexValidator({regexp:"num",datatype:"enum",onerror:"<?php echo L('setting_errorlog_type')?>"});	
			
		$("#phpsso_api_url").formValidator({onshow:"<?php echo L('setting_phpsso_type')?>",onfocus:"<?php echo L('setting_phpsso_type')?>",tipcss:{width:'300px'},empty:false}).inputValidator({onerror:"<?php echo L('setting_phpsso_type')?>"}).regexValidator({regexp:"http[s]?:\/\/(.+)[^/]$",onerror:"<?php echo L('setting_phpsso_type')?>"});
		
		$("#phpsso_appid").formValidator({onshow:"<?php echo L('input').L('setting_phpsso_appid')?>",onfocus:"<?php echo L('input').L('setting_phpsso_appid')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('setting_phpsso_appid').L('must_be_number')?>"});
		$("#phpsso_version").formValidator({onshow:"<?php echo L('input').L('setting_phpsso_version')?>",onfocus:"<?php echo L('input').L('setting_phpsso_version')?>"}).regexValidator({regexp:"^\\d{1,8}$",onerror:"<?php echo L('setting_phpsso_version').L('must_be_number')?>"});
		$("#phpsso_auth_key").formValidator({onshow:"<?php echo L('input').L('setting_phpsso_auth_key')?>",onfocus:"<?php echo L('input').L('setting_phpsso_auth_key')?>"}).regexValidator({regexp:"^\\w{32}$",onerror:"<?php echo L('setting_phpsso_auth_key').L('must_be_32_w')?>"});
	})
//-->
</script>
<form action="?app=admin&controller=setting&view=save" method="post" id="myform">
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
            <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',8,1);"><i class="iconfont icon-shezhi"></i> <?php echo L('setting_basic_cfg')?></li>
            <li id="tab_setting_2" onclick="SwapTab('setting','on','',8,2);"><i class="iconfont icon-anquan"></i> <?php echo L('setting_safe_cfg')?></li>
            <li id="tab_setting_3" onclick="SwapTab('setting','on','',8,3);"><i class="iconfont icon-lianjiechenggong"></i> <?php echo L('setting_sso_cfg')?></li>
            <li id="tab_setting_4" onclick="SwapTab('setting','on','',8,4);"><i class="iconfont icon-tubiaozitihua09"></i> <?php echo L('setting_mail_cfg')?></li>
	          <li id="tab_setting_5" onclick="SwapTab('setting','on','',8,5);"><i class="iconfont icon-huiyuan1"></i> <?php echo L('社交登录')?></li>
            <li id="tab_setting_6" onclick="SwapTab('setting','on','',8,6);"><i class="iconfont icon-quanxian"></i> <?php echo L('setting_version')?></li>
            <li id="tab_setting_7" onclick="SwapTab('setting','on','',8,7);"><i class="iconfont icon-tubiaozitihua09"></i> <?php echo L('投稿邮件配置')?></li>
</ul>
<div id="div_setting_1" class="contentList pad-10">
<table width="100%"  class="table_form">
  <tr>
    <th width="120"><?php echo L('setting_admin_email')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[admin_email]" id="admin_email" size="30" value="<?php echo $admin_email?>"/></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_category_ajax')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[category_ajax]" id="category_ajax" size="5" value="<?php echo $category_ajax?>"/>&nbsp;&nbsp;<?php echo L('setting_category_ajax_desc')?></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_gzip')?></th>
    <td class="y-bg">
    <input name="setconfig[gzip]" value="1"  type="radio"  <?php echo ($gzip=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
	<input name="setconfig[gzip]" value="0" type="radio"  <?php echo ($gzip=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?></td>
  </tr> 
  <tr>
    <th width="120"><?php echo L('setting_delpanel')?></th>
    <td class="y-bg">
    <input name="setconfig[delpanel]" value="1"  type="radio"  <?php echo ($delpanel=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
        <input name="setconfig[delpanel]" value="0" type="radio"  <?php echo ($delpanel=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?></td>
  </tr> 
  <tr>
    <th width="120"><?php echo L('setting_attachment_stat')?></th>
    <td class="y-bg">
    <input name="setconfig[attachment_stat]" value="1"  type="radio"  <?php echo ($attachment_stat=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
	<input  name="setconfig[attachment_stat]" value="0" type="radio"  <?php echo ($attachment_stat=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?>&nbsp;&nbsp;<?php echo L('setting_attachment_stat_desc')?></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('节日开关')?></th>
    <td class="y-bg">
    <input name="setconfig[festival_off]" value="1"  type="radio"  <?php echo ($festival_off=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
        <input name="setconfig[festival_off]" value="0" type="radio"  <?php echo ($festival_off=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?></td>
  </tr> 
    <tr>
    <th width="120"><?php echo L('节日素材')?></th>
    <td class="y-bg"><select name="setconfig[festival_url]">
      <?php
      if(is_array($ssi)){
        foreach($ssi as $ssi){
          ?>
      <option value="<?php echo $ssi['tag']?>" <?php echo (($ssi['tag']==FESTIVAL_URL) ? 'selected' : '')?>><?php echo $ssi['name']?></option>
        <?php
        }
      }
      ?>
    </select>
    &nbsp;&nbsp;这里显示的是界面-实时碎片中的节日碎片名称</td>
    </tr>  
    <tr>
  <tr>
    <th width="120"><?php echo L('LOGO路径')?></th>
    <td class="y-bg">
      <input name="setconfig[logo_model]" value="hd"  type="radio"  <?php echo ($logo_model=='hd') ? ' checked' : ''?>> <?php echo L('正常高清')?>&nbsp;&nbsp;
      <input name="setconfig[logo_model]" value="right" type="radio"  <?php echo ($logo_model=='right') ? ' checked' : ''?>> <?php echo L('居右高清')?>
  </td>
  </tr>	
  <tr>
    <th width="120"><?php echo L('setting_js_path')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[js_path]" id="js_path" size="70" value="<?php echo JS_PATH?>" /></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_css_path')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[css_path]" id="css_path" size="70" value="<?php echo CSS_PATH?>"/></td>
  </tr> 
  <tr>
    <th width="120"><?php echo L('setting_img_path')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[img_path]" id="img_path" size="70" value="<?php echo IMG_PATH?>" /></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_passport_path')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[passport_path]" id="passport_path" size="70" value="<?php echo PASSPORT_PATH?>" /></td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_upload_url')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[upload_url]" id="upload_url" size="70" value="<?php echo $upload_url?>" /></td>
  </tr>
</table>
</div>
<div id="div_setting_2" class="contentList pad-10 hidden">
	<table width="100%"  class="table_form">
  <tr>
    <th width="120"><?php echo L('setting_admin_log')?></th>
    <td class="y-bg">
	  <input name="setconfig[admin_log]" value="1" type="radio" <?php echo ($admin_log=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
	  <input name="setconfig[admin_log]" value="0" type="radio" <?php echo ($admin_log=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?>
     </td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_error_log')?></th>
    <td class="y-bg">
	  <input name="setconfig[errorlog]" value="1" type="radio" <?php echo ($errorlog=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
	  <input name="setconfig[errorlog]" value="0" type="radio" <?php echo ($errorlog=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?>
     </td>
  </tr> 
  <tr>
    <th width="120"><?php echo L('setting_debug')?></th>
    <td class="y-bg">
    <input name="setconfig[debug]" value="1" type="radio" <?php echo ($debug=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
    <input name="setconfig[debug]" value="0" type="radio" <?php echo ($debug=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?>
     </td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_safe_off')?></th>
    <td class="y-bg">
    <input name="setconfig[safe_off]" value="1" type="radio" <?php echo ($safe_off=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
    <input name="setconfig[safe_off]" value="0" type="radio" <?php echo ($safe_off=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?>
     </td>
  </tr>
  <tr>
    <th width="120"><?php echo L('setting_safe_model')?></th>
    <td class="y-bg">
      <select name="setconfig[safe_model]" id="">
    <option value="<?php echo $safe_model?>" <?php if($safe_model=='<?php echo $safe_model;?>'){echo "selected";}?>><?php echo $safe_model;?></option>
        <option value="普通模式" >普通模式</option>
        <option value="安全模式" >安全模式</option>
        <option value="和平模式" >和平模式</option>
        <option value="狩猎模式" >狩猎模式</option>
        <option value="战争模式" >战争模式</option>
    </select>
     </td>
  </tr>
  <tr>
    <th><?php echo L('setting_error_log_size')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[errorlog_size]" id="errorlog_size" size="5" value="<?php echo $errorlog_size?>"/> MB</td>
  </tr>     

  <tr>
    <th><?php echo L('setting_maxloginfailedtimes')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[maxloginfailedtimes]" id="maxloginfailedtimes" size="10" value="<?php echo $maxloginfailedtimes?>"/></td>
  </tr>

  <tr>
    <th><?php echo L('setting_minrefreshtime')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[minrefreshtime]" id="minrefreshtime" size="10" value="<?php echo $minrefreshtime?>"/> <?php echo L('miao')?></td>
  </tr>
  <tr>
    <th><?php echo L('admin_url')?></th>
    <td class="y-bg"><TABLE>
    <TR>
		<TD width="270"><?php echo SITE_PROTOCOL;?><input type="text" class="input-text" name="setconfig[admin_url]" id="admin_url" size="30" value="<?php echo $admin_url?>"/> </TD>
		<TD><?php echo L('admin_url_tips')?></TD>
    </TR>
    </TABLE> </td>
  </tr> 
</table>
</div>
<div id="div_setting_3" class="contentList pad-10 hidden">
<table width="100%"  class="table_form">
  <tr>
    <th width="120"><?php echo L('setting_phpsso')?></th>
    <td class="y-bg">
    <input name="setconfig[phpsso]" value="1" type="radio"  <?php echo ($phpsso=='1') ? ' checked' : ''?>> <?php echo L('setting_yes')?>&nbsp;&nbsp;
	 <input name="setconfig[phpsso]" value="0" type="radio"  <?php echo ($phpsso=='0') ? ' checked' : ''?>> <?php echo L('setting_no')?></td>
  </tr> 
  <tr>
    <th><?php echo L('setting_phpsso_appid')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[phpsso_appid]" id="phpsso_appid" size="30" value="<?php echo $phpsso_appid ?>"/></td>
  </tr> 
  <tr>
    <th><?php echo L('setting_phpsso_phpsso_api_url')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[phpsso_api_url]" id="phpsso_api_url" size="50" value="<?php echo $phpsso_api_url ?>"/></td>
  </tr>  
   <tr>
    <th><?php echo L('setting_phpsso_auth_key')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[phpsso_auth_key]" id="phpsso_auth_key" size="50" value="<?php echo $phpsso_auth_key ?>"/></td>
  </tr>
   <tr>
    <th><?php echo L('setting_phpsso_version')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setconfig[phpsso_version]" id="phpsso_version" size="2" value="<?php echo $phpsso_version ?>"/></td>
  </tr>      
  </table>
</div>
<div id="div_setting_4" class="contentList pad-10 hidden">
<table width="100%"  class="table_form">
  <tr>
    <th width="120"><?php echo L('mail_type')?></th>
    <td class="y-bg">
     <input name="setting[mail_type]" checkbox="mail_type" value="1" onclick="showsmtp(this)" type="radio" <?php echo $mail_type==1 ? ' checked' : ''?>> <?php echo L('mail_type_smtp')?>
    <input name="setting[mail_type]" checkbox="mail_type" value="0" onclick="showsmtp(this)" type="radio" <?php echo $mail_type==0 ? ' checked' : ''?> <?php if(substr(strtolower(PHP_OS), 0, 3) == 'win') echo 'disabled'; ?>/> <?php echo L('mail_type_mail')?> 
	</td>
  </tr>
  <tbody id="smtpcfg" style="<?php if($mail_type == 0) echo 'display:none'?>">
  <tr>
    <th><?php echo L('mail_server')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[mail_server]" id="mail_server" size="30" value="<?php echo $mail_server?>"/></td>
  </tr>  
  <tr>
    <th><?php echo L('mail_port')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[mail_port]" id="mail_port" size="30" value="<?php echo $mail_port?>"/></td>
  </tr> 
  <tr>
    <th><?php echo L('mail_from')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="setting[mail_from]" id="mail_from" size="30" value="<?php echo $mail_from?>"/></td>
  </tr>   
  <tr>
    <th><?php echo L('mail_auth')?></th>
    <td class="y-bg">
    <input name="setting[mail_auth]" checkbox="mail_auth" value="1" type="radio" <?php echo $mail_auth==1 ? ' checked' : ''?>> <?php echo L('mail_auth_open')?>
	<input name="setting[mail_auth]" checkbox="mail_auth" value="0" type="radio" <?php echo $mail_auth==0 ? ' checked' : ''?>> <?php echo L('mail_auth_close')?></td>
  </tr> 

	  <tr>
	    <th><?php echo L('mail_user')?></th>
	    <td class="y-bg"><input type="text" class="input-text" name="setting[mail_user]" id="mail_user" size="30" value="<?php echo $mail_user?>"/></td>
	  </tr> 
	  <tr>
	    <th><?php echo L('mail_password')?></th>
	    <td class="y-bg"><input type="password" class="input-text" name="setting[mail_password]" id="mail_password" size="30" value="<?php echo $mail_password?>"/></td>
	  </tr>

 </tbody>
  <tr>
    <th><?php echo L('mail_test')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="mail_to" id="mail_to" size="30" value=""/> <input type="button" class="button" onClick="javascript:test_mail();" value="<?php echo L('mail_test_send')?>"></td>
  </tr>           
  </table>
</div>
<div id="div_setting_5" class="contentList pad-10 hidden">
<table width="100%"  class="table_form">
  <tr>
    <th><?php echo L('setting_connect_sina')?></th>
    <td class="y-bg">
	App key <input type="text" class="input-text" name="setconfig[sina_akey]" id="sina_akey" size="20" value="<?php echo $sina_akey ?>"/>
	App secret key <input type="text" class="input-text" name="setconfig[sina_skey]" id="sina_skey" size="40" value="<?php echo $sina_skey ?>"/> <a href="http://open.t.sina.com.cn/wiki/index.php/<?php echo L('connect_micro')?>" target="_blank"><?php echo L('click_register')?></a>
	</td>
  </tr>
  <tr>
    <th><?php echo L('setting_connect_qqnew')?></th>
    <td class="y-bg">
	App I D  &nbsp;<input type="text" class="input-text" name="setconfig[qq_appid]" id="qq_appid" size="20" value="<?php echo $qq_appid;?>"/>
  App secret key <input type="text" class="input-text" name="setconfig[qq_appkey]" id="qq_appkey" size="40" value="<?php echo $qq_appkey;?>"/> 
	<?php echo L('setting_connect_qqcallback')?> <input type="text" class="input-text" name="setconfig[qq_callback]" id="qq_callback" size="40" value="<?php echo $qq_callback;?>"/>
  <?php echo L('手机QQ回调地址')?> <input type="text" class="input-text" name="setconfig[wap_qq_callback]" id="wap_qq_callback" size="40" value="<?php echo $wap_qq_callback;?>"/>
	<a href="http://connect.qq.com" target="_blank"><?php echo L('click_register')?></a>
	</td>
  </tr> 
  <tr>
    <th>百度帐号登录</th>
    <td class="y-bg">
  ClientId  &nbsp;<input type="text" class="input-text" name="setconfig[xzh_appid]" id="xzh_appid" size="20" value="<?php echo $xzh_appid;?>"/>
  ClientSecret <input type="text" class="input-text" name="setconfig[xzh_appkey]" id="xzh_appkey" size="40" value="<?php echo $xzh_appkey;?>"/> 
  <?php echo L('setting_connect_qqcallback')?> <input type="text" class="input-text" name="setconfig[xzh_callback]" id="xzh_callback" size="40" value="<?php echo $xzh_callback;?>"/>
  手机QQ回调地址 <input type="text" class="input-text" name="setconfig[wap_xzh_callback]" id="wap_xzh_callback" size="40" value="<?php echo $wap_xzh_callback;?>"/>
  </td>
  </tr> 
  <tr>
    <th>微信授权登录</th>
    <td class="y-bg">
  App I D  &nbsp;<input type="text" class="input-text" name="setconfig[wx_appid]" id="wx_appid" size="20" value="<?php echo $wx_appid;?>"/>
  App secret key <input type="text" class="input-text" name="setconfig[wx_appkey]" id="wx_appkey" size="40" value="<?php echo $wx_appkey;?>"/> 
  <?php echo L('setting_connect_qqcallback')?> <input type="text" class="input-text" name="setconfig[wx_callback]" id="wx_callback" size="40" value="<?php echo $wx_callback;?>"/>
  </td>
  </tr> 
  </table>
</div>
<div id="div_setting_6" class="contentList pad-10 hidden">
<table width="100%"  class="table_form">
  <tr>
    <th width="120">系统版本</th>
    <td class="y-bg">
  <input type="text" class="input-text" name="setversion[shy_version]" id="shy_version" size="20" value="<?php echo $shy_version ?>"/> 格式：1.0.0.1
  </td>
  </tr>
  <tr>
    <th width="120">系统发行日期</th>
    <td class="y-bg">
  <input type="text" class="input-text" name="setversion[shy_release]" id="shy_release" size="20" value="<?php echo $shy_release ?>"/> 日期格式：20140501
  </td>
  </tr>
  <tr>
    <th width="120"><?php echo L('js_version')?></th>
    <td class="y-bg">
	<input type="text" class="input-text" name="setversion[js_version]" id="js_version" size="20" value="<?php echo $js_version ?>"/> 日期格式：20140501
	</td>
  </tr>
  <tr>
    <th><?php echo L('css_version')?></th>
    <td class="y-bg">
	<input type="text" class="input-text" name="setversion[css_version]" id="css_version" size="20" value="<?php echo $css_version ?>"/> 日期格式：20140501
	</td>
  </tr>
  <tr>
    <th><?php echo L('pagecount_cron')?></th>
    <td class="y-bg">
  <input type="text" class="input-text" name="setversion[pagecount_cron]" id="pagecount_cron" size="20" value="<?php echo $pagecount_cron ?>"/> 格式：20
  </td>
  </tr>
  </table>
</div>
<div id="div_setting_7" class="contentList pad-10 hidden">
<table width="100%"  class="table_form">
  <tr>
    <th width="120"><?php echo L('mail_type')?></th>
    <td class="y-bg">
     <input name="savetougao[tmail_type]" checkbox="tmail_type" value="1" onclick="showsmtp(this)" type="radio" <?php echo $tougao['tmail_type']==1 ? ' checked' : ''?>> <?php echo L('mail_type_smtp')?>
    <input name="savetougao[tmail_type]" checkbox="tmail_type" value="0" onclick="showsmtp(this)" type="radio" <?php echo $tougao['tmail_type']==0 ? ' checked' : ''?> <?php if(substr(strtolower(PHP_OS), 0, 3) == 'win') echo 'disabled'; ?>/> <?php echo L('mail_type_mail')?> 
  </td>
  </tr>
  <tbody id="smtpcfg" style="<?php if($tougao['tmail_type'] == 0) echo 'display:none'?>">
  <tr>
    <th><?php echo L('mail_server')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="savetougao[tmail_server]" id="tmail_server" size="30" value="<?php echo $tougao['tmail_server']?>"/></td>
  </tr>  
  <tr>
    <th><?php echo L('mail_port')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="savetougao[tmail_port]" id="tmail_port" size="30" value="<?php echo $tougao['tmail_port']?>"/></td>
  </tr> 
  <tr>
    <th><?php echo L('mail_from')?></th>
    <td class="y-bg"><input type="text" class="input-text" name="savetougao[tmail_from]" id="tmail_from" size="30" value="<?php echo $tougao['tmail_from']?>"/></td>
  </tr>   
  <tr>
    <th><?php echo L('mail_auth')?></th>
    <td class="y-bg">
    <input name="savetougao[tmail_auth]" checkbox="tmail_auth" value="1" type="radio" <?php echo $tougao['tmail_auth']==1 ? ' checked' : ''?>> <?php echo L('mail_auth_open')?>
  <input name="savetougao[tmail_auth]" checkbox="tmail_auth" value="0" type="radio" <?php echo $tougao['tmail_auth']==0 ? ' checked' : ''?>> <?php echo L('mail_auth_close')?></td>
  </tr> 

    <tr>
      <th><?php echo L('mail_user')?></th>
      <td class="y-bg"><input type="text" class="input-text" name="savetougao[tmail_user]" id="tmail_user" size="30" value="<?php echo $tougao['tmail_user']?>"/></td>
    </tr> 
    <tr>
      <th><?php echo L('mail_password')?></th>
      <td class="y-bg"><input type="password" class="input-text" name="savetougao[tmail_password]" id="tmail_password" size="30" value="<?php echo $tougao['tmail_password']?>"/></td>
    </tr>
 </tbody>      
  </table>
</div>
<div class="bk15"></div>
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</div>
</div>
</form>
</body>
<script type="text/javascript">

function SwapTab(name,cls_show,cls_hide,cnt,cur){
    for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}

function showsmtp(obj,hiddenid){
	hiddenid = hiddenid ? hiddenid : 'smtpcfg';
	var status = $(obj).val();
	if(status == 1) $("#"+hiddenid).show();
	else  $("#"+hiddenid).hide();
}
function test_mail() {
	var mail_type = $('input[checkbox=mail_type][checked]').val();
	var mail_auth = $('input[checkbox=mail_auth][checked]').val();
    $.post('?app=admin&controller=setting&view=public_test_mail&mail_to='+$('#mail_to').val(),{mail_type:mail_type,mail_server:$('#mail_server').val(),mail_port:$('#mail_port').val(),mail_user:$('#mail_user').val(),mail_password:$('#mail_password').val(),mail_auth:mail_auth,mail_from:$('#mail_from').val()}, function(data){
	alert(data);
	});
}

</script>
</html>
