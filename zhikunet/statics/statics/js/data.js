// JavaScript Document
var now=new Date();
var lunarinfo=new Array(0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,

0x04ae0,0x0a5b6,0x0a4d0,0x0d250,0x1d255,0x0b540,0x0d6a0,0x0ada2,0x095b0,0x14977,

0x04970,0x0a4b0,0x0b4b5,0x06a50,0x06d40,0x1ab54,0x02b60,0x09570,0x052f2,0x04970,

0x06566,0x0d4a0,0x0ea50,0x06e95,0x05ad0,0x02b60,0x186e3,0x092e0,0x1c8d7,0x0c950,

0x0d4a0,0x1d8a6,0x0b550,0x056a0,0x1a5b4,0x025d0,0x092d0,0x0d2b2,0x0a950,0x0b557,

0x06ca0,0x0b550,0x15355,0x04da0,0x0a5d0,0x14573,0x052d0,0x0a9a8,0x0e950,0x06aa0,

0x0aea6,0x0ab50,0x04b60,0x0aae4,0x0a570,0x05260,0x0f263,0x0d950,0x05b57,0x056a0,

0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d250,0x0d558,0x0b540,0x0b5a0,0x195a6,

0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,

0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06b58,0x055c0,0x0ab60,0x096d5,0x092e0,

0x0c960,0x0d954,0x0d4a0,0x0da50,0x07552,0x056a0,0x0abb7,0x025d0,0x092d0,0x0cab5,

0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,0x15176,0x052b0,0x0a930,

0x07954,0x06aa0,0x0ad50,0x05b52,0x04b60,0x0a6e6,0x0a4e0,0x0d260,0x0ea65,0x0d530,

0x05aa0,0x076a3,0x096d0,0x04bd7,0x04ad0,0x0a4d0,0x1d0b6,0x0d250,0x0d520,0x0dd45,

0x0b5a0,0x056d0,0x055b2,0x049b0,0x0a577,0x0a4b0,0x0aa50,0x1b255,0x06d20,0x0ada0);

var animals=new Array("鼠","牛","虎","兔","龙","蛇","马","羊","猴","鸡","狗","猪");

var gan=new Array("甲","乙","丙","丁","戊","己","庚","辛","壬","癸");

var zhi=new Array("子","丑","寅","卯","辰","巳","午","未","申","酉","戌","亥");

//var now = new Date(2008,3,27);

var sy = now.getFullYear(); 

var sm = now.getMonth();

var sd = now.getDate();

var xq = now.getDay();

//==== 传入 offset 传回干支, 0=甲子

function cyclical(num) { return(gan[num%10]+zhi[num%12])}

//==== 传回农历 y年的总天数

function lyeardays(y) {

var i, sum = 348

for(i=0x8000; i>0x8; i>>=1) sum += (lunarinfo[y-1900] & i)? 1: 0

return(sum+leapdays(y))

}

//==== 传回农历 y年闰月的天数

function leapdays(y) {

if(leapmonth(y))  return((lunarinfo[y-1900] & 0x10000)? 30: 29)

else return(0)

}

//==== 传回农历 y年闰哪个月 1-12 , 没闰传回 0

function leapmonth(y) { return(lunarinfo[y-1900] & 0xf)}

//====================================== 传回农历 y年m月的总天数

function monthdays(y,m) { return( (lunarinfo[y-1900] & (0x10000>>m))? 30: 29 )}

//==== 算出农历, 传入日期物件, 传回农历日期物件

//     该物件属性有 .year .month .day .isleap .yearcyl .daycyl .moncyl

function lunar(objdate) {

var i, leap=0, temp=0;

var basedate = new Date(1900,0,31);

var offset   = (objdate - basedate)/86400000;

this.daycyl = offset + 40;

this.moncyl = 14;

for(i=1900; i<2050 && offset>0; i++) {

temp = lyeardays(i);

offset -= temp;

this.moncyl += 12;

}

if(offset<0) {

offset += temp;

i--;

this.moncyl -= 12;

}

this.year = i;

this.yearcyl = i-1864;

leap = leapmonth(i); //闰哪个月

this.isleap = false

for(i=1; i<13 && offset>0; i++) {

//闰月

if(leap>0 && i==(leap+1) && this.isleap==false)

{ --i; this.isleap = true; temp = leapdays(this.year); }

else

{ temp = monthdays(this.year, i); }

//解除闰月

if(this.isleap==true && i==(leap+1)) this.isleap = false

offset -= temp

if(this.isleap == false) this.moncyl ++

}

if(offset==0 && leap>0 && i==leap+1)

if(this.isleap)

{ this.isleap = false; }

else

{ this.isleap = true; --i; --this.moncyl;}

if(offset<0){ offset += temp; --i; --this.moncyl; }

this.month = i

this.day = offset + 1

}

 function yymmdd(){ 

var cl = '<font color="#ff0000" style="font-size:9pt;">'+sy+'年'+(sm+1)+'月'+sd+'日</font>';

if (now.getday() == 0) cl = '<font color="#c00000" style="font-size:9pt;">'+sy+'年'+(sm+1)+'月'+sd+'日</font>';

if (now.getday() == 6) cl = '<font color="#00c000" style="font-size:9pt;">'+sy+'年'+(sm+1)+'月'+sd+'日</font>';

return(cl); 

 }

 function weekday(){ 

myArray = new Array(6);

myArray[0] = "星期日"

myArray[1] = "星期一"

myArray[2] = "星期二"

myArray[3] = "星期三"

myArray[4] = "星期四"

myArray[5] = "星期五"

myArray[6] = "星期六"

weekday = now.getDay();

document.write(myArray[weekday])

}

function cday(m,d){

 var nstr1 = new Array('日','一','二','三','四','五','六','七','八','九','十');

 var nstr2 = new Array('初','十','廿','卅','　');

 var s;

 if (m>10){s = '十'+nstr1[m-10]} else {s = nstr1[m]} s += '月'

 if (s=="十二月") s = "腊月";

 if (s=="一月") s = "正月";

 switch (d) {

case 10:s += '初十'; break;

case 20:s += '二十'; break;

case 30:s += '三十'; break;

default:s += nstr2[Math.floor(d/10)]; s += nstr1[d%10];

 }

 return(s);

}

 function solarday1(){

var sdobj = new Date(sy,sm,sd);

var ldobj = new lunar(sdobj);

var cl = '<font color="violet" style="font-size:9pt;">'; 

var tt = '【'+animals[(sy-4)%12]+'】'+cyclical(ldobj.moncyl)+'月 '+cyclical(ldobj.daycyl++)+'日' ;

document.write(cl+tt+'</font>');

 }

 function solarday2(){

var sdobj = new Date(sy,sm,sd);

var ldobj = new lunar(sdobj);

var cl = ''; 

//农历bb'+(cld[d].isleap?'闰 ':' ')+cld[d].lmonth+' 月 '+cld[d].lday+' 日

var tt = cday(ldobj.month,ldobj.day);

document.write('农历'+tt+'');

 }

 function solarday3(){

var sterminfo = new Array(0,21208,42467,63836,85337,107014,128867,150921,173149,195551,218072,240693,263343,285989,308563,331033,353350,375494,397447,419210,440795,462224,483532,504758)

var solarterm = new Array("小寒","大寒","立春","雨水","惊蛰","春分","清明","谷雨","立夏","小满","芒种","夏至","小暑","大暑","立秋","处暑","白露","秋分","寒露","霜降","立冬","小雪","大雪","冬至")

var lftv = new Array("0101*春节","0115 元宵节","0505 端午节","0707 七夕情人节","0715 中元节","0815 中秋节","0909 重阳节","1208 腊八节","1224 小年","0100*除夕")

var sftv = new Array("0101*元旦","0214 情人节","0308 妇女节","0309 偶今天又长一岁拉","0312 植树节","0315 消费者权益日","0401 愚人节","0418 mm的生日","0501 劳动节","0504 青年节","0512 护士节","0601 儿童节","0701 建党节 香港回归纪念",

"0801 建军节","0808 父亲节","0909 毛泽东逝世纪念","0910 教师节","0928 孔子诞辰","1001*国庆节",

"1006 老人节","1024 联合国日","1112 孙中山诞辰","1220 澳门回归纪念","1225 圣诞节","1226 毛泽东诞辰")

var sdobj = new Date(sy,sm,sd);

var ldobj = new lunar(sdobj);

var ldpos = new Array(3);

var festival='',solarterms='',solarfestival='',lunarfestival='',tmp1,tmp2;

//农历节日 

for(i in lftv)

if(lftv[i].match(/^(\d{2})(.{2})([\s\*])(.+)$/)) {

tmp1=number(regexp.$1)-ldobj.month

tmp2=number(regexp.$2)-ldobj.day

if(tmp1==0 && tmp2==0) lunarfestival=regexp.$4 

}

//国历节日

for(i in sftv)

if(sftv[i].match(/^(\d{2})(\d{2})([\s\*])(.+)$/)){

tmp1=number(regexp.$1)-(sm+1)

tmp2=number(regexp.$2)-sd

if(tmp1==0 && tmp2==0) solarfestival = regexp.$4 

}

//节气

tmp1 = new date((31556925974.7*(sy-1900)+sterminfo[sm*2+1]*60000)+date.utc(1900,0,6,2,5))

tmp2 = tmp1.getutcdate()

if (tmp2==sd) solarterms = solarterm[sm*2+1]  

tmp1 = new date((31556925974.7*(sy-1900)+sterminfo[sm*2]*60000)+date.utc(1900,0,6,2,5))

tmp2= tmp1.getutcdate()

if (tmp2==sd) solarterms = solarterm[sm*2] 

if(solarterms == '' && solarfestival == '' && lunarfestival == '')

festival = '';

else

festival = '<table width=100% border=0 cellpadding=2 cellspacing=0 bgcolor="#ccffcc"><tr><td>'+

'<font color="#000000" style="font-size:9pt;">'+solarterms + ' ' + solarfestival + ' ' + lunarfestival+'</font></td>'+

'</tr></table>';

var cl = '<font color="#000066" style="font-size:9pt;">';

//document.write(cl+festival+'</font>');

 }

 function setcalendar(){

document.write('<table align=center cellpadding=2 cellspacing=0 border=1><tr><td bgcolor=#fefeef><table border=0 cellpadding=0 cellspacing=0><tr><td align=center>');

document.write(yymmdd()+'&nbsp;&nbsp;'+weekday());

document.write('</td></tr>');

document.write('<tr><td align=center>'); 

document.write(solarday1());

document.write('</td></tr><tr><td align=center>'); 

document.write(solarday2());

document.write('</td></tr><tr><td>');

document.write(solarday3());

document.write('</td></tr></table></td></tr></table>');

 }
document.write(now.getFullYear()+"年"+(now.getMonth()+1)+"月"+now.getDate()+"日"); 
//document.write("&nbsp;&nbsp;");
//solarday2();
document.write("&nbsp;&nbsp;");
weekday();