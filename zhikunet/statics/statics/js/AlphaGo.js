$.ajax({url:"http://weather.gtimg.cn/aqi/01011707.json",dataType:"jsonp",jsonpCallback:"city",success:function(data){for(var i=0,len=data.length;i<len;i++){if(data[i].station_code==null){var aqiBg=0;switch(true){case data[i].aqi>0&&data[i].aqi<=50:aqiBg=1;break;case data[i].aqi>50&&data[i].aqi<=100:aqiBg=2;break;case data[i].aqi>100&&data[i].aqi<=150:aqiBg=3;break;case data[i].aqi>150&&data[i].aqi<=200:aqiBg=4;break;case data[i].aqi>200&&data[i].aqi<=250:aqiBg=5;break;case data[i].aqi>250&&data[i].aqi<=300:aqiBg=6;break;case data[i].aqi>300&&data[i].aqi<=350:aqiBg=7;break;case data[i].aqi>350&&data[i].aqi<=400:aqiBg=8;break;case data[i].aqi>400:aqiBg=9;break};$('.weather-quality').html("空气:"+data[i].quality);$('.weather-pm').html("PM2.5:"+data[i].pm2_5);$('.weather-aqi').html("AQI:"+data[i].aqi);$('.weather-aqiimg').html("<img src=//statics.05273.cn/images/index/daqi/aqi_"+aqiBg+".png>");$('.weather-pm10').html("PM10:"+data[i].pm10);$('.weather-primary_pollutant').html("主要污染物:"+data[i].primary_pollutant);$('.weather-time').html("更新时间:"+data[i].time_point.replace(/T|Z/g," "))}}}});