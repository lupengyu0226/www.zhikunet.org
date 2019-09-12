var app = getApp();
var SHUYANG = require('../../utils/SHUYANG.js');
Page({
    data: {
        subTitle:null,
        scrollH:0,
        hidden: false,
        duration: 2000,
        indicatorDots: true,
        autoplay: true,
        circular: true,
        interval: 3000,
        loading: true,
        pageNum:1,
        pageLast:false,
        news:[],
        video:[],
        CATID:null
    },
    getList() {
        if(this.data.pageLast) return;
        this.setData({
            loading: false
        });
        var that = this;
        SHUYANG.GET(SHUYANG.API.category + '&catid=3369&page=' + this.data.pageNum, function(json) {
            wx.setNavigationBarTitle({
                title: json.data.category.name+' - '+json.data.site.seotitle
            });
            that.setData({
                loading: true,
                hidden: true,
                subTitle:json.data.category.name,
                video: json.data.video,
                hots: json.data.hots,
                video: that.data.video.concat(json.data.video)
            });
            if(json.data.PAGE){
                that.setData({
                    pageLast: json.data.PAGE.LAST
                });
            }
        });
    },
    refresh: function () {},
    loadMore: function () {
      // console.log('loadMore');
      ++this.data.pageNum;
      this.getList();
    },
    onLoad(options) {
        var that = this;
        wx.getSystemInfo({
            success(res) {
                that.setData({
                    scrollH: res.windowHeight
                });
            }
        });
        //console.log(options);
        this.data.CATID = options.catid;
        this.getList();
    }
})
