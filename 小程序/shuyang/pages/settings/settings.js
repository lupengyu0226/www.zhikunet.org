var app = getApp();
var SHUYANG = require('../../utils/SHUYANG.js');
Page({
  data: {
   text:'尊敬的用户您好！欢迎使用沭阳网小程序',
   nickName:'',
   userInfoAvatar:'',
   sex:''
  }, 
  onLoad: function () {
    var that=this;    
    wx.getUserInfo({
      success: function(res){
        // success
        that.setData({
          nickName:res.userInfo.nickName,
          userInfoAvatar:res.userInfo.avatarUrl,
          province:res.userInfo.province,
          city:res.userInfo.city
        })
        switch(res.userInfo.gender){
          case 0: 
            that.setData({
              sex:'我还不知道你性别哦'
            })
          break;
          case 1: 
            that.setData({
              sex:'帅哥你好'
            })
          break;
          case 2: 
            that.setData({
              sex:'美女你好'
            })
          break;
        }
      },
      fail: function() {
      },
      complete: function() {
      }
    })
  },
  navToPage(event) {
    var route = event.currentTarget.dataset.route
    wx.navigateTo({
      url: route
    })
  }
})