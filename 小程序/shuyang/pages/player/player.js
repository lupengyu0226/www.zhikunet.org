var app = getApp();
var SHUYANG = require('../../utils/SHUYANG.js');
var WxParse = require('../../utils/wxParse/wxParse.js');
Page({
    data: {
        video: [],
        hidden: false
    },
    video: function(catid,id) {
        var that = this;
        SHUYANG.GET(SHUYANG.API.article + '&catid=' + catid + '&id=' + id, function(json) {
            // console.log(json);
            wx.setNavigationBarTitle({
                title: json.data.category.name+' - '+json.data.site.name
            });
            WxParse.wxParse('body', 'html', json.data.video.body, that, 5);
            that.setData({
                video: json.data.video,
                category: json.data.category,
                hidden: true
            });
        });
    },
    onLoad: function(options) {
        this.video(options.catid,options.id);
        // 页面初始化 options为页面跳转所带来的参数
    },
    onReady: function() {
        // 页面渲染完成
    },
    onShow: function() {
        // 页面显示
    },
    onHide: function() {
        // 页面隐藏
    },
    onUnload: function() {
        // 页面关闭
    }
})
