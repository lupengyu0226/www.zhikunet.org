var regexEnum = 
{
	intege:"^-?[1-9]\\d*$",					//鏁存暟
	intege1:"^[1-9]\\d*$",					//姝ｆ暣鏁?
	intege2:"^-[1-9]\\d*$",					//璐熸暣鏁?
	num:"^([+-]?)\\d*\\.?\\d+$",			//鏁板瓧
	num1:"^[1-9]\\d*|0$",					//姝ｆ暟锛堟鏁存暟 + 0锛?
	num2:"^-[1-9]\\d*|0$",					//璐熸暟锛堣礋鏁存暟 + 0锛?
	decmal:"^([+-]?)\\d*\\.\\d+$",			//娴偣鏁?
	decmal1:"^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*$",銆€銆€	//姝ｆ诞镣规暟
	decmal2:"^-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*)$",銆€ //璐熸诞镣规暟
	decmal3:"^-?([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0)$",銆€ //娴偣鏁?
	decmal4:"^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0$",銆€銆€ //闱炶礋娴偣鏁帮纸姝ｆ诞镣规暟 + 0锛?
	decmal5:"^(-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*))|0?.0+|0$",銆€銆€//闱炴娴偣鏁帮纸璐熸诞镣规暟 + 0锛?

	email:"^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$", //闾欢
	color:"^[a-fA-F0-9]{6}$",				//棰滆壊
	url:"^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&=]*)?$",	//url
	chinese:"^[\\u4E00-\\u9FA5\\uF900-\\uFA2D]+$",					//浠呬腑鏂?
	ascii:"^[\\x00-\\xFF]+$",				//浠匒CSII瀛楃
	zipcode:"^\\d{6}$",						//闾紪
	mobile:"^(13|15)[0-9]{9}$",				//镓嬫満
	ip4:"^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$",	//ip鍦板潃
	notempty:"^\\S+$",						//闱炵┖
	picture:"(.*)\\.(jpg|bmp|gif|ico|pcx|jpeg|tif|png|raw|tga)$",	//锲剧墖
	rar:"(.*)\\.(rar|zip|7zip|tgz)$",								//铡嬬缉鏂囦欢
	date:"^\\d{4}(\\-|\\/|\.)\\d{1,2}\\1\\d{1,2}$",					//镞ユ湡
	qq:"^[1-9]*[1-9][0-9]*$",				//QQ鍙风爜
	tel:"^(([0\\+]\\d{2,3}-)?(0\\d{2,3})-)?(\\d{7,8})(-(\\d{3,}))?$",	//鐢佃瘽鍙风爜镄勫嚱鏁?鍖呮嫭楠岃瘉锲藉唴鍖哄佛,锲介台鍖哄佛,鍒嗘満鍙?
	username:"^\\w+$",						//鐢ㄦ潵鐢ㄦ埛娉ㄥ唽銆傚尮閰岖敱鏁板瓧銆?6涓嫳鏂囧瓧姣嶆垨钥呬笅鍒掔嚎缁勬垚镄勫瓧绗︿覆
	letter:"^[A-Za-z]+$",					//瀛楁瘝
	letter_u:"^[A-Z]+$",					//澶у啓瀛楁瘝
	letter_l:"^[a-z]+$",					//灏忓啓瀛楁瘝
	idcard:"^[1-9]([0-9]{14}|[0-9]{17})$",	//韬唤璇?
	ps_username:"^[\\u4E00-\\u9FA5\\uF900-\\uFA2D_\\w]+$" //涓枃銆佸瓧姣嶃€佹暟瀛?_
}

function isCardID(sId){ 
	var iSum=0 ;
	var info="" ;
	if(!/^\d{17}(\d|x)$/i.test(sId)) return "浣犺緭鍏ョ殑韬唤璇侀昵搴︽垨镙煎纺阌栾"; 
	sId=sId.replace(/x$/i,"a"); 
	if(aCity[parseInt(sId.substr(0,2))]==null) return "浣犵殑韬唤璇佸湴鍖洪潪娉?; 
	sBirthday=sId.substr(6,4)+"-"+Number(sId.substr(10,2))+"-"+Number(sId.substr(12,2)); 
	var d=new Date(sBirthday.replace(/-/g,"/")) ;
	if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate()))return "韬唤璇佷笂镄勫嚭鐢熸棩链熼潪娉?; 
	for(var i = 17;i>=0;i --) iSum += (Math.pow(2,i) % 11) * parseInt(sId.charAt(17 - i),11) ;
	if(iSum%11!=1) return "浣犺緭鍏ョ殑韬唤璇佸佛闱炴硶"; 
	return true;//aCity[parseInt(sId.substr(0,2))]+","+sBirthday+","+(sId.substr(16,1)%2?"鐢?:"濂?) 
} 


//鐭椂闂达紝褰㈠ (13:04:06)
function isTime(str)
{
	var a = str.match(/^(\d{1,2})(:)?(\d{1,2})\2(\d{1,2})$/);
	if (a == null) {return false}
	if (a[1]>24 || a[3]>60 || a[4]>60)
	{
		return false;
	}
	return true;
}

//鐭棩链燂紝褰㈠ (2003-12-05)
function isDate(str)
{
	var r = str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/); 
	if(r==null)return false; 
	var d= new Date(r[1], r[3]-1, r[4]); 
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]);
}

//闀挎椂闂达紝褰㈠ (2003-12-05 13:04:06)
function isDateTime(str)
{
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/; 
	var r = str.match(reg); 
	if(r==null) return false; 
	var d= new Date(r[1], r[3]-1,r[4],r[5],r[6],r[7]); 
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]&&d.getHours()==r[5]&&d.getMinutes()==r[6]&&d.getSeconds()==r[7]);
}