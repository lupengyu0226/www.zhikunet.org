<?php defined('IN_SHUYANG') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<?php include template("content","header_top"); ?>
<?php include template("content","header_logo"); ?>
<?php include template("content","header_nav"); ?>
  <!--正文start--> 
  <div class="index-main-content"> 
   <!--热门推荐start--> 
   <div class="Hme_top">
    <span>热门推荐：</span> 
    <a class="black" target="_blank" href="/zhuanti/CAD.html">CAD软件下载</a> 
    <a class="black" target="_blank" href="/zhuanti/apexyxgonglue.html">APEX英雄攻略</a> 
    <a target="_blank" href="/zhuanti/jumpdldmod.html">jump大乱斗MOD</a> 
    <a class="black" target="_blank" href="/zhuanti/WiFimimachakan.html">WiFi密码查看</a> 
    <a class="black" target="_blank" href="/zhuanti/gta5xiugaiqi.html">GTA5修改器</a> 
    <a target="_blank" href="/zhuanti/cengwangruanjian.html">蹭网软件</a> 
    <a class="yellow" target="_blank" href="/zhuanti/iosmoniqi.html">iOS模拟器</a> 
    <a target="_blank" href="/zhuanti/coreldraw.html">coreldraw下载</a> 
    <a class="yellow" target="_blank" href="/zhuanti/apexjiasuqi.html">Apex英雄加速器</a> 
    <a class="black" target="_blank" href="/zhuanti/wannengbofangqi.html">万能播放器</a> 
    <a class="black" target="_blank" href="/zhuanti/juyuwangxiansu.html">局域网限速软件</a> 
    <a class="black" target="_blank" href="/zhuanti/choujiang.html">抽奖软件</a> 
   </div> 
   <div class="pic-bannerA clearfix"> 
    <div class="pic-bannerA clearfix">
     <a rel="nofollow" href="http://g.wan.2345.com/s/1/1258/303.html?frm=rjdq-yxxz-dbtl" title="" target="_blank" onclick="tj('h_ad1', '')"><img src="https://img1.2345.com/duoteimg/dtnew_recom_img/201805/20180529184212_65349.gif" alt="" width="590" height="80" /></a>
     <a rel="nofollow" href="http://www.2345download.com/2345explorer/2345Explorer_duote.exe" title="" target="_blank" onclick="tj('h_ad2', '')"><img src="https://img1.2345.com/duoteimg/dtnew_recom_img/201903/20190319154249_50033.png" alt="" width="590" height="80" /></a>
    </div>
    <style type="text/css">.pic-bannerA{font-size: 0;width:1190px;margin:0 auto 10px;}.pic-bannerA a{float: left;}.pic-bannerA a+a{margin-left: 10px;}</style> 
   </div> 
  </div> 
  <!--show-end--->
	<!--面包屑-->
	<div class="crumbs">
        <a href="<?php echo APP_PATH;?>">智库网</a>&nbsp;&gt;&nbsp;<?php echo catpos($catid);?><?php echo $title;?>
    </div>
	<!---content-star-->
	<div class="content cont2"> 
        
        <div class="A_activle"> 
            
            <div class="A_actext">
                <script type="text/javascript"> 

                    $(function(){
                        $("#tk-hal").val($('.A_actext').innerHeight());
                        //浮动的
                        function fix(){
                            var actall = $('.A_actext').innerHeight();   //文章总高度
                            var actle = $('#ew').innerHeight();       //左侧悬浮高度
                            var wintop = $(window).scrollTop();
                            var tkh = $("#tk-hed").val();
                            if(wintop>tkh && wintop<=actall){
                                $("#tk-hed").val(wintop);
                                $("#tk-ted").val(Date.parse(new Date())/1000);
                            }
                            
                            var atop = $('.A_conpsg').offset().top
                            var actp = 80+wintop;
                            if(actp >= actall-actle){
                                $('#ew').css({'top':actall-actle-80+"px"})
                            }else{
                                $('#ew').css({'top':actp+"px"})    
                            }

                            if(wintop <= atop-90){
                                $('.A_tjlist').css({'top':-19+"px"})
                            }else{
                                $('.A_tjlist').css({'top':wintop-atop+90+"px"})    
                            }
                        }

                        $(window).scroll(function(){
                            fix();
                        })
                        $(window).on('beforeunload',function(){
                            var d = {'a':'unload'};
                            d['id'] = $("#obj-id").val();
                            d['t1'] = $('#tk-tst').val();
                            d['t2'] = $("#tk-ted").val();
                            d['h1'] = $("#tk-hed").val();
                            d['h2'] = $("#tk-hal").val();
                            ctk.track_get(d);
                        });
                        $('.playfen').on('click',function(){
                            $('.playboxng').show()
                        })
                        $('.cuong , .oveg').on('click',function(){
                            $('.playboxng').hide()
                        })
                    })

                </script>
                                <div class="bdsharebuttonbox bdshare-button-style0-32" id="ew" data-bd-bind="1561220683359" style="top: 80px;">分享到
                    <input type="hidden" value="" name="phashs">
                    <a href="javascript:;" class="bds_weixin" data-cmd="weixin" data-id="1037184" title="分享到微信"><span class="shareredpackage" style="display: none">￥</span></a>
                    <a href="javascript:;" rel="nofollow" class="bds_tsina" data-cmd="tsina" data-id="1037184" data-pic="" data-title="" title="分享到新浪微博"><span class="shareredpackage" style="display: none">￥</span></a>
                    <a href="javascript:;" rel="nofollow" class="bds_sqq" data-cmd="sqq" data-id="1037184" data-pic="" data-title="" title="分享到QQ好友"><span class="shareredpackage" style="display: none">￥</span></a>
                                    </div>
              
                <div class="A_ctes"> 
                    <div class="down-box">
				<div class="soft-name">
					<img src="https://img3.2345.com/duoteimg/duotelogo/logo3001-4000/3384_72.png" width="48" height="48">
                    <div class="max_widths"><?php echo $title;?><i class="tag_bingdu">热招中</i>
					</div>				
				</div>
				<div class="soft-info">
					<div class="soft-info-list">
						<ul class="clearfix">
							<li>软件大小：<span>16MB</span></li>
							<li>更新日期：<span>2019-05-23</span></li>
							<li>软件语言：<span>简体中文</span></li>
							<li>软件授权：<span>免费软件</span></li>
							<li>软件评论：<a href="#net-cmt" onclick="tj('s_3','')">2198条</a></li>
							<li>官方网站：<a href="http://haozip.2345.com/" onclick="tj('s_4','')" target="_blank">二三四五</a></li>
                            <li style="width: 95%">适用平台：<span>Win8/Win7/Vista/WinXP/Win10/</span></li>
						</ul>
					</div>
                    <a class="soft-down-btn" id="quickDown" onclick="softCount('3384');tj('s_2','');" target="_self" href="https://soft.xp666.com/haozip_5.9.7.10871.exe">
                        立即下载
                    </a>
                </div>
                          
				
			</div>
			<!---简章内容页中间广告位--->
			<div class="dl-banner" id="middle_banner">                
                <div class="dl-banner">
				<a href="http://download.2345.cn/down/2345Explorer_100263.exe" target="_self" rel="nofollow" onclick="tj('s_ad2', '')"><img src="https://img2.2345.com/duoteimg/dtnew_recom_img/201806/20180601185450_52907.png" class="ggimgleft"></a></div><style type="text/css">.dl-banner{margin-bottom: 10px;}.dl-banner a img{width:700px}</style>
				</div>
                    
			<div class="soft-detail">
				<div class="hd">
					<div class="detail-tab">
						<span>课程介绍</span>
					</div>
				</div>
				<div class="bd">
					<div class="soft-intr">
						<div id="intro_short">
						【课程描述】<br><?php echo $description;?></div>
						<div class="more-info">							
						<?php echo $content;?>
						</div>
						
					</div>
                 <div class="A_textbom"> 
                        <h2>声明：该文章版权归原作者所有，转载目的在于传递更多信息，并不代表本网赞同其观点和对其真实性负责。如涉及作品内容、版权和其它问题，请在30日内与本网联系。</h2>
                       
                    </div> 		
                        <div class="jbox mt25">
							<div class="hd clearfix">
								<div class="caption">相关阅读</div>
								<a href="<?php echo $CATEGORYS[$catid]['url'];?>" class="more" target="_blank">更多 &gt;</a>
							</div>
							<div class="bd">
								<div class="txt-links">
									<ul>
									<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=f8ab390a6906c3dfc0c8c149e372205d&action=relation&relation=%24relation&id=%24id&catid=%24catid&num=10&keywords=%24rs%5Bkeywords%5D\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = shy_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'relation')) {$data = $content_tag->relation(array('relation'=>$relation,'id'=>$id,'catid'=>$catid,'keywords'=>$rs['keywords'],'limit'=>'10',));}?>
								<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
										<li>
											<a href="<?php echo $r['url'];?>" target="_blank" alt="<?php echo $r['title'];?>"><?php echo $r['title'];?></a>
										</li>
									<?php $n++;}unset($n); ?>
								{/pc}
								</ul>
								</div>
							</div>
						</div>
                    <!--=====创语录=======-->
                </div>                       
            </div>
                    
        </div>

    </div>
             <!--<div class="A_revie"> 
                    <h2>评论</h2>
                    <div class="A_revitext"> 
                        <dl> 
                            <dt> 
                               <img src="/style/img/no-avatar.png" alt="未登录的游客">
                            </dt>
                            <dd>游客</dd>
                        </dl>
                            <textarea id="msg_0" placeholder="欢迎评论" onclick="show_login()"></textarea>
                        <p>
                            <button data-uid="0" onclick="show_login()">发表</button>
                            </p>
						<div class="A_share" style="display:none;"> 
                        </div>
                        <p></p>
                    </div>
                </div-->

                <!--div id="comment_list"> 
                    <div class="A_theof"> 
						<div class="A_thepic"> 
							<img src="http://img2.ctoutiao.com/uploads/avatar/001/09/44/small_43.jpg" alt="Charmy">
						</div>
						<div class="A_thetext"> 
							<h3><span>Charmy</span>说：</h3>
								<p>专业注册个人独资、合伙企业，所得税核定征收，无需费用发票冲抵。无需缴纳企业所得税和红利税，只需缴纳个人所得税，个人所得税500万以内不高于2.19%；500万以上部分为3.5%。网址：www.shsky.net.cn</p>
							<h2> 
								<span>2019-06-09 11:12:40</span> 
								<div class="A_dm"><span></span></div>
								<div class="A_pm" data="180054"><span></span><em></em></div>
																	</h2>
							<div class="A_retus"> 
								<textarea name="" id="msg_180054" placeholder="回复他/她:"></textarea>
								<button data-uid="1094443" onclick="comment_submit(this,180054)">发表</button>
							</div>
						</div>
					</div> 
                    <div class="A_theof"> 
						<div class="A_thepic"> 
							<img src="http://img2.ctoutiao.com/images/avatar/defaultm.png" alt="吐了个">
						</div>
						<div class="A_thetext"> 
							<h3><span>吐了个</span>说：</h3>
																<p>富强</p>
							<h2> 
								<span>2018-10-11 00:03:41</span> 
								<div class="A_dm"><span></span></div>
								<div class="A_pm" data="53166"><span></span><em></em></div>
																	</h2>
							<div class="A_retus"> 
								<textarea name="" id="msg_53166" placeholder="回复他/她:"></textarea>
								<button data-uid="916511" onclick="comment_submit(this,53166)">发表</button>
							</div>
						</div>
					</div> 
                    <div class="A_theof"> 
						<div class="A_thepic"> 
							<img src="http://img2.ctoutiao.com/images/avatar/defaultm.png" alt="古荡乃">
						</div>
						<div class="A_thetext"> 
							<h3><span>古荡乃</span>说：</h3>
																<p>抱抱宝宝健康</p>
							<h2> 
								<span>2018-10-10 00:06:28</span> 
								<div class="A_dm"><span></span></div>
								<div class="A_pm" data="52950"><span></span><em></em></div>
																	</h2>
							<div class="A_retus"> 
								<textarea name="" id="msg_52950" placeholder="回复他/她:"></textarea>
								<button data-uid="916717" onclick="comment_submit(this,52950)">发表</button>
							</div>
						</div>
                    </div> 
                </div-->   
				

			</div>
                <div class="A_activrig">
                        <!--======24小时热文======-->
             
            <div class="hotdoc">
                <h4 class="hotArticle">24小时热文</h4>
                <ul class="hotdoclist white">
                    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"get\" data=\"op=get&tag_md5=e4146a741bdc3fa6da7c8fcf41d08800&sql=SELECT+a.title%2C+a.catid%2C+b.catid%2C+b.catname%2Ca.url+as+turl+%2Cb.url+as+curl%2C+a.id+FROM+%60v9_news%60+a%2C+%60v9_category%60b+WHERE+a.catid+%3D+b.catid+ORDER+BY+%60a%60.%60id%60+DESC+&num=12&cache=300\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('sql'=>'SELECT a.title, a.catid, b.catid, b.catname,a.url as turl ,b.url as curl, a.id FROM `v9_news` a, `v9_category`b WHERE a.catid = b.catid ORDER BY `a`.`id` DESC ',)).'e4146a741bdc3fa6da7c8fcf41d08800');if(!$data = tpl_cache($tag_cache_name,300)){shy_base::load_sys_class("get_model", "model", 0);$get_db = new get_model();$r = $get_db->sql_query("SELECT a.title, a.catid, b.catid, b.catname,a.url as turl ,b.url as curl, a.id FROM `v9_news` a, `v9_category`b WHERE a.catid = b.catid ORDER BY `a`.`id` DESC  LIMIT 12");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$data = $a;unset($a);if(!empty($data)){setcache($tag_cache_name, $data, 'tpl_data');}}?>
					<?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                     <li class="clearFix">
                        <mark class="Top<?php echo $n;?>"><?php echo $n;?></mark>
                        <div>
                            <h4><a target="_blank" href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                            <p><?php echo $r['catname'];?></p>
                        </div>
                    </li>
                    <?php $n++;}unset($n); ?>
			　　<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>                
                </ul>
            </div>
            
            <!--=====创语录=======-->
            <div class="NCquotation white">
                <h2 class="title">在职·研</h2>
                <div class="NCtop">
                    <a target="_blank" onclick="ctk.track_click('y;235583;rq;0;0')" href="#">
                        <p>为企业站台，是干部的责任和义务。</p>
                        <h6>青岛市委书记王清宪</h6>
                        <div class="NCfutitle">6月21日上午在千企助力青岛（半岛）发展行开幕式上致辞指出，市场机制的主体是企业，干部为企业站台，代表党和政府的态度和信用，要站在企业角度换位思考，做到既“亲”又“清”，既“清”又“亲”。</div>
                    </a>
                </div>
                <div class="NCbottom">
                    <a target="_blank" href="#" class="Cyl_weibo"><div class="NCweibo"><span class="weiboIcon"></span><span class="weiboName"></span></div></a>
                    <div class="NCweixin">
                        <span class="weixinIcon"></span>
                        <span class="weixinName"></span>
                        <div class="erweima"><img src="#" alt=""><div></div></div>
                    </div>
                    <div class="NCdianzan"><span class="dianzanIcon " data-id="235583" onclick="dianzan(this)" data-type="1"></span><span class="dianzanNumber">63</span><span class="tishi"><span></span>您已经赞过了</span></div>
                </div>
            </div>
            <input type="hidden" id="obj-id" value="1037184">
            <input type="hidden" id="comment-order" value="1">
            <input type="hidden" id="tk-tst" value="1561220678">
            <input type="hidden" id="tk-ted" value="1561220729">
            <input type="hidden" id="tk-hed" value="3177">
            <input type="hidden" id="tk-hal" value="1247">
            <input type="hidden" id="comment_login" value="">
            <input type="hidden" value="0" id="sub_weibo">
           
        </div>  
		</div>

    </div>    
      
    </div>
	<!---content-end----->
	<div class="A_bonsbox"> 
                    <div class="content A_busb"> 
                <h3>阅读下一篇</h3>
                <h2><a href="<?php echo $next_page['url'];?>"><?php echo $next_page['title'];?></a></h2>
                <p><?php echo $next_page['title'];?></p>
                <a href="/" class="A_retens">返回智库网首页</a>
				
            </div>
        <span id="share_userid" style="display:none"></span>
    </div>
	<div class="fiedSidebar">
        <div class="redpackage" id="redpack"></div>
        <ul>
            <li class="wxkf">
                <div class="kfwrap">
                    <div class="kfewm"><img src="/images/wxkf.png" alt="联系客服"></div>
                </div>
            </li>
            <li class="wxgzh">
                <div class="gzhewm">
                    <img src="/images/w_qrcode.png" alt="创头条精选">
                </div>
            </li>
            <li class="khd">
                <div class="khdewm">
                    <img src="/images/appdown.png" alt="创头条APP">
                </div>
            </li>
            <li class="blackTop"><a href="#"></a></li>
        </ul>
    </div>
  <!--show-end---> 
  <?php include template("content","footer"); ?>