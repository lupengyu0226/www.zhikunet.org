/*global jQuery, alert*/
(function (window, $) {
    'use strict';

    var data_forecast = null,
        query = '',
        CIICWeather = window.CIICWeather,
        areaid = 101191302,
        suggestions = CIICWeather.api_complete_list(),
        $home_bar = $('#home_bar'),
        $switch_cover = $('#switch_cover'),
        $switch_box = $('#switch_box'),
        $switch_text = $('#switch_text'),
        close_switch = function () {
            $switch_box.addClass('none');
            $switch_cover.addClass('none');
            $switch_text.val('');
        },
        render_widget = function (areaid) {
            $.getScript(CIICWeather.template(CIICWeather.SERVICE_FORECAST, {
                'areaid': areaid
            }));

        },
        data_ready = function () {
            var i, len, tmp_datebuf, tmp_datestr, tmp_date,
                week_str = ['日', '一', '二', '三', '四', '五', '六'],
                tpl = '<div class="weather-home-update">{update_time} 发布</div><a href="http://www.05273.com/" class="weather-home-copy"><span class="weather-quality"></span>  <span class="weather-pm"></span></a><div class="weather-home-locale"><span>{city}</span></div><div class="weather-home-icon"><img src="{icon}" /></div><div class="weather-home-temperature"><span class="fl">{temperature}</span><sup class="fl">℃</sup></div><div class="weather-home-forecast"><span class="f-hd"></span><span class="f-sky">{forecast}</span><span class="f-sep">|</span><span class="f-wind">{wind}</span><span class="f-sep">|</span><span class="f-sunrise">{sunrise}</span><span class="f-sep">-</span><span class="f-sunset">{sunset}</span><span class="f-ft"></span></div><div class="weather-home-tab"><a href="###" data-tab="weather-home-4day" class="cur">未来4天</a></div><ul class="weather-home-4day clearfix">{forecast_4day}</ul></div>',
                tpl_4day = '<li class="fl"><div class="weather-home-4day-day"><h4>{d}白天</h4><img src="{icon_d}" /><p>{forecast_d}/{temperature_d}℃</p></div><div class="weather-home-4day-night"><h4>{d}夜间</h4><img src="{icon_n}" /><p>{forecast_n}/{temperature_n}℃</p></div><div class="{cover}"></div></li>',
                param = {},
                city = data_forecast.city.c3,
                icon = (!!data_forecast.forecast.f1[0].fa ? 'd' + data_forecast.forecast.f1[0].fa : 'n' + data_forecast.forecast.f1[0].fb),
                temperature = (!!data_forecast.forecast.f1[0].fc ? data_forecast.forecast.f1[0].fc : data_forecast.forecast.f1[0].fd),
                forecast = (!!data_forecast.forecast.f1[0].fa ? data_forecast.forecast.f1[0].fa : data_forecast.forecast.f1[0].fb),
                wind_d = !!data_forecast.forecast.f1[0].fe ? data_forecast.forecast.f1[0].fe : data_forecast.forecast.f1[0].ff,
                wind_l = !!data_forecast.forecast.f1[0].fg ? data_forecast.forecast.f1[0].fg : data_forecast.forecast.f1[0].fh,
                sun = data_forecast.forecast.f1[0].fi.split('|'),
                forecast_4day = [],
            tmp_datebuf = data_forecast.forecast.f0.match(/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})/);
            tmp_datestr = tmp_datebuf[1] + '/' + tmp_datebuf[2] + '/' + tmp_datebuf[3] + ' ' + tmp_datebuf[4] + ':' + tmp_datebuf[5] + ':00';
            tmp_date = new Date(Date.parse(tmp_datestr));
            param.update_time = CIICWeather.template('{y}/{m}/{d} 周{w} {h}:{m}', {
                y: ('' + tmp_date.getFullYear()),
                m: (tmp_date.getMonth() > 8 ? '' + (tmp_date.getMonth() + 1) : '0' + (tmp_date.getMonth() + 1)),
                d: (tmp_date.getDate() > 9 ? '' + tmp_date.getDate() : '0' + tmp_date.getDate()),
                w: (week_str[tmp_date.getDay()]),
                h: (tmp_date.getHours() > 9 ? '' + tmp_date.getHours() : '0' + tmp_date.getHours()),
                i: (tmp_date.getMinutes() > 9 ? '' + tmp_date.getMinutes() : '0' + tmp_date.getMinutes())
            });
            $.ajax({
            url: "http://weather.gtimg.cn/aqi/cityrank.json",
            dataType: "jsonp",
            jsonpCallback: "cityrank",
            success: function(data) {
              for(var i = 0, len = data.length;i < len; i ++){
                if(data[i].id == "01011707"){
                  $('.weather-quality').html("空气:" + data[i].quality);
                  $('.weather-pm').html("PM2.5:" + data[i].pm2_5);
                    }
                  }
                }
            });

            param.city = city;
            param.icon = CIICWeather.template(CIICWeather.IMG_FORECAST, {
                forecast: icon
            });
            param.temperature = temperature;
            param.forecast = CIICWeather.RAW_MAP.forecast[forecast].cn;
            param.wind = CIICWeather.RAW_MAP.wind.direction[wind_d].cn + CIICWeather.RAW_MAP.wind.level[wind_l].text;
            param.sunrise = sun[0];
            param.sunset = sun[1];

            for (i = 0, len = data_forecast.forecast.f1.length; i < len; i++) {
                var tmp = {};
                tmp.d = (0 == i ? '今天' : (new Date(tmp_date.getTime() + 86400000 * i)).getDate() + '日');
                tmp.cover = (0 == i % 2 ? 'odd' : 'even');

                tmp.icon_d = CIICWeather.template(CIICWeather.IMG_FORECAST, {
                    forecast: (!!data_forecast.forecast.f1[i].fa ? 'd' + data_forecast.forecast.f1[i].fa : 'd99')
                });
                tmp.icon_n = CIICWeather.template(CIICWeather.IMG_FORECAST, {
                    forecast: (!!data_forecast.forecast.f1[i].fb ? 'n' + data_forecast.forecast.f1[i].fb : 'n99')
                });
                tmp.forecast_d = (!!data_forecast.forecast.f1[i].fa ? CIICWeather.RAW_MAP.forecast[data_forecast.forecast.f1[i].fa].cn : '--');
                tmp.forecast_n = (!!data_forecast.forecast.f1[i].fb ? CIICWeather.RAW_MAP.forecast[data_forecast.forecast.f1[i].fb].cn : '--');
                tmp.temperature_d = (!!data_forecast.forecast.f1[i].fc ? data_forecast.forecast.f1[i].fc : '--');
                tmp.temperature_n = (!!data_forecast.forecast.f1[i].fd ? data_forecast.forecast.f1[i].fd : '--');
                forecast_4day.push(CIICWeather.template(tpl_4day, tmp));
            }
            param.forecast_4day = forecast_4day.join('');
            $home_bar.html(CIICWeather.template(tpl, param));
        };
    
    $.ajaxSetup({
        cache: true
    });

    window.cb_forecast = function (data) {
        data_forecast = data;
        if (!!data_forecast) {
            data_ready();
        }
    };

    $home_bar.on('click', '#switch_btn', function () {
        $switch_box.removeClass('none');
        $switch_cover.removeClass('none');
    });

    // init
    areaid = !!areaid ? areaid : CIICWeather.DEFAULT_AREAID;

    $switch_text.autocomplete({
        lookup: suggestions,
        appendTo: '#switch_box',
        onSelect: function (suggestion) {
            areaid = suggestion.data;
        }
    });
    query = location.search.match(/\?areaid=(\d+)/i);
    if (!!query && !!query[1] && !!CIICWeather.api_city_info(query[1])) {
        render_widget(query[1]);
        return;
    }
    render_widget(areaid);
}(window, jQuery));