<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?>
<div id="footer">
    <div id="footer-v0">
        <div class="footer-container">
            <div class="ali-pages">
                <p id="copyright">智库联盟（北京）国际自然科学研究院&copy; 2010-<?php echo date('Y', SYS_TIME);?> zhikunet.org 版权所有｜<a href="http://www.beian.miit.gov.cn/" rel="nofollow"  target="_blank" >京ICP备14011169号</a></p></br>
				
                <!--ul>
				<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=263e96eec5613629462773e64ecb5a63&action=category&catid=1&num=5&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'1','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'5',));}?>
									<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                    <li><a rel="nofollow" href="<?php echo $r['url'];?>" target="_self" title="<?php echo $r['catname'];?>"><?php echo $r['catname'];?></a> |</li>
                    
					<?php $n++;}unset($n); ?>
								<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    <li><a href="<?php echo APP_PATH;?>" target="_self" title="网站导航">网站导航</a></li>
                </ul-->
            </div>
            <div class="ali-group">
                <dl>
					<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=409ac993b841e10780a883c16dcc9e17&action=category&catid=1&num=10&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'1','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'10',));}?>
									<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                  	<dd>
                        <a rel="nofollow" href="<?php echo $r['url'];?>" title="<?php echo $r['catname'];?>"><?php echo $r['catname'];?></a>
                        |
                    </dd>                  	
                  	<?php $n++;}unset($n); ?>
				<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </dl>
				
            </div>
        </div>
    </div>
	

</body>
</html>