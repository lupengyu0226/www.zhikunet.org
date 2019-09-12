<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<?php include template("content","header_top"); ?>
<?php include template("content","header_logo"); ?>
<?php include template("content","header_nav"); ?>
<!--正文start-->
<div class="layout screen">
	<!--热门推荐start-->
	<div class="Hme_top"><span>热门推荐：</span>
	<?php include_ssi("/caches/posid/1.html"); ?>
	<!--<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=96e7e73f6a515db89036974a6318bf60&action=position&posid=1&order=id+DESC&num=12&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('posid'=>'1','order'=>'id DESC',)).'96e7e73f6a515db89036974a6318bf60');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'1','order'=>'id DESC','limit'=>'12',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
		<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
		<a  target="_blank" href="<?php echo $r['url'];?>">{$r{title}}</a>
		<?php $n++;}unset($n); ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>-->
	</div>
	<!--院校地区推荐start-->
	<div class="inRec">
		
         <p><b><a href="<?php echo $CATEGORYS['3849']['url'];?>">地区</a></b><span>
		 <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=083e65011b008001373ab5a5afb070dd&action=category&catid=3849&num=21&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'3849','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'21',));}?>
		 <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
		 <a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a>
			<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</span></p>
         <p><b><a href="<?php echo $CATEGORYS['3640']['url'];?>">专业</a></b><span>
			<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=a262c893a226bc2a21e7123b78cc9885&action=category&catid=3640&num=20&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'3640','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'20',));}?>
		 <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
		 <a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a>
			<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?></span></p>
         <p><b><a href="<?php echo $CATEGORYS['6']['url'];?>">院校</a></b><span>
		 <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=ceeb6f532a74a845bd1347c9603b3789&action=category&catid=6&num=20&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'6','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'20',));}?>
		 <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
		 <a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a>
			<?php $n++;}unset($n); ?>
			<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?></span></p>                                 
	</div>
	<div class="first-section">
		<!--图片轮播 start-->
	   <div class="mod-slider">
            <div class="eye">
                    <a href="javascript:void(0);" class="eye_lbtn" title="上一页"></a>
                    <a href="javascript:void(0);" class="eye_rbtn" title="下一页"></a>
                    <ul class="eye_img" id="eye_img">
						<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d317cc40bd4774285df113a115ca3146&action=position&posid=2&order=id+DESC&num=5&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('posid'=>'2','order'=>'id DESC',)).'d317cc40bd4774285df113a115ca3146');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'2','order'=>'id DESC','limit'=>'5',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
							<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
						<li><a class="seahotid" href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"></a></li>
						<?php $n++;}unset($n); ?>
						<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ul>
                    <ul class="eye_pag" id="eye_pag">
                       
                       <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d317cc40bd4774285df113a115ca3146&action=position&posid=2&order=id+DESC&num=5&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('posid'=>'2','order'=>'id DESC',)).'d317cc40bd4774285df113a115ca3146');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'2','order'=>'id DESC','limit'=>'5',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
							<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                        <li class="<?php if($n ==1) { ?>current <?php } ?>"></li>
                        <?php $n++;}unset($n); ?>
						<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                        
                    </ul>				
                    <div class="eye_tit" id="eye_tit">
						<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d317cc40bd4774285df113a115ca3146&action=position&posid=2&order=id+DESC&num=5&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('posid'=>'2','order'=>'id DESC',)).'d317cc40bd4774285df113a115ca3146');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'2','order'=>'id DESC','limit'=>'5',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
						<?php $j =1?>
							<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
						<a class="seahotid" href="<?php echo $r['url'];?>" target="_blank" style="<?php if($j == 1) { ?>display: block;<?php } ?>"><p class="name"><?php echo $r['title'];?></p><p><span>学费： 71.2元</span><span>学制：2.5年</span></p><span class="btn">立即查看</span></a>
						<?php $j++; ?>
							<?php $n++;}unset($n); ?>
						<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>						                        
                    </div>
                </div>
		</div>
		<!--图片轮播 end-->
	</div>
	
	<div class="mid-section">
		<div class="mid-content">
			<!--提问 start-->            
			<div class="mod-smartask" >
				<form id="form-smartask" name="frm" action="<?php echo APP_PATH;?>index.php" method="get" target="ask_question">
					
					<fieldset>
						
						<div class="smartask-inputwarp">
							<input type="hidden" name="m" value="search"/>
				<input type="hidden" name="c" value="index"/>
				<input type="hidden" name="a" value="init"/>
				<input type="hidden" name="typeid" value="<?php echo $typeid;?>" id="typeid"/>
				<input type="hidden" name="siteid" value="<?php echo $siteid;?>" id="siteid"/>
				<!--input type="text" class="text" id="q"/-->
							<textarea id="smartask-input"  name="q" class="smartask-input input-tips" type="text" maxlength="50" placeholder="输入您的问题，尽量详细，以便得到更详细更专业的解答。"></textarea>
						</div>
						<div class="smartask-bar fd-clr">
							<!--ol class="baike-statistics">
								<li><span>已解决问题：</span>15112200</li>
								<li><span>待解决问题：</span>740467</li>
							</ol-->
							<div class="btnwrap">
								<button class="smartask-submit" type="submit" id="ask-question" onmousedown="aliclick(this,'?tracelog=baike_asl_ny02')">提问题</button>
								<button class="smartask-submit" type="submit id="find-answer">找答案</button>
								<div id="smartask-count" class="smartask-countwrap"><span class="count">0</span>/50</div>
							</div>
						</div>
					</fieldset>
				</form>	
			</div>
            <!--提问 end-->

			<!--头条新闻 start-->
            
            <div class="mod-hot-news">
				<ol> 
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=dc75bceb915f2f5bf48c8f463161c5b7&action=position&posid=5&order=listorder+DESC&num=2\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'5','order'=>'listorder DESC','limit'=>'2',));}?>
					<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
					<li class="item <?php if($n==1) { ?>item-fixed <?php } ?>">
						<a href="<?php echo $r['url'];?>" class="title"><?php echo $r['title'];?></a>
					<span class="desc"><?php echo $r['keywords'];?></span><a href="<?php echo $r['url'];?>" 
					class="more">[阅读原文]</a>  
					</li>
					<?php $n++;}unset($n); ?>  
					<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
					
				</ol>
					
			<div class="news-list fd-clr">
				<ol>
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=412f43686f3431ff5098a2338f776a19&action=position&posid=5&order=listorder+DESC&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'5','order'=>'listorder DESC','limit'=>'6',));}?>
					<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
					<?php if($n > 2) { ?>
					<li >
					<a href="<?php echo $r['url'];?>"  target="_blank"><?php echo $r['title'];?></a>
					</li>
					<?php } ?>
					<?php $n++;}unset($n); ?>  
					<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
					
				</ol>

			</div>
				</div>
            <!--头条新闻 end-->
		</div>
	</div>
	
	<div class="last-section">
    	<!--用户信息 start-->        
        <div class="mod-userinfo">
			<div class="un-login">
				<h3>欢迎来到智库网！</h3>
				<p class="welcome-word">亲，请关注在职研微厅<br>微信公众号，随时随地<br>了解更多在职研究生<br>招生资讯！</p>
					<img src="<?php echo CSS_PATH;?>2019style/images/weixin_1671707078.jpg"/>
				<div class="login-area fd-clr">
					<a href="#" class="login">登录</a>
					<a href="#" class="reg" rel="nofollow">免费注册</a>
				</div>
			</div>
        </div>
        <!--用户信息 end-->	
		<style>
		.u-member-inner {
			width: 248px;
			height: 160px;
			margin:0;
			padding: 9px 10px;
			font-size: 12px;
			color: #222;
			border: 1px solid #e1e1e1;
			background: #fff;
		}
		</style>
		<div class="u-member">
            <div class="u-member-inner">
                <!-- 呼叫组件 -->
                <div class="ic-model ic-incall" >
                    <form class="c-incall" method="post" action="<?php echo APP_PATH;?>index.php?m=formguide&c=index&a=show&formid=59&siteid=1"<?php if($no_allowed) { ?> target="member_login"<?php } ?> name="myform" id="myform">
                        <div class="ic-field ic-field-telphone">
                            <input type="text" name="info[phone]" id="phone" class="ic-empty" placeholder="请输入您的固定电话/手机" maxLength="17" value="">
                        </div>
                        <div class="ic-field ic-field-code">
                            <input type="text" name="info[name]" id="name" class="ic-code ic-empty" placeholder="输入姓名" maxLength="4">
                            
                            
                        </div>
                        <div class="ic-back-field">
                        	
	                        <div class="ic-callback">
	                            <span class="ic-gray">预约智库小研君咨询报考条件(我们会立即回拨给您)</span>
	                            
	                        </div>
	                        <button type="submit"  name="dosubmit" id="dosubmit" class="ic-btn" >免费咨询</button>
                        </div>
                    </form>
                </div>
                <!-- 按钮链接 -->
                <div class="ic-model ic-button">
                    <a href="https://bbs.zhikunet.org/register.html"  target="_blank">加入在职研友圈</a>
                </div>

            </div>
        </div>

         </div>
            </div>
        </div>


	</div>

</div>
<!-----在职博士项目模块----->
<div class="main">
<div class="main-wrap clearfix mt20">
	<div class="main-hd">
		<h3>同等学力申博</h3>
		<ul class="tab-soft">
						
		</ul>
        <a class="more fr" href="<?php echo $CATEGORYS['3830']['url'];?>" target="_blank">更多&gt;</a>
    </div>
            <div class="wrap-left fl">
			<div class="sytj mt20">
                    <div class="wrap-hd"><h4>申博条件</h4><a class="more" href="<?php echo $CATEGORYS['1']['url'];?>" target="_blank">更多&gt;</a></div>
                    <ul class="textList appHover">
					
					 <li><div class="div_tit2">报名条件</div><span>：本科有学位，毕业满5年</span></li>
					  <li><div class="div_tit2">适合人群</div><span>：社会在职人员及应届毕业生</span></li>
					  <li><div class="div_tit2">入学方式</div><span>：免试入学</span></li>
					  <li><div class="div_tit2">所获证书</div><span>：硕士学位证书</span></li>
					  <li><div class="div_tit2">学习时间</div><span>：2年</span></li>
					  <li><div class="div_tit2">学习费用</div><span>：2万-5万</span></li>
					  <li><div class="div_tit2">上课方式</div><span>：周末班、集中班、网络班</span></li>
					  <li><div class="div_tit2">报名时间</div><span>：详见招生简章</span></li>
                    </ul>
                </div>

                <div class="sytj mt20">
                    <div class="wrap-hd"><h4>考博辅导</h4><a class="more" href="<?php echo $CATEGORYS['1']['url'];?>" target="_blank">更多&gt;</a></div>
                    <ul class="appList appHover">
					
						<li><a href="<?php echo $r['url'];?>" title="在职博士" target="_blank"><img src="<?php echo CSS_PATH;?>2019style/images/zhenti.png" alt="在职博士历年真题"><p>历年真题</p></a></li>
						<li><a href="<?php echo $r['url'];?>" title="在职博士" target="_blank"><img src="<?php echo CSS_PATH;?>2019style/images/dagang.png" alt="在职博士考试大纲"><p>考试大纲</p></a></li>
						<li><a href="<?php echo $r['url'];?>" title="在职博士" target="_blank"><img src="<?php echo CSS_PATH;?>2019style/images/chengji.png" alt="在职博士成绩查询"><p>成绩查询</p></a></li>
						<li><a href="<?php echo $r['url'];?>" title="在职博士" target="_blank"><img src="<?php echo CSS_PATH;?>2019style/images/tiaoji.png"><p>调剂指南</p></a></li>
						<li><a href="<?php echo $r['url'];?>" title="在职博士" target="_blank"><img src="<?php echo CSS_PATH;?>2019style/images/jiqiao.png" alt="在职博士复试技巧"><p>复试技巧</p></a></li>
						<li><a href="<?php echo $r['url'];?>" title="在职博士" target="_blank"><img src="<?php echo CSS_PATH;?>2019style/images/lunwen.png" alt="在职博士论文指导"><p>论文指导</p></a></li>
						
                    </ul>
                </div>
            </div>

            <div class="wrap-center fl">
                <div class="latest-news">
				<h4>最新更新</h4>
				<div class="topnews">
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=30ae6c710ee0d315b1bfbaac0ddf2bab&sql=SELECT+%2A+FROM+v9_news+WHERE+typeid%3D1+AND+status%3D99+order+by+listorder+DESC&cache=3600&num=4\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('sql'=>'SELECT * FROM v9_news WHERE typeid=1 AND status=99 order by listorder DESC',)).'30ae6c710ee0d315b1bfbaac0ddf2bab');if(!$data = tpl_cache($tag_cache_name,3600)){shy_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT * FROM v9_news WHERE typeid=1 AND status=99 order by listorder DESC LIMIT 4");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
					 <?php if($n ==1) { ?> <h3 class="news-top"> <?php } else { ?> <p> <?php } ?> <?php if($n >1) { ?>[<?php } ?><a href="<?php echo $r['url'];?>" class="seahotid"  target="_blank"><?php echo $r['title'];?></a><?php if($n >1) { ?>]&nbsp;&nbsp;<?php } ?> <?php if($n ==1) { ?> </h3><?php } else { ?> <p> <?php } ?>
					  <?php $n++;}unset($n); ?>
					  <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
				</div>
                    <div id="ivtab">

                        <div class="tab-bar clearfix">
							<ul>
                            <a class="cur" href="javascript:void(0);">招生简章</a>
                            <a class="" href="javascript:void(0);">报考条件</a>
                            <a class="" href="javascript:void(0);">招生说明</a>
                             <a class="" href="javascript:void(0);">政策解读</a>
							 </ul>
                        </div>
                        <div class="tab-con tab-on">

                            <ul class="ul-list_1">
							<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=909e3bbe659d354ad0944fba8794dde0&sql=SELECT+%2A+FROM+v9_course+WHERE+typeid%3D1+AND+status%3D99+order+by+listorder+DESC&cache=3600&num=15&return=data\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('sql'=>'SELECT * FROM v9_course WHERE typeid=1 AND status=99 order by listorder DESC',)).'909e3bbe659d354ad0944fba8794dde0');if(!$data = tpl_cache($tag_cache_name,3600)){shy_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT * FROM v9_course WHERE typeid=1 AND status=99 order by listorder DESC LIMIT 15");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
							  <li><span class="time fr  spe"><font color="red"><?php echo date('d',$r['inputtime']);?>日</font></span><i class="type"><a href="<?php echo $r['url'];?>" target="_blank">[<?php echo $r['school'];?>]</a></i><p class="name"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></p></li>
							  
							  <?php if($n%5==0) { ?><li class="dashed"></li><?php } ?>
							  <?php $n++;}unset($n); ?>
							<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            </ul>
                        </div>

                        <div class="tab-con">
                            <ul class="ul-list_1">
							   <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=36ee0bc0d9326421b678a6b8e57a401e&sql=SELECT+n.inputtime%2Cn.url%2Cn.title%2Cc.catname+FROM+v9_news+n+LEFT+JOIN+v9_category+c+ON+n.catid+%3D+c.catid+WHERE+n.typeid%3D1+AND+n.status%3D99+AND+n.newsid+%3D+525+order+by+n.listorder+DESC&cache=3600&num=15\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('sql'=>'SELECT n.inputtime,n.url,n.title,c.catname FROM v9_news n LEFT JOIN v9_category c ON n.catid = c.catid WHERE n.typeid=1 AND n.status=99 AND n.newsid = 525 order by n.listorder DESC',)).'36ee0bc0d9326421b678a6b8e57a401e');if(!$data = tpl_cache($tag_cache_name,3600)){shy_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT n.inputtime,n.url,n.title,c.catname FROM v9_news n LEFT JOIN v9_category c ON n.catid = c.catid WHERE n.typeid=1 AND n.status=99 AND n.newsid = 525 order by n.listorder DESC LIMIT 15");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
							  <li><span class="time fr  spe"><font color="red"><?php echo date('d',$r['inputtime']);?>日</font></span><i class="type"><a href="<?php echo $r['url'];?>" target="_blank">[<?php echo $r['catname'];?>]</a></i><p class="name"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></p></li>
							  
							  <?php if($n%5==0) { ?><li class="dashed"></li><?php } ?>
							  <?php $n++;}unset($n); ?>
							<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>                               
                            </ul>
                        </div>

                        <div class="tab-con">
                            <ul class="ul-list_1">
                                   <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=99d24df658370116ae45f2b06a201d65&sql=SELECT+n.inputtime%2Cn.url%2Cn.title%2Cc.catname+FROM+v9_news+n+LEFT+JOIN+v9_category+c+ON+n.catid+%3D+c.catid+WHERE+n.typeid%3D1+AND+n.status%3D99+AND+n.newsid+%3D+526+order+by+n.listorder+DESC&cache=3600&num=15\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('sql'=>'SELECT n.inputtime,n.url,n.title,c.catname FROM v9_news n LEFT JOIN v9_category c ON n.catid = c.catid WHERE n.typeid=1 AND n.status=99 AND n.newsid = 526 order by n.listorder DESC',)).'99d24df658370116ae45f2b06a201d65');if(!$data = tpl_cache($tag_cache_name,3600)){shy_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT n.inputtime,n.url,n.title,c.catname FROM v9_news n LEFT JOIN v9_category c ON n.catid = c.catid WHERE n.typeid=1 AND n.status=99 AND n.newsid = 526 order by n.listorder DESC LIMIT 15");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
							  <li><span class="time fr  spe"><font color="red"><?php echo date('d',$r['inputtime']);?>日</font></span><i class="type"><a href="<?php echo $r['url'];?>" target="_blank">[<?php echo $r['catname'];?>]</a></i><p class="name"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></p></li>
							  
							  <?php if($n%5==0) { ?><li class="dashed"></li><?php } ?>
							  <?php $n++;}unset($n); ?>
							<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            </ul>
                        </div>

                        <div class="tab-con">
                            <ul class="ul-list_1">
                                   <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=87af952b9ac8de90248fc69ce344400e&sql=SELECT+n.%2A%2Cc.catname+FROM+v9_news+n+LEFT+JOIN+v9_category+c+ON+n.catid+%3D+c.catid+WHERE+n.typeid%3D1+AND+n.status%3D99+AND+n.newsid+%3D+527+order+by+n.listorder+DESC&cache=3600&num=15\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('sql'=>'SELECT n.*,c.catname FROM v9_news n LEFT JOIN v9_category c ON n.catid = c.catid WHERE n.typeid=1 AND n.status=99 AND n.newsid = 527 order by n.listorder DESC',)).'87af952b9ac8de90248fc69ce344400e');if(!$data = tpl_cache($tag_cache_name,3600)){shy_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT n.*,c.catname FROM v9_news n LEFT JOIN v9_category c ON n.catid = c.catid WHERE n.typeid=1 AND n.status=99 AND n.newsid = 527 order by n.listorder DESC LIMIT 15");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
							  <li><span class="time fr  spe"><font color="red"><?php echo date('d',$r['inputtime']);?>日</font></span><i class="type"><a href="<?php echo $r['url'];?>" target="_blank">[<?php echo $r['catname'];?>]</a></i><p class="name"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></p></li>
							  
							  <?php if($n%5==0) { ?><li class="dashed"></li><?php } ?>
							  <?php $n++;}unset($n); ?>
							<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="wrap-right fr">
			<!--div class="wrap-ad"></script><div style="width:262px;height:110px;overflow:hidden;margin:auto;border:1px #f60 dashed;text-align:center;background:#fff; margin-top: 20px;">id_9广告位-260*110  唯一官网：<a href="https://www.zhikunet.org" target="_blank" style="color:#ed252f;">www.zhikunet.org</a></div></div-->
                <div class="wrap-recom mt20">
                    <div class="wrap-hd"><h4>院校推荐</h4><a title="换一批" class="refresh" href="javascript:void(0)">换一批<i></i></a></div>
                    
					<div class="wbody">
					<?php include_ssi("/caches/posid/2.html"); ?>
                       
                    </div>
                </div>

                <div class="wrap-zt">
                    <div class="wrap-hd"><h4>专业推荐</h4><a class="more" href="<?php echo $CATEGORYS['3830']['url'];?>" target="_blank">更多&gt;</a></div>
                    <div class="zt-area">
                        <ul class="zt-list">
							<!--li><a class="seahotid" href="/tongjifenxiruanjian/" target="_blank">统计分析软件大全</a></li><li><a class="seahotid" href="/moshouzhengba3bingfengwangzuoditu/" target="_blank">魔兽争霸3冰封王座地图大全</a></li><li><a class="seahotid" href="/koudaiyaoguaixlieshouyoudaquan/" target="_blank">口袋妖怪系列手游大全</a></li><li><a class="seahotid" href="/quanmianzhanzhengsanguomod/" target="_blank">全面战争三国mod大全</a></li><li><a class="seahotid" href="/shoujikanfengshui/" target="_blank">手机看风水软件大全</a></li><li><a class="seahotid" href="/djsanxiaoyouxi/" target="_blank">单机三消游戏大全</a></li><li><a class="seahotid" href="/lianghuajiaoyiruanjian/" target="_blank">量化交易软件大全</a></li><li><a class="seahotid" href="/diannaotiaoyinruanjian/" target="_blank">电脑调音软件大全</a></li><li><a class="seahotid" href="/huiyizhushou/" target="_blank">会议助手大全</a></li><li><a class="seahotid" href="/dnfbudingdaquna/" target="_blank">DNF补丁大全</a></li-->                          
                        </ul>
                    </div>
                </div>
            </div>

        </div>
<!-------在职博士项目模块-------->

<!------备考信息------->
<div class="main-type mt20" id="mainType">

            <div class="main-hd">
                <h3>考研工具箱</h3>
                <ul class="tab-soft">
                    <li onmousemove="onSelect(this,'type_show')" class="tab_1">硕士目录</li>
                    <li onmousemove="onSelect(this,'type_show')" class="tab_1">博士目录</li>
                    <li onmousemove="onSelect(this,'type_show')" class="tab_1">报名须知</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_1">现场确认</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_1">分数线</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_1">调剂信息</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_1">推免政策</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_1">复试备考</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_1">论文指导</li>
					<li onmousemove="onSelect(this,'type_show')" class="tab_2">试题中心</li>
                </ul>
                <a class="more fr" href="<?php echo $CATEGORYS['1']['url'];?>" target="_blank">更多&gt;</a>
            </div>

            <div class="main-bd clearfix">
			 <?php $j=1;?>
				<?php $n=1;if(is_array(subcat(3848))) foreach(subcat(3848) AS $v) { ?>
				<?php if($v['type']!=0) continue;?>
                <div id="type_show_<?php echo $j;?>" style="display: none;">
                    <div class="type-show">
                        <ul class="ul-list ">
							 <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=3fc6ad09d52bad4668475a17f9a7240a&action=lists&catid=%24v%5Bcatid%5D&num=24&order=id+DESC&moreinfo=1\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$v['catid'],'order'=>'id DESC','moreinfo'=>'1','limit'=>'24',));}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
							<li><i class="type"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo date('Y-m-d',$r['inputtime']);?></a><em></em></i><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></li>
							<?php $n++;}unset($n); ?>
						<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                        </ul>
                    </div>
                    <div class="rank-box">
                        <div class="hd"><h4><em><?php echo $v['catname'];?></em>排行榜</h4></div>
                        <div class="rank-list">
                            <ul>
							<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=290bef8e61554830c8ae41f2e18ad750&action=hits&catid=%24v%5Bcatid%5D&num=10&order=views+DESC&cache=3600\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('catid'=>$v['catid'],'order'=>'views DESC',)).'290bef8e61554830c8ae41f2e18ad750');if(!$data = tpl_cache($tag_cache_name,3600)){$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'hits')) {$data = $content_tag->hits(array('catid'=>$v['catid'],'order'=>'views DESC','limit'=>'10',));}if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
								<li class="rank_li"><span class="other"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo date('Y-m-d',$r['inputtime']);?></a></span><em class="em01"><?php echo $n;?></em><div class="title"><a href="<?php echo $r['url'];?>" target="_blank" class="tit"><?php echo $r['title'];?></a></div></li>
								<?php $n++;}unset($n); ?>
								<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php $j++; ?>
			<?php $n++;}unset($n); ?>
          </div>
        </div>
		</div>
<!----备考信息end------->
<div class="layout screen">
        <div  class="bottom-line"></div>
        <!--友情链接 end-->   
        
        <div class="mod-cooplink">
			<ol>
                <li class="f-link">
                    <span class="title">友情链接：</span>
					<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"link\" data=\"op=link&tag_md5=111356bb68c3d9d079629b7bfd631d12&action=type_list&siteid=%24siteid&typeid=13&order=listorder+DESC&num=50&return=dat\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$link_tag = shy_base::load_app_class("link_tag", "link");if (method_exists($link_tag, 'type_list')) {$dat = $link_tag->type_list(array('siteid'=>$siteid,'typeid'=>'13','order'=>'listorder DESC','limit'=>'50',));}?>
									<?php $n=1;if(is_array($dat)) foreach($dat AS $v) { ?>
					<a href="<?php echo $v['url'];?>"  target="_blank" ><?php echo $v['name'];?></a>
					 <?php $n++;}unset($n); ?>
								 <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </li>
                <li class="f-contact">
                    <span class="title">合作联系：</span>
                    课程推广<a href="#" data-alitalk="{id:'afanti008'}" class="alitalk alitalk-off"></a>
                    (<a href="#" title="">在线咨询</a>)
                    &nbsp;电话：010-56281125
                </li>
            </ol>
        </div>        
        <!--友情链接 end-->
</div>

<?php include template("content","footer"); ?>
<script src="<?php echo CSS_PATH;?>2019style/js/index.js"></script>
