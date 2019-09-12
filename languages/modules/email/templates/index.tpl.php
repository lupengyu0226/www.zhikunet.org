<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script language="javascript" type="text/javascript" src="//statics.05273.cn/statics/js/formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="//statics.05273.cn/statics/js/formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#ids").formValidator({onshow:"请输入邮箱",onfocus:"邮箱格式错误",oncorrect:"邮箱格式正确"}).inputValidator({min:7,max:32,onerror:"邮箱应该为7-32位之间"}).regexValidator({regexp:"email",datatype:"enum",onerror:"邮箱格式错误"});
	$("#title").formValidator({onshow:"请输入邮件标题",onfocus:"标题不能为空。"}).inputValidator({min:1,max:999,onerror:"标题不能为空。"});
	$("#code").formValidator({onshow:"请输入验证码",onfocus:"验证码不能为空。"}).inputValidator({min:1,max:4,onerror:"验证码不能为空。"});
})
//-->
</script>
<div class="pad-10">
<form method="post" action="?app=email&controller=email&view=emails" name="myform" id="myform">
<table class="table_form" width="100%" cellspacing="0">
<tbody>
<tr>
  <th width="80"><strong>接收人</strong></th>
  <td><input name="emails[ids]" id="ids" class="input-text" type="text" size="50" ></td>
</tr>
<tr>
  <th width="80"><strong>邮件标题</strong></th>
  <td><input name="emails[title]" id="title" class="input-text" value="您好，您的来稿已发布!" type="text" size="50" ></td>
</tr>
<tr>
  <th><strong>内容</strong></th>
  <td><textarea name="emails[content]" id="content">您好，您的来稿已发布，链接为：</textarea><?php echo form::editor('content');?></td>
</tr>
<tr>
  <th><strong>评级</strong></th>
  <td><select name="emails[star]">
            <option value="" selected>请选择</option>
              <option value="您投稿的内容被系统评级为 《一星级》建议后续提高稿件文字数量并加以配图！" >一星级</option>
              <option value="您投稿的内容被系统评级为 《二星级》建议后续提高稿件文字数量并加以配图！" >二星级</option>
              <option value="您投稿的内容被系统评级为 《三星级》建议后续加以配图！" >三星级</option>
              <option value="您投稿的内容被系统评级为 《四星级》建议后续加以配图！" >四星级</option>
              <option value="您投稿的内容被系统评级为 《五星级》请努力保持！" >五星级</option>
            </select>
</td>
</tr>
<tr>
  <th><strong>验证码</strong></th>
  <td><input id="code" name=code class="input-text" size="8"/><?php echo form::checkcode('code_img')?></td>
</tr>
</tbody>
</table>
<div class="bk15"></div>
<input name="dosubmit" type="submit" value="提交" class="button">
</div>
</form>
</div>
</body>
</html>
