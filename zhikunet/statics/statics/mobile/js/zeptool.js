;(function($,win,doc){
	$.tools = $.tools || {"version":"1.0"};
	// 全局配置
	var tool = $.tools = {
          conf: {
            debug: false,
            page: "data-role"
          },

          _private: {
            hash: ""
          }
    };

	var location = window.location;
		

  /**
   * zeptool 的构造函数
   * @param {Object} self zeptool 函数本身
   * @param {Object} conf zeptool 所依赖的配置对象
   * @return {Object} 处理完后的zeptool
   */
  function Zeptools( self, conf ){
    var _page = conf.page,
        _link = conf.link,
        _dire = conf.direction,
        _debug = conf.debug,
        touchEvent = {};
	
    if(!_debug){
      function Debug(){
        var _this = this;
        $.map(["log","dir","warn","error","info"],function(n){
          _this[n] = function(){ return; };
        })

        return _this;
      };
      window.console = Debug();
    }

    tool.conf = conf;
    tool.pages = getPageRoleArray(_page);

    // extend zeptool
    $.extend(self,{
      addlink: function( elem ){
        var href = elem.attr("href"),
            backhash = hash = getUrlHash(href)[0];

        if(hash == "#"){
          hash = tool.pages[0];
        }

        $.each(["direction","move"],function(i,n){
          hash += "_" + (elem.data(n) || "")
        });

        return elem.attr("href",href.replace(backhash,"") + hash);
      },
      removelink: function( $elem ){
        $elem.unbind("tap");
        return self;
      },
      animatepage: function( newhash, historyhash ){
        animateToPage(newhash, historyhash);
        return self;
      },
      changelocationhash: function( target, callback ){
        changelocationhash(target, callback);
        return self;
      },
      scrollto: function( yos, callback ){
        scrollTo( yos, callback );
        return self;
      },
      changeurl: function( url ){
        window.location.href = url;
        return self;
      }
    });

    $.extend(self,{
      msg: {
        show: function( txt ){
          //$("#msgbox").show().text( txt );
        },
        hide: function(){
          //$("#msgbox").empty().hide();
        }
      },
      cookie: {
        set: function(e, t, n, r, i) {
          typeof n == "undefined" && (n = new Date((new Date).getTime() + 36e5)),
          document.cookie = e + "=" + escape(t) + (n ? "; expires=" + n.toGMTString() : "") + (r ? "; path=" + r: "; path=/") + (i ? ";domain=" + i: "")
        },
        get: function(e) {
          var t = document.cookie.match(new RegExp("(^| )" + e + "=([^;]*)(;|$)"));
          return t != null ? unescape(t[2]) : null
        },
        clear: function(e, t, n) {
          this.get(e) && (document.cookie = e + "=" + (t ? "; path=" + t: "; path=/") + (n ? "; domain=" + n: "") + ";expires=Fri, 02-Jan-1970 00:00:00 GMT")
        }
      },
      boss: {
        getenginename: function(){
          return navigator.product;
        },
        getengineversion: function(){
          return navigator.userAgent;
        },
        getosname: function(){
          return navigator.platform;
        },
        getosversion: function(){
          return null;
        },
        getdevicemanufacturer: function(){
          return null;
        },
        getdevicemodel: function(){
          return null;
        },
        getdevicetype: function(){
          return null;
        }
      },
      browser: {
        getua: function( callback ){
          // TODO 访问时先检查缓存/Cookie，若没有则将检查结果存入缓存/Cookie
          var res = this.matchua(this.data, navigator.userAgent || navigator.appVersion || navigator.vendor);
          if(callback){
            callback.call(window,res);
          }
          return res;
        },
        getname: function(){
          return navigator.appName;
        },
        getversion: function(){
          return navigator.appVersion;
        },
        matchua: function(regex, ua){
          var _this = this,
              _result = [];
          $.each(regex,function(i,n){
            var reg = n.replace('/', '\/');
            reg = new RegExp(reg,"gi");
            (function(r,i){
              if(ua.match(reg)){
                _result.push(i);
              }
            })(reg,i);
          });
          return Boolean(_result.length);
        },
        data: {
          'iPhone': '(iPhone.*Mobile|iPod|iTunes)',
          'BlackBerry': 'BlackBerry|rim[0-9]+|PlayBook|BB10',
          'HTC': 'HTC|HTC.*(Sensation|Evo|Vision|Explorer|6800|8100|8900|A7272|S510e|C110e|Legend|Desire|T8282)|APX515CKT|Qtek9090|APA9292KT|HD_mini|Sensation.*Z710e|PG86100|Z715e|Desire.*(A8181|HD)|ADR6200|ADR6425|001HT|Inspire 4G',
          'Nexus': 'Nexus One|Nexus S|Galaxy.*Nexus|Android.*Nexus.*Mobile',
          'Dell': 'Dell.*Streak|Dell.*Aero|Dell.*Venue|DELL.*Venue Pro|Dell Flash|Dell Smoke|Dell Mini 3iX|XCD28|XCD35',
          'Motorola': 'Motorola|\bDroid\b.*Build|DROIDX|Android.*Xoom',
          'Samsung': 'Samsung|BGT-|GT-|SCH-|SGH-|SHW-|SPH-',
          'Sony': 'sony|SonyEricsson|SonyEricssonLT15iv|LT18i|E10i',
          'Asus': 'Asus.*Galaxy',
          'Palm': 'PalmSource|Palm',
          'Pantech': 'PANTECH',
          //'Micro': "MicroMessenger",  // todo: 针对微信的扩展，在此处识别
          'Ucweb': "JUC|IU|UCWEB", // todo: 极速模式使用JUC，另外在使用极速模式的时候服务器报500错误，待检查
          'QBrowse': "MQQBrowser",
          'GenericPhone': 'MB200C|MI-ONE'
        }
      }
    });

    // init
    var winWidth = $(window).width(), initHash;
    if(location.hash){
      initHash = location.hash.split("_");
      if($.inArray(initHash[0],tool.pages) < 0){
        location.hash = tool.pages[0];
      }
    }
    //if(!location.hash && !siteconfig.usertype){
	if(!location.hash){
      location.href += tool.pages[0]
    }
    tool._private.hash = location.hash.split("_");

    var incallBack = $(tool._private.hash[0]).css("z-index",1).data("incall");

    $(window).on("load",function(){
      execCallback(incallBack);
      setTimeout( function(){ scrollTo("top"); }, 50 );
      tempElem = undefined;
    });

    $.map(tool.pages,function(elemid){
      // TODO 直接在样式中定义
      $(elemid).css({
        "position": "absolute",
        "top": 0,
        "left": 0,
        "width": "100%",
        "z-index": 0
      });

      if(elemid != tool._private.hash[0]){
        $(elemid).hide();
      }
    });

    // toolbar fixed
    if($("[data-toolbar]").length > 0){
      $("[data-toolbar]").each(function(i,n){
        $(n).addClass("toolbar").parent("[data-role]").addClass("fixtoolar");
      });
    }

    // register nav button
    //if(!siteconfig.usertype){
      $("a").each(function(i,n){
        if($(n).attr("href").indexOf(":void") < 0 ){
          self.addlink($(n));
        }
      });
    //}

	
    // register url button
    $("[data-url]").each(function(i,n){
      var _this = $(n);
      _this.bind("click",function(){
        _this.addClass("on");
        setTimeout(function(){
          self.changeurl(_this.attr("data-url"));
          _this.removeClass("on");
        },500);
      })
    });

    // bind hashchange event
    hashChange(function( hash, historyhash ){
      var _hash = $.isArray(hash) ? hash[0] : hash;
      if($.inArray(_hash,tool.pages) >= 0){
        self.animatepage(hash, historyhash);
      }
      _hash = undefined;
    });

    return self;
  }

  function animateToPage( inhash, outhash ){
    // TODO 优化如下逻辑
    // 应该统一使用conf处理该处逻辑
    if(inhash && outhash){
      var direction = inhash[1] == "right" ? 1: -1,
          $inElem = $(inhash[0]),
          $outElem = $(outhash[0]),
          $header = $outElem.find("[data-toolbar = 'fixed']"),
          headoffset = $header.offset(),
          scrollCallback = inhash[2];

      $outElem.addClass("currentElem").removeClass("fixtoolar");
      $inElem.css("z-index",2).show();

      execCallback($inElem.data("incall"),$outElem.data("outcall"));

      //setTimeout(function(){
        $outElem.animate({
          translate3d: $outElem.width() * direction + "px,0,0"
        },300,'ease',function(){
          $outElem.css("-webkit-transform","none").removeClass("currentElem").addClass("fixtoolar").hide();

          if(scrollCallback){
            scrollTo(scrollCallback);
          }

          $outElem = $inElem = undefined;
        });
      //},500)
    }
  }

  function execCallback( incall, outcall ){
    $.each([incall,outcall],function(i,n){
      if(n && window[n]){
        window[n]();
      }
    });
  }

  function scrollTo( yos, callback ){
    if(!$.isNumber(yos)){
      if( yos == "top"){
        yos = 1;
      }else if(yos == "bottom"){
        yos = $(tool._private.hash[0]).height();
      }else{
        yos = null;
      }
    }

    if(yos !== null){
        window.scrollTo(0, yos);
        if(callback){
          callback.call(window);
        }
    }
    return self;
  }

  /**
   * 获取所有定义的跳转页数组
   * @param  {String} page 转向页的选择器
   * @return {Array}      跳转页数组
   */
  function getPageRoleArray( page ){
    var page_ary = [];
    $("["+page+"]").each(function(){
      page_ary.push("#"+this.id);
    })
    return page_ary;
  }

  /**
   * 将跳转页名称转换为跳转页索引
   * @param  {String} name  跳转页名称或者跳转页索引
   * @return {Number}       跳转页对应的索引值
   */
  function getPageIndex( name ){
    return $.isNumber(name) ? name : $.inArray(name, tool.pages);
  }

  /**
   * 更改页面hash
   * @param  {String} target 更改的hash值
   * @return {String}        hash值
   */
  function changelocationhash( target, callback ){
    var location_hash = getUrlHash()[0],
        location_href;

    if(!target){
      target = tool.pages[0];
    }

    if(location_hash != "#" && location_hash.length > 1){
      location_href = location.href.replace(location_hash,"@@@@@").replace("@@@@@",target);
    }else{
      location_href = location.href + target;
    }
    
    location.href = location_href;

    if(callback){
      callback.call(window, target)
    }

    return target;
  }

  // TODO 如果不支持locaiton.hash可使用该方法获取
  /**
   * 获取hash的辅助方法
   * @param  {String} url 当前的URL
   * @return {String}     获取到的url hash
   */
  function getUrlHash( url ) {
    // TODO 兼容性有待测试
    url = url || location.href;
    return ('#' + url.replace( /^[^#]*#?(.*)$/, '$1' )).split("_");
  };


  /**
   * onhashchange event
   * @param  {Function} startfn 当hash改变时的回调函数
   * @param  {Function} stopfn  结束监听时的回调函数（未实现）
   */
  function hashChange( startfn, stopfn ){
    var hash, historyhash, timeout_id, _this;
      // TODO 优化如下逻辑
      _this = {
        poll: function(){
          hash = ('#' + window.location.hash.replace( /^[^#]*#?(.*)$/, '$1' )).split("_"),
          hash = hash.length > 0 ? hash : tool._private.hash;

          historyhash = tool._private.hash;
          if ( hash[0] !== historyhash[0] ) {
            tool._private.hash = hash;
            startfn.call(window, hash, historyhash);
          }
          hash = undefined;
          timeout_id = undefined;
        },
        /*stop: function(){
          clearTimeout(timeout_id);
          stopfn.call(window, tool.normal.base)
        },*/
        start: function(){
          var self = this;
          if('onhashchange' in window){
            $(window).on("hashchange",self.poll);
          }else{
            timeout_id = setinterval( self.poll, 100 );
          }
        }
      }

      // TODO 抽出开始过程,增加结束状态
      _this.start();

    return;
  }
 
  /**
   * zepto 1.0+ will be support deep copying -> $.extend(true, target [source, ...])
   * this's simple deep copying
   * @return {Object}         new object !
   */
  $.deepcopy = function( target, copying ){
	//console.log(target);
	
    var config = {};
    for(var c in target){
      config[c] = target[c];
      if(copying){
        config[c] = copying[c] ? copying[c] : config[c];
      }
    }
	
    return config;
	
  }

  $.zeptool = function( conf ){
    conf = $.deepcopy(tool.conf, conf);

    // extend zepto.js
    $.extend($,{
      isNumber: function( obj  ){
        return !isNaN( parseFloat(obj) ) && isFinite( obj );
      }
    });

    return Zeptools(this.zeptool, conf);
  }
})(Zepto,window,document);

// 通过GET请求加载JS文件
(function($){
  var script,
      head = document.head || document.getElementsByTagName( "head" )[0] || document.documentElement;
  $.getscript = function(s, callback){
    script = document.createElement( "script" );
    script.async = "async";
    script.src = s;

    script.onload = script.onreadystatechange = function() {
      if ( !script.readyState || /loaded|complete/.test( script.readyState ) ) {
        script.onload = script.onreadystatechange = null;
        // Remove the script
        if ( head && script.parentNode ) {
          $(script).remove();
        }
        // Dereference the script
        script = undefined;

        if(callback){
          callback.call(window)
        }
      }
    };
    head.insertBefore( script, head.firstChild );
  }
})(Zepto);


window.zeptool = window.zeptool || $.zeptool();/*  |xGv00|a3351ec096f78c9f616aa7c2777fc357 */