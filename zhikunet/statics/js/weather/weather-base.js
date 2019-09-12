/* CIICWeather */
(function (bootstrap) {
    'use strict';
    bootstrap(window);
}(function (window) {
    'use strict';
    var CIICWeather = window.CIICWeather || {},
        w_nav_home = document.getElementById('weather_nav'),
        w_nav = document.getElementById('weather_nav2'),
        w_home = document.getElementById('weather_home'),
        w_widget = document.getElementById('weather_widget');

    // Util function
    CIICWeather.template = function(tpl,data){var attr,result=tpl;for(attr in data){result=result.replace(new RegExp("{"+attr+"}","img"),data[attr])}return result};
    CIICWeather.embed_script = function(url){var el_script=document.createElement("script"),el_head=document.getElementsByTagName("head")[0]||document.documentElement;el_script.src=url;el_script.charset="UTF-8";el_head.appendChild(el_script)};

    // API function
    CIICWeather.api_complete_list = function () {
        var i, len, item, list = [];
        for (i = 0, len = CIICWeather.RAW_NATIVE.length; i < len; i += 1) {
            item = CIICWeather.RAW_NATIVE[i];
            list.push({
                value: item.namecn,
                data: item.areaid
            }, {
                value: item.nameen,
                data: item.areaid
            });
        }
        for (i = 0, len = CIICWeather.RAW_ABROAD.length; i < len; i += 1) {
            item = CIICWeather.RAW_ABROAD[i];
            list.push({
                value: item.namecn,
                data: item.areaid
            }, {
                value: item.nameen,
                data: item.areaid
            });
        }
        return list;
    };
    
    CIICWeather.api_city_info = function (areaid) {
        var i, item;
        for (i in CIICWeather.RAW_NATIVE) {
            item = CIICWeather.RAW_NATIVE[i];
            if (item.areaid === areaid) {
                return item;
            }
        }
        for (i in CIICWeather.RAW_ABROAD) {
            item = CIICWeather.RAW_ABROAD[i];
            if (item.areaid === areaid) {
                return item;
            }
        }
        return false;
    };

    // Const
    CIICWeather.SERVICE_FORECAST = 'http://api.weather.china.com.cn/weather/data/f101191302.js';
    CIICWeather.SERVICE_REAL = '';
    CIICWeather.FRONTEND_ACTION = 'http://www.05273.com/';
    CIICWeather.IMG_FORECAST = 'http://statics.05273.cn/js/weather/icon/{forecast}.png';
    CIICWeather.DEFAULT_AREAID = '101191302';
    CIICWeather.RAW_NATIVE = [{"areaid":"101191302","nameen":"shuyang","namecn":"沭阳","districten":"suqian","districtcn":"宿迁","proven":"jiangsu","provcn":"江苏","nationen":"china","nationcn":"中国"}];
    CIICWeather.RAW_ABROAD = [];
    CIICWeather.ICON = {"n302":"&#xe600;","n301":"&#xe601;","n99":"&nbsp;","n58":"&#xe603;","n57":"&#xe604;","n56":"&#xe605;","n55":"&#xe606;","n54":"&#xe607;","n53":"&#xe608;","n49":"&#xe609;","n33":"&#xe60a;","n32":"&#xe60b;","n31":"&#xe60c;","n30":"&#xe60d;","n29":"&#xe60e;","n28":"&#xe60f;","n27":"&#xe610;","n26":"&#xe611;","n25":"&#xe612;","n24":"&#xe613;","n23":"&#xe614;","n22":"&#xe615;","n21":"&#xe616;","n20":"&#xe617;","n19":"&#xe618;","n18":"&#xe619;","n17":"&#xe61a;","n16":"&#xe61b;","n15":"&#xe61c;","n14":"&#xe61d;","n13":"&#xe61e;","n12":"&#xe61f;","n11":"&#xe620;","n10":"&#xe621;","n09":"&#xe622;","n08":"&#xe623;","n07":"&#xe624;","n06":"&#xe625;","n05":"&#xe626;","n04":"&#xe627;","n03":"&#xe628;","n02":"&#xe629;","n01":"&#xe62a;","n00":"&#xe62b;","d302":"&#xe62c;","d301":"&#xe62d;","d99":"&nbsp;","d58":"&#xe62f;","d57":"&#xe630;","d56":"&#xe631;","d55":"&#xe632;","d54":"&#xe633;","d53":"&#xe634;","d49":"&#xe635;","d33":"&#xe636;","d32":"&#xe637;","d31":"&#xe638;","d30":"&#xe639;","d29":"&#xe63a;","d28":"&#xe63b;","d27":"&#xe63c;","d26":"&#xe63d;","d25":"&#xe63e;","d24":"&#xe63f;","d23":"&#xe640;","d22":"&#xe641;","d21":"&#xe642;","d20":"&#xe643;","d19":"&#xe644;","d18":"&#xe645;","d17":"&#xe646;","d16":"&#xe647;","d15":"&#xe648;","d14":"&#xe649;","d13":"&#xe64a;","d12":"&#xe64b;","d11":"&#xe64c;","d10":"&#xe64d;","d09":"&#xe64e;","d08":"&#xe64f;","d07":"&#xe650;","d06":"&#xe651;","d05":"&#xe652;","d04":"&#xe653;","d03":"&#xe654;","d02":"&#xe655;","d01":"&#xe656;","d00":"&#xe657;"};
    CIICWeather.RAW_MAP = {"forecast":{"00":{"cn":"晴","en":"Sunny"},"01":{"cn":"多云","en":"Cloudy"},"02":{"cn":"阴","en":"Overcast"},"03":{"cn":"阵雨","en":"Shower"},"04":{"cn":"雷阵雨","en":"Thundershower"},"05":{"cn":"雷阵雨伴有冰雹","en":"Thundershower with hail"},"06":{"cn":"雨夹雪","en":"Sleet"},"07":{"cn":"小雨","en":"Light rain"},"08":{"cn":"中雨","en":"Moderate rain"},"09":{"cn":"大雨","en":"Heavy rain"},"10":{"cn":"暴雨","en":"Storm"},"11":{"cn":"大暴雨","en":"Heavy storm"},"12":{"cn":"特大暴雨","en":"Severe storm"},"13":{"cn":"阵雪","en":"Snow flurry"},"14":{"cn":"小雪","en":"Light snow"},"15":{"cn":"中雪","en":"Moderate snow"},"16":{"cn":"大雪","en":"Heavy snow"},"17":{"cn":"暴雪","en":"Snowstorm"},"18":{"cn":"雾","en":"Foggy"},"19":{"cn":"冻雨","en":"Ice rain"},"20":{"cn":"沙尘暴","en":"Duststorm"},"21":{"cn":"小到中雨","en":"Light to moderate rain"},"22":{"cn":"中到大雨","en":"Moderate to heavy rain"},"23":{"cn":"大到暴雨","en":"Heavy rain to storm"},"24":{"cn":"暴雨到大暴雨","en":"Storm to heavy storm"},"25":{"cn":"大暴雨到特大暴雨","en":"Heavy to severe storm"},"26":{"cn":"小到中雪","en":"Light to moderate snow"},"27":{"cn":"中到大雪","en":"Moderate to heavy snow"},"28":{"cn":"大到暴雪","en":"Heavy snow to snowstorm"},"29":{"cn":"浮尘","en":"Dust"},"30":{"cn":"扬沙","en":"Sand"},"31":{"cn":"强沙尘暴","en":"Sandstorm"},"53":{"cn":"霾","en":"Haze"},"99":{"cn":"无","en":"Unknown"}},"wind":{"direction":{"0":{"cn":"无持续风向","en":"No wind"},"1":{"cn":"东北风","en":"Northeast"},"2":{"cn":"东风","en":"East"},"3":{"cn":"东南风","en":"Southeast"},"4":{"cn":"南风","en":"South"},"5":{"cn":"西南风","en":"Southwest"},"6":{"cn":"西风","en":"West"},"7":{"cn":"西北风","en":"Northwest"},"8":{"cn":"北风","en":"North"},"9":{"cn":"旋转风","en":"Whirl wind"}},"level":{"0":{"text":"微风","unit":"<10m/h"},"1":{"text":"3-4级","unit":"10~17m/h"},"2":{"text":"4-5级","unit":"17~25m/h"},"3":{"text":"5-6级","unit":"25~34m/h"},"4":{"text":"6-7级","unit":"34~43m/h"},"5":{"text":"7-8级","unit":"43~54m/h"},"6":{"text":"8-9级","unit":"54~65m/h"},"7":{"text":"9-10级","unit":"65~77m/h"},"8":{"text":"10-11级","unit":"77~89m/h"},"9":{"text":"11-12级","unit":"89~102m/h"}}}};
    
    // init
    if (!!w_home) {
        w_home.innerHTML = '<div class="weather-home-bar bc" id="home_bar"></div>';
    }

    window.CIICWeather = CIICWeather;
}));