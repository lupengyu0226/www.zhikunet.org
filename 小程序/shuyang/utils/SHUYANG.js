var SHUYANG = {
    HOST: 'https://app.05273.com/',
    get: function(url, callback) {
        wx.request({
            url: url,
            headers: {
                'Content-Type': 'application/json'
            },
            success(res) {
                if(typeof(callback) === "function") {
                    callback(res);
                }
            }
        })
    }
}
module.exports = {
    API: {
        index: SHUYANG.HOST + "index.php?app=mobile&controller=weapp",
        category: SHUYANG.HOST + "index.php?app=mobile&controller=weapp&view=lists",
        tag: SHUYANG.HOST + "public/api.php?app=tag&device=weapp&tpl=tag",
        article: SHUYANG.HOST + "index.php?app=mobile&controller=weapp&view=show"
    },
    GET: SHUYANG.get
};
