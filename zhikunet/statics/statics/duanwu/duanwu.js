var Duanwu={isIE:navigator.userAgent.indexOf("MSIE")!=-1&&!window.opera,domain:"http://pic.05273.com/statics/duanwu",url:"http://pic.05273.com/statics/duanwu",started:false,ele:{holder:"dw_holder",drum:"dw_logo",drumface:"dw_drumface",closebtn:"dw_close",info:"dw_info"},text:{alt:"端午龙舟赛，请选择龙舟",pick:"请点击选择你的龙舟",begin:"击鼓开始比赛,击打LOGO处的鼓，敲得越快划得越快哦"},data:{selected:0,inited:false,start:false,winT:null,rndSpeedT1:null,rndSpeedT2:null,boating:[{}],firework:[]},G:function(A){return document.getElementById(A)},addEvent:function(C,B,A){if(window.attachEvent){C.attachEvent("on"+B,A)}else{if(window.addEventListener){C.addEventListener(B,A,false)}}},addStyle:function(B){if(this.isIE){var C=document.createStyleSheet();C.cssText=B}else{var A=document.createElement("style");A.type="text/css";A.appendChild(document.createTextNode(B));document.getElementsByTagName("HEAD")[0].appendChild(A)}},createClass:function(){return function(){this.initialize.apply(this,arguments)}},initStyle:function(){var B=this;var A=[];A.push("html{_background:#fff url(about:blank) fixed}");A.push("body{margin:0}");A.push(".dw_down{background:url("+B.domain+"/img/bg.png) no-repeat 1px -467px}");A.push("#dw_holder{width:100%;height:240px;text-align:left;position:fixed;left:0;bottom:0;_position:absolute;_top:expression(eval(document.documentElement.clientHeight + document.documentElement.scrollTop - 240) + 'px');z-index:9999}");A.push("#dw_info{font:bold 16px arial;position:absolute;left:20px;top:-80px;z-index:1}");A.push("#dw_close{width:31px;height:31px;display:block;position:absolute;z-index:1000;bottom:235px;right:10px;background:url("+B.domain+"/img/bg2.png) no-repeat 0 -270px;outline:none}");A.push("#dw_close:hover{background-position:0 -229px}");A.push("#dw_flash{width:20px;height:20px;position:absolute;z-index:0;bottom:20px;right:20px}");A.push("#dw_route_1{height:80px;position:relative;z-index:1}");A.push("#dw_route_2{height:80px;background:#00f8fe;position:relative;z-index:2}");A.push("#dw_route_3{height:80px;background:#17D7F4;position:relative;z-index:2}");A.push("#dw_group_1,#dw_group_2,#dw_group_3{width:394px;height:75px;position:absolute;left:0;top:-40px}");A.push("#dw_boat_1,#dw_boat_2,#dw_boat_3{width:214px;height:75px;background:url("+B.domain+"/img/bg.png) no-repeat;position:absolute;left:0;top:0;z-index:1}");A.push("#dw_boat_1{background-position:0 -245px}");A.push("#dw_boat_2{background-position:0 -320px}");A.push("#dw_boat_3{background-position:0 -395px}");A.push("#dw_wave_1,#dw_wave_2,#dw_wave_3{width:100%;height:30px;position:absolute;top:50px;z-index:0}");A.push("#dw_wave_1{background:#00f8fe}");A.push("#dw_wave_2{background:#17D7F4}");A.push("#dw_wave_3{background:#0087F0}");A.push("#dw_boatmen_1_1,#dw_boatmen_1_2,#dw_boatmen_1_3,#dw_boatmen_1_4,#dw_boatmen_2_1,#dw_boatmen_2_2,#dw_boatmen_2_3,#dw_boatmen_2_4,#dw_boatmen_3_1,#dw_boatmen_3_2,#dw_boatmen_3_3,#dw_boatmen_3_4{width:110px;height:76px;background:url("+B.domain+"/img/bg.png) no-repeat;position:absolute;}");A.push("#dw_boatmen_2_1,#dw_boatmen_2_2,#dw_boatmen_2_3,#dw_boatmen_2_4{background-position:0 -76px}");A.push("#dw_boatmen_3_1,#dw_boatmen_3_2,#dw_boatmen_3_3,#dw_boatmen_3_4{background-position:0 -152px}");A.push("#dw_boatmen_1_1,#dw_boatmen_2_1,#dw_boatmen_3_1{left:-5px;top:10px;z-index:5}");A.push("#dw_boatmen_1_2,#dw_boatmen_2_2,#dw_boatmen_3_2{left:30px;top:10px;z-index:4}");A.push("#dw_boatmen_1_3,#dw_boatmen_2_3,#dw_boatmen_3_3{left:65px;top:10px;z-index:3}");A.push("#dw_boatmen_1_4,#dw_boatmen_2_4,#dw_boatmen_3_4{left:100px;top:10px;z-index:2}");A.push(".dw_water_a,.dw_water_b{background:url("+B.domain+"/img/bg.png) no-repeat;position:absolute;z-index:1;display:none}");A.push(".dw_water_a{width:57px;height:43px;left:-28px;top:28px;background-position:-232px -240px}");A.push(".dw_water_b{width:57px;height:43px;left:165px;top:33px;background-position:-292px -240px}");A.push(".dw_wave_a,.dw_wave_b,.dw_wave_c{width:100%;height:50px;background:url("+B.domain+"/img/bg2.png) repeat-x;position:absolute;}");A.push(".dw_wave_a{height:40px;top:10px;z-index:1}");A.push(".dw_wave_b{top:18px;z-index:13}");A.push(".dw_wave_c{top:25px;z-index:14}");A.push("#dw_txt{width:1000px;height:60px;display:inline-block;margin:10px auto;position:relative;z-index:0}");A.push(".dw_txt_win{background:url("+B.domain+"/img/bg.png) no-repeat 0 -597px}");A.push(".dw_txt_fail{background:url("+B.domain+"/img/bg.png) no-repeat 0 -535px}");A.push("#dw_mask_holder{width:1000px;margin:0 auto;position:relative;z-index:9998}");A.push("#dw_mask{width:1000px;position:absolute;left:0;top:0;z-index:1;background:#fff;opacity:0.5;*filter:alpha(opacity=50);}");B.addStyle(A.join(""))},initHtml:function(){var B=[];for(var A=1;A<=3;A++){B.push('<div id="dw_route_'+A+'">');B.push('<div id="dw_group_'+A+'" style="left:0">');B.push('<div id="dw_boat_'+A+'"></div>');B.push('<div id="dw_boatmen_'+A+'_1"></div>');B.push('<div id="dw_boatmen_'+A+'_2"></div>');B.push('<div id="dw_boatmen_'+A+'_3"></div>');B.push('<div id="dw_boatmen_'+A+'_4"></div>');B.push('<div id="dw_water_'+A+'_1" class="dw_water_a"></div>');B.push('<div id="dw_water_'+A+'_2" class="dw_water_b"></div>');B.push("</div>");B.push('<div id="dw_wave_'+A+'_1" class="dw_wave_a"></div>');B.push('<div id="dw_wave_'+A+'_2" class="dw_wave_b"></div>');B.push('<div id="dw_wave_'+A+'_3" class="dw_wave_c"></div>');B.push('<div id="dw_wave_'+A+'"></div>');B.push("</div>")}B.push('<div id="dw_info"></div>');B.push('<a href="#" title="关闭" id="dw_close" onclick="return false;" onfocus="this.blur()"></a>');var C=document.createElement("div");C.id="dw_holder";C.innerHTML=B.join("");document.body.appendChild(C)},initMask:function(){var D=this;var A=D.G("s_wrap");if(A){var B=document.createElement("div");B.id="dw_mask_holder";document.body.insertBefore(B,A);var C=document.createElement("div");C.id="dw_mask";B.appendChild(C);C.style.height=A.offsetHeight+"px"}},initFlash:function(){var C=this;var A=C.url+"/img/drum.swf";var B=document.createElement("div");B.id="dw_flash";B.innerHTML='<object id="dw_drum" width="20" height="20" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"><param value="'+A+'" name="movie"><param name="wmode" value="transparent"><param name="allowScriptAccess" value="always"><embed width="20" height="20" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="dw_drum" wmode="transparent" src="'+A+'"></object>';document.getElementById("dw_holder").appendChild(B)},init:function(){var E=this;if(E.isIE){try{document.execCommand("BackgroundImageCache",false,true)}catch(D){}}document.body.style.cursor="url("+E.domain+"/img/cur.ico),default";E.createLogo();E.addEvent(E.G(E.ele.drum),"mouseover",function(){if(!E.inited){E.initStyle();E.initHtml();E.initMask();E.initFlash();E.setInfo("pick");new WaveEffect("dw_wave_1_1",0,-10,8,1,0.5);new WaveEffect("dw_wave_1_2",40,-65,7,1.5,1.2);new WaveEffect("dw_wave_1_3",10,-10,9,0.8,1.5);new WaveEffect("dw_wave_2_1",0,-118,9,1,0.5);new WaveEffect("dw_wave_2_2",40,-175,7,1.5,1.2);new WaveEffect("dw_wave_2_3",10,-65,8,0.8,1.5);new WaveEffect("dw_wave_3_1",0,-175,9,1,0.5);new WaveEffect("dw_wave_3_2",40,-118,7,1.5,1.2);new WaveEffect("dw_wave_3_3",10,-170,8,0.8,1.4);new BoatRoll("dw_group_1",20,-40);new BoatRoll("dw_group_2",20,-40);new BoatRoll("dw_group_3",20,-40);E.data.boating[1]=new Boating(1);E.data.boating[2]=new Boating(2);E.data.boating[3]=new Boating(3);E.setReady();E.inited=true;E.addEvent(E.G(E.ele.closebtn),"click",function(){E.gameover();E.TJ("close")})}else{E.G(E.ele.holder).style.display="block";var F=E.G("dw_mask_holder");if(F){F.style.display="block"}}});var C="mousedown";var A=navigator.userAgent.toLowerCase();if(/ipad/i.test(A)){C="touchstart";E.addEvent(E.G(E.ele.drum),"touchend",function(F){var F=event||window.event;if(window.event){F.returnValue=false}else{F.preventDefault()}})}E.addEvent(E.G(E.ele.drum),C,function(F){if(E.data.selected!=0){if(!E.data.start){E.data.boating[1].start();E.data.boating[2].start();E.data.boating[3].start();E.data.start=true;E.data.boating[E.data.selected].enControl=true;E.winT=setInterval(function(){E.checkWin()},10);E.G(E.ele.info).style.display="none";if(E.started){E.TJ("restart")}else{E.TJ("start");E.started=true}}E.playFlash();E.data.boating[E.data.selected].play(12);E.G(E.ele.drumface).className="dw_down"}});E.addEvent(E.G(E.ele.drum),"mouseup",function(){E.G(E.ele.drumface).className=""});E.addEvent(window,"resize",function(){if(!E.data.selected){return }for(var F=1;F<=3;F++){E.data.boating[F].distance=document.documentElement.clientWidth}});var B=E.G("kw");if(B){E.addEvent(B,"mousedown",function(){if(E.inited){E.gameover()}});E.addEvent(B,"keydown",function(){if(E.inited){E.gameover()}})}},createLogo:function(){var E=this;var A=E.G("du");if(A){var D=document.createElement("div");D.style.position="relative";D.style.left=0;D.style.top=0;D.style.width="100%";D.style.zoom="1";A.insertBefore(D,E.G("lg"));var C=document.createElement("div");C.id="dw_drumface";C.style.position="absolute";C.style.left=E.G("s_wrap")?"190px":"190px";C.style.top="8px";C.style.width="78px";C.style.height="61px";D.appendChild(C);var B=document.createElement("div");B.id="dw_logo";B.title=E.text.alt;B.style.width="200px";B.style.height="74px";B.style.position="absolute";B.style.left=E.G("s_wrap")?"225px":"140px";B.style.top=4;if(this.isIE){B.style.background="url(about:blank)"}D.appendChild(B);D.style.MozUserSelect="none";D.onselectstart=function(){return false}}},setInfo:function(A){var C=this;var B=C.G(C.ele.info);B.style.display="block";B.innerHTML=C.text[A]},playFlash:function(){try{var B=document.dw_drum||window.dw_drum;B.playNote()}catch(A){}},getGroup:function(B){var B=B||window.event;var A=B.target||B.srcElement;var D=A.id;if(!/group/.test(D)){A=A.parentNode}var C=A.id.split("_")[2];return C},setReady:function(){var B=this;for(var A=1;A<=3;A++){B.addEvent(B.G("dw_group_"+A),"mouseover",function(C){if(B.data.start){return }var D=B.getGroup(C);B.data.boating[D].ready(true)});B.addEvent(B.G("dw_group_"+A),"mouseout",function(C){if(B.data.start){return }var D=B.getGroup(C);if(B.data.selected!=D){B.data.boating[D].ready(false)}});B.addEvent(B.G("dw_group_"+A),"click",function(C){if(B.data.start){return }var D=B.getGroup(C);B.resetReady();B.data.selected=D;B.data.boating[D].ready(true);B.setInfo("begin")})}},resetReady:function(){var B=this;for(var A=1;A<=3;A++){B.data.boating[A].ready(false)}},gameover:function(){var C=this;C.data.selected=0;C.data.inited=false;C.data.start=false;clearInterval(C.winT);clearTimeout(C.rndSpeedT1);clearTimeout(C.rndSpeedT2);for(var B=1;B<=3;B++){C.data.boating[B].end()}C.G(C.ele.holder).style.display="none";C.setInfo("pick");var A=C.G("dw_mask_holder");if(A){A.style.display="none"}},checkWin:function(){var C=this;var B=0;for(var A=1;A<=3;A++){if(C.data.boating[A].arrived){B=A;clearInterval(C.winT);C.showWin(B);C.gameover();break;return }}C.changeSpeed()},showWin:function(E){var G=this;var D=G.G("lm");if(D){D.innerHTML=E==parseInt(G.data.selected)?'<span id="dw_txt" class="dw_txt_win"></span>':'<span id="dw_txt" class="dw_txt_fail"></span>';D.style.color="#f00";D.style.fontSize="28px";var A=G.G("s_wrap"),B=G.G("dw_txt");if(A&&B){B.style.marginTop="5px"}setTimeout(function(){D.innerHTML=""},4000);if(E==parseInt(G.data.selected)){G.TJ("win")}else{G.TJ("lose")}}var F=G.isIE?60:100;for(var C=0;C<4;C++){if(!G.data.firework[C]){G.data.firework[C]=new Firework(F,10,20,500,500,C,"dw"+C)}else{G.data.firework[C].play()}}},changeSpeed:function(){var H=this;if(H.data.selected<=0){return }var E=parseInt(H.data.boating[H.data.selected].obj.style.left);var A,G;switch(H.data.selected){case"1":A=H.data.boating[2];G=H.data.boating[3];break;case"2":A=H.data.boating[1];G=H.data.boating[3];break;case"3":A=H.data.boating[1];G=H.data.boating[2];break}var F=parseInt(A.obj.style.left),D=parseInt(G.obj.style.left);var C=H.data.boating[H.data.selected].speed;if(E-F>50){setTimeout(function(){var I=0.7+Math.random()*0.2;A.setSpeed(C*I)},60)}if(E-D>100){setTimeout(function(){var I=0.6+Math.random()*0.3;G.setSpeed(C*I)},100)}if(F-E>60){var B=1+Math.random()*0.2;A.setSpeed(C*B)}if(D-E>60){var B=1+Math.random()*0.2;G.setSpeed(C*B)}},TJ:function(B,C){var A=window["BD_PS_C"+(new Date()).getTime()]=new Image();A.src="http://www.baidu.com/v.gif?pid=201&pj=duanwu&type="+B+"&t="+new Date().getTime()}};var WaveEffect=Duanwu.createClass();WaveEffect.prototype={initialize:function(A,F,E,C,D,B){this.el=Duanwu.G(A);this.posX=F;this.posY=E;this.count=C;this.stepX=D;this.stepY=B;this.step=0;this.plus=true;this.play()},play:function(){var A=this;setInterval(function(){A.move()},100);A.el.style.backgroundPosition=A.posX+"px "+A.posY+"px"},move:function(){var A=this;if(A.plus){A.step++}else{A.step--}if(A.step>=A.count){A.plus=false}else{if(A.step<=0){A.plus=true}}A.el.style.backgroundPosition=(A.step*A.stepX+A.posX)+"px "+(A.step*A.stepY+A.posY)+"px"}};var BoatRoll=Duanwu.createClass();BoatRoll.prototype={initialize:function(A,C,B){this.el=Duanwu.G(A);this.posX=C;this.posY=B;this.count=10;this.stepX=0;this.stepY=1;this.step=0;this.plus=true;this.play()},play:function(){var A=this;setInterval(function(){A.move()},100);A.el.style.top=A.posY+"px"},move:function(){var A=this;if(A.plus){A.step++}else{A.step--}if(A.step>=A.count){A.plus=false}else{if(A.step<=0){A.plus=true}}A.el.style.top=(A.step*A.stepY+A.posY)+"px "}};var Boating=Duanwu.createClass();Boating.prototype={initialize:function(A){this.group=A;this.obj=Duanwu.G("dw_group_"+A)},init:function(){this.step=4;this.count=0;this.space=110;this.speed=300;this.minSpeed=60;this.maxSpeed=400;this.speedStep=10;this.speedupT=null;this.speeddownT=null;this.moveT=null;this.enControl=false;this.controlCount=5;this.distance=document.documentElement.clientWidth;this.moveSpace=10;this.arrived=false},start:function(){var B=this;B.init();B.move();for(var A=1;A<=3;A++){Duanwu.G("dw_water_"+B.group+"_1").style.display="block";Duanwu.G("dw_water_"+B.group+"_2").style.display="block"}},end:function(){var A=this;clearTimeout(A.speedupT);clearTimeout(A.speeddownT);clearTimeout(A.moveT);A.ready(false);setTimeout(function(){A.resetPos()},50)},play:function(A){var B=this;clearTimeout(B.speedupT);clearTimeout(B.speeddownT);if(A<1){A=10}B.speedStep=A;B.speedup();if(B.enControl){B.controlCount=5;clearTimeout(B.moveT);B.move()}},resetPos:function(){var B=this;B.obj.style.left=0;for(var A=1;A<=3;A++){Duanwu.G("dw_water_"+B.group+"_1").style.display="none";Duanwu.G("dw_water_"+B.group+"_2").style.display="none"}},ready:function(A){var C=this.group;var D=A?"-110px -"+((C-1)*77)+"px":"0 -"+((C-1)*77)+"px";for(var B=1;B<=4;B++){Duanwu.G("dw_boatmen_"+C+"_"+B).style.backgroundPosition=D}},move:function(){var B=this;if(B.enControl){if(B.controlCount--<=0){return }}for(var A=1;A<=4;A++){Duanwu.G("dw_boatmen_"+B.group+"_"+A).style.backgroundPosition=-B.space*B.count+"px "+(1-B.group)*77+"px"}Duanwu.G("dw_water_"+B.group+"_1").style.backgroundPosition="-232px -"+(240+43*B.count)+"px";Duanwu.G("dw_water_"+B.group+"_2").style.backgroundPosition="-292px -"+(240+43*B.count)+"px";B.run();B.count++;if(B.count>=B.step){B.count=0}B.moveT=setTimeout(function(){B.move()},B.speed)},run:function(){var B=this;var A=parseInt(B.obj.style.left)+B.moveSpace;if(A<B.distance-240){B.obj.style.left=A+"px"}else{B.arrived=true;B.end()}},speedup:function(){var A=this;if(A.speed>A.minSpeed){A.speedStep--;if(A.speedStep<0){A.speeddown();return }A.speed-=20;if(A.speed<A.minSpeed){A.speed=A.minSpeed}A.speedupT=setTimeout(function(){A.speedup()},30)}else{A.speeddown()}},speeddown:function(){var A=this;if(A.speed<A.maxSpeed){A.speed+=20;if(A.speed>A.maxSpeed){A.speed=A.maxSpeed}A.speeddownT=setTimeout(function(){A.speeddown()},50)}},setSpeed:function(A){this.speed=A}};var Firework=Duanwu.createClass();Firework.prototype={G:function(A){return document.getElementById(A)},initialize:function(E,A,D,F,C,B,G){this.colors=["#5CEF7C","#F05400","#F02458","#93f","#0cc","#f93"];this.color=B;this.sX=0;this.sY=0;this.offsetX=0;this.arrHeight=0;this.bits=E;this.intensity=A;this.speed=D;this.sWidth=F;this.sHeight=C;this.id=G;this.fade=[];this.pos=[];this.rate=[];this.rizeT=null;this.init()},init:function(){var A=this;A.setWidth();A.createFire();A.play();Duanwu.addEvent(window,"resize",function(){A.setWidth()});A.setScroll();Duanwu.addEvent(window,"scroll",function(){A.setScroll()})},play:function(){var A=this;setTimeout(function(){var B=A.G(A.id+"_lg"),C=A.G(A.id+"_tg");B.style.visibility="visible";C.style.visibility="visible";A.launch()},10);A.riseT=setInterval(function(){A.rise()},10)},createFire:function(){var C=this;var B=document.createElement("div");B.id=C.id+"_firework_holder";B.style.position="absolute";B.style.zIndex="9999";B.style.left=0;B.style.top=0;document.body.appendChild(B);B.appendChild(C.createChip(C.id+"_lg",3,4));B.appendChild(C.createChip(C.id+"_tg",2,3));for(var A=0;A<C.bits;A++){B.appendChild(C.createChip(C.id+"_firework_"+A,1,1))}},createChip:function(E,A,B){var D=this;var C=document.createElement("div");C.style.position="absolute";C.style.overflow="hidden";C.style.width=A+"px";C.style.height=B+"px";C.setAttribute("id",E);return C},launch:function(){var C=this;C.sX=Math.round((0.5+Math.random())*C.sWidth*0.5);C.sY=C.sHeight-5;C.offsetX=(Math.random()-0.5)*1;C.arrHeight=Math.round((0.5+Math.random())*C.sHeight*0.4);var A=C.G(C.id+"_lg"),B=C.G(C.id+"_tg");A.style.backgroundColor=C.colors[C.color];B.style.backgroundColor=C.colors[C.color]},rise:function(){var F=this;var E=F.sX,D=F.sY;F.sX+=F.offsetX;F.sY-=5;if(F.sX<=0||F.sX>=F.sWidth||F.sY<=F.arrHeight||F.sY>=F.sHeight){for(var C=0;C<F.bits;C++){F.pos[C]={x:F.sX,y:F.sY};var G=(Math.random()-0.5)*F.intensity;var H=(Math.random()-0.5)*(F.intensity-Math.abs(G))*1.25;F.rate[C]={x:H,y:G};F.fade[C]=Math.floor((Math.random()*16)+16);var B=F.G(F.id+"_firework_"+C);B.style.backgroundColor=F.colors[F.color];B.style.visibility="visible"}F.bang();clearInterval(F.riseT)}var I=F.G(F.id+"_lg"),A=F.G(F.id+"_tg");I.style.left=F.sX+"px";I.style.top=F.sY+"px";A.style.left=E+"px";A.style.top=D+"px"},bang:function(){var F=this;var C,H,D,G=0;for(var E=0;E<F.bits;E++){C=Math.round(F.pos[E].x);H=Math.round(F.pos[E].y);D=F.G(F.id+"_firework_"+E);if(C>=0&&C<F.sWidth&&H>=0&&H<F.sHeight){D.style.left=C+"px";D.style.top=H+"px"}var A=F.fade[E]--;if(A>14){D.style.width="14px";D.style.height="4px"}else{if(A>7){D.style.width="3px";D.style.height="3px"}else{if(A>3){D.style.width="2px";D.style.height="2px"}else{++G;D.style.visibility="hidden";var I=F.G(F.id+"_lg"),B=F.G(F.id+"_tg");I.style.visibility="hidden";B.style.visibility="hidden"}}}F.pos[E].x+=F.rate[E].x;F.pos[E].y+=(F.rate[E].y+=1.25/F.intensity)}if(G!=F.bits){setTimeout(function(){F.bang()},F.speed)}},setWidth:function(){var A=this;A.sWidth=document.body.clientWidth||document.documentElement.clientWidth;A.sHeight=document.body.clientHeight||document.documentElement.clientHeight;if(A.sHeight>500){A.sHeight=500}},setScroll:function(){var D=this;var B=document.body.scrollLeft||document.documentElement.scrollLeft;var A=document.body.scrollTop||document.documentElement.scrollTop;var C=D.G(D.id+"_firework_holder");C.style.left=B+"px";C.style.top=A+"px"}};Duanwu.init();