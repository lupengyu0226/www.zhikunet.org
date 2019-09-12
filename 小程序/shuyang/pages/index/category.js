var app = getApp();
var SHUYANG = require('../../utils/SHUYANG.js');
Page({
    data: {
        hidden: false,
        loading: true
    },
    //事件处理函数
    categoryTo: function(e) {
        // console.log(e.currentTarget);
        var catid = e.currentTarget.id;
        wx.navigateTo({
          url: '../category/category?catid='+catid
        })
    },
    tagTo: function(e) {
        // console.log(e.currentTarget);
        var id = e.currentTarget.id;
        wx.navigateTo({
          url: '../tag/tag?id='+id
        })
    },
    getCategoryList() {
        this.setData({
            loading: false
        });
        var that = this;
        SHUYANG.GET(SHUYANG.API.index + '&view=map', function(json) {
            wx.setNavigationBarTitle({
                title: json.data.site.title+' - '+json.data.site.seotitle
            });
            that.setData({
                loading: true,
                hidden: true,
                tags: json.data.tags,
                categorys: json.data.category
            });
        });
    },
    refresh: function () {
    },
    loadMore: function () {
    },
    onLoad() {
        var that = this;
        this.getCategoryList();
    }
})
