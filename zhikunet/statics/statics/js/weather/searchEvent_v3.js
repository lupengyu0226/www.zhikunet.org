/* 2015-11-23 15:45 修改搜索功能 */
var q = {};
q.$ = function (o) {
    return document.getElementById(o);
}
q.addEvent = function (obj, handle, fn) {
    if (obj.attachEvent) {
        obj.attachEvent('on' + handle, fn);
    } else if (obj.addEventListener) {
        obj.addEventListener(handle, fn, false);
    }
}

function AutoSearch(inputId, tabId, tipIdistId) {
    this.inputId = inputId;
    this.tabId = tabId;
    this.tipIdistId = tipIdistId;
    this.inputBox = q.$(this.inputId);
    this.tabBox = q.$(this.tabId);
    this.tipIdistBox = q.$(this.tipIdistId);
    this.idx = 0;
}

AutoSearch.prototype = {
    iputFn: function () {
        //this.tabBox.style.display = 'block';
        $("#city-box .city-list").hide().eq(this.idx).show();
        if (this.inputBox.value == '输入地名、拼音均可') {
            this.inputBox.value = '';
        }
    },
    slimWords: function (str) {
        var s = str.toLowerCase();
        if (s.indexOf('<strong>') != -1) {
            var rg0 = /<strong>/g;
            var rg1 = /<\/strong>/g;
            s = s.replace(rg0, '');
            s = s.replace(rg1, '');
        }
        return s;
    },
    keyUpFn: function () {
        //this.tabBox.style.display = 'none';
        $("#city-box .city-list").eq(this.idx).hide();
        var searchTxt = this.inputBox.value;
        searchTxt = searchTxt.toLowerCase();
        var tempStore = document.createElement('ul');
        var cityData = mySite.cityData;
        var pageName = indexName;

        switch(this.idx){
            case 1:
                cityData = mySite.qualityData;
                pageName = qualityName;
                break;
            default:
                cityData = mySite.cityData;
                pageName = indexName;
                break;
        }

        var dataNum = cityData.length;
        var letterNum = searchTxt.length;

        if (letterNum <= 0) {
            this.tipIdistBox.innerHTML = '';
            this.inputBox.name = '';
            this.tipIdistBox.style.display = 'none';
            return;
        }
        this.tipIdistBox.style.display = 'block';
        var resultStr0 = resultStr1 = null;
        var resultIndex0 = resultIndex1 = null;

        var blanceIndex = 0;

        for (var i = 0; i < dataNum; i++) {

            resultStr0 = cityData[i].title;
            resultStr1 = cityData[i].spell;
            resultStr2 = cityData[i].province;
            resultStr3 = cityData[i].code;

            resultIndex0 = resultStr0.indexOf(searchTxt);
            resultIndex1 = resultStr1.indexOf(searchTxt);

            if (resultIndex0 >= 0) {
                if (blanceIndex > 9) {
                    blanceIndex = 0
                    break;
                }
                blanceIndex++;

                if (resultIndex0 == 0) {
                    tempStore.innerHTML += '<li id="' + resultStr3 + '"><strong>' + resultStr0.substr(0, letterNum) + '</strong>' + resultStr0.substr(letterNum) + '(' + resultStr1 + ')-' + resultStr2 + '</li>';
                } else {
                    tempStore.innerHTML += '<li id="' + resultStr3 + '">' + resultStr0.substr(0, resultIndex0) + '<strong>' + resultStr0.substr(resultIndex0, letterNum) + '</strong>' + resultStr0.substr((resultIndex0 + letterNum)) + '(' + resultStr1 + ')-' + resultStr2 + '</li>';
                }
            } else if (resultIndex1 >= 0) {
                if (blanceIndex > 9) {
                    blanceIndex = 0
                    break;
                }
                blanceIndex++;

                if (resultIndex1 == 0) {
                    tempStore.innerHTML += '<li id="' + resultStr3 + '">' + resultStr0 + '(<strong>' + resultStr1.substr(0, letterNum) + '</strong>' + resultStr1.substr(letterNum) + ')-' + resultStr2 + '</li>';
                } else {
                    tempStore.innerHTML += '<li id="' + resultStr3 + '">' + resultStr0 + '(' + resultStr1.substr(0, resultIndex1) + '<strong>' + resultStr1.substr(resultIndex1, letterNum) + '</strong>' + resultStr1.substr((resultIndex1 + letterNum)) + ')-' + resultStr2 + '</li>';
                }
            }
        }
        if (tempStore.innerHTML == '') {
            tempStore.innerHTML = '<li>暂无</li>';
        }

        var searchList = tempStore.getElementsByTagName('li');
        var searchListNum = searchList.length;

        if (searchListNum > 0) {
            searchList[0].className = 'current';
        }

        this.tipIdistBox.innerHTML = tempStore.innerHTML;

        var currentIndex = 0;
        var item = this.tipIdistBox.getElementsByTagName('li');
        var that = this;
        for (var m = 0; m < searchListNum; m++) {
            item[m].onmouseover = (function (j) {
                return function () {
                    for (var n = 0; n < searchListNum; n++) {
                        if (n == j) {
                            item[n].className = 'current';
                            currentIndex = n;
                        } else {
                            item[n].className = '';
                        }
                    }
                }
            })(m);

            item[m].onclick = (function (k) {
                return function () {
                    that.inputBox.value = that.slimWords(item[k].innerHTML.split('(')[0]);
                    that.inputBox.name = item[currentIndex].id;
                    var tag = item[currentIndex].id ? "?icity=" + item[currentIndex].id : "";
                    $("#wSearchBtn").attr({"href": pageName + tag});
                    $("#wSearchBtn").attr({"target": "_self"});
                    that.tipIdistBox.style.display = 'none';
                }
            })(m);
        }

        document.onkeydown = function (e) {
            var evt = e || window.event;
            if ((evt.keyCode == 38) || (evt.keyCode == 40) || (evt.keyCode == '13')) {
                that.inputBox.blur();
            }

            if (evt.keyCode == 38) {
                item[currentIndex].className = '';
                currentIndex--;
                if (currentIndex < 0) {
                    currentIndex = searchListNum - 1;
                }
                item[currentIndex].className = 'current';
                return false;
            } else if (evt.keyCode == 40) {
                item[currentIndex].className = '';
                currentIndex++;
                if (currentIndex >= searchListNum) {
                    currentIndex = 0;
                }
                item[currentIndex].className = 'current';
                return false;
            } else if (evt.keyCode == '13') {
                that.inputBox.value = that.slimWords(item[currentIndex].innerHTML.split('(')[0]);
                that.inputBox.name = item[currentIndex].id;
                that.tipIdistBox.style.display = 'none';
                var tag = item[currentIndex].id ? "?icity=" + item[currentIndex].id : "";
                $("#wSearchBtn").attr({"href": pageName + tag});
                $("#wSearchBtn").attr({"target": "_self"});
                $("#wSearchBtn").focus();
            }
        }
    },
    keyUpDown: function (event) {
        var evt = event || window.event;
        var target = evt.srcElement || evt.target;

        if (this.tipIdistBox.style.display == 'block') {
            if ((target.id != this.tipIdistId) && (target.id != this.inputId)) {
                this.tipIdistBox.style.display = 'none';
                this.inputBox.value = '输入地名、拼音均可';
            }
        }

        if ($("#city-box .city-list").eq(this.idx).css("display") == 'block') {
            if ((target.id != this.tabId) && (target.id != this.inputId)) {
                //this.tabBox.style.display = 'none';
                $("#city-box .city-list").eq(this.idx).hide();
                this.inputBox.value = '输入地名、拼音均可';
            }
        }
    },
    init: function () {
        var that = this;
        q.addEvent(this.inputBox, 'click', function () { that.iputFn() });
        q.addEvent(this.inputBox, 'keyup', function () { that.keyUpFn() });
        q.addEvent(document, 'click', function (e) { that.keyUpDown(e) });

        // 城市天气链接
        $("#city-box .city-list").eq(0).find("a").each(function(i, obj){
            $(obj).attr({"href": indexName + $(obj).attr("href")});
        });

        // 空气质量链接
        $("#city-box .city-list").eq(1).find("a").each(function(i, obj){
            $(obj).attr({"href": qualityName + $(obj).attr("href")});
        });

        $(".search-box .stab-hd li").each(function(index, obj){
            $(obj).click(function(e){
                e.stopPropagation();
                $("#suggest-box").hide();
                $(".search-box .stab-hd li").removeClass("current");
                $(this).addClass("current");
                that.idx = index;
                that.inputBox.value = '输入地名、拼音均可';
                $("#city-box .city-list").hide();//.eq(that.idx).show();
            });
            if($(obj).hasClass("current")){
                that.idx = index;
            };

        });

        // 修复firefox 搜索按钮bug
        $("#wSearchBtn").attr({"target":""});
        $("#wSearchBtn").on("click", function(e){
            e.stopPropagation();
            var _v = $("#wSearch").val();
            if(_v == "输入地名、拼音均可"){
                $("#wSearch").html("请输入查询的城市");
                setTimeout(function(){
                    $("#wSearch").html("输入地名、拼音均可");
                }, 1000);
            }
        });
    }
}


var autoSearch0 = new AutoSearch('wSearch', 'city-box', 'suggest-box');
    autoSearch0.init();