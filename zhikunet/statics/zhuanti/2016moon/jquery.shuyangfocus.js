/**
 * @version 0.1.2
 * @author  E.D.I
 * @update  2016-09-05 10:28
 */
(function($){
    /**
     * @name    shuyangfocus     ҳ������
     * @param   {Object}    ��ʼֵ
     */
    $.fn.shuyangfocus = function(options){
        var focuser = {};
        var opts = $.extend({}, {
            event: 'mouseover',     //mouseover click
            conbox: '.focus_con',   //��������
            condot: '.focus_dot',   //�л�����
            conitem: '.item',       //���ݱ�ǩclass
            dotitem: 'a',           //�л�����ǩ Ĭ��Ϊa
            current: 'current',     //�л���ʽ
            effect: 'fade',         //�л�Ч�� scrollx|scrolly|fade|none
            speed: 1000,            //�����ٶ�
            space: 3000,            //ʱ����
            auto: true              //�Զ�����
        }, options);
        focuser.timer = "";
        focuser.index = 0;
        focuser.last_index = 0;
        focuser.conbox = $(this).find(opts.conbox);
        focuser.conitem = focuser.conbox.find(opts.conitem);
        focuser.condot = $(this).find(opts.condot);
        focuser.dotitem = focuser.condot.find(opts.dotitem);
        focuser.fn = {
            slide: function () {
                if (focuser.index >= focuser.conitem.length){
                    focuser.index = 0;
                }
                focuser.dotitem.removeClass(opts.current).eq(focuser.index).addClass(opts.current);
                switch (opts.effect) {
                    case 'scrollx':
                        focuser.conitem.css({"float":"left"});
                        focuser.conbox.css({"position": "relative"});
                        focuser.conbox.width(focuser.conitem.length * focuser.conitem.width());
                        focuser.conbox.stop().animate({left:-focuser.conitem.width() * focuser.index}, opts.speed);
                        break;
                    case 'scrolly':
                        focuser.conitem.css({display:'block'});
                        focuser.conbox.css({"position": "relative"});
                        focuser.conbox.stop().animate({top:-focuser.conitem.height() * focuser.index + 'px' }, opts.speed);
                        break;
                    case 'fade':
                        if(focuser.conbox.css('opacity') == 1){
                            focuser.conbox.css('opacity', 0);
                        }
                        focuser.conbox.animate({'opacity':1}, opts.speed / 2);
                        focuser.conitem.eq(focuser.last_index).stop().css('display', "none").end().eq(focuser.index).css('display', "block").stop();
                        break;
                    case 'none':
                        focuser.conitem.hide().eq(focuser.index).show();
                        break;
                }
                focuser.last_index = focuser.index;
                focuser.index ++;
            },
            stop: function(){
                clearInterval(focuser.timer);
            },
            play: function(){
                if (opts.auto) {
                    focuser.timer = setInterval(focuser.fn.slide, opts.space);
                }
            },
            init: function(){
                if (opts.effect == 'fade') {
                    focuser.conitem.eq(focuser.index).css({'display':"block"}).siblings().css({'display':"none"});
                }
                if (opts.auto){
                    focuser.timer = setInterval(focuser.fn.slide, opts.space);
                }
                focuser.dotitem.bind(opts.event, function() {
                    focuser.index = $(this).index();
                    focuser.fn.stop();
                    focuser.fn.slide();
                    focuser.fn.play();
                });
                focuser.conbox.hover(focuser.fn.stop, focuser.fn.play);
                focuser.fn.slide();
            }
        };
        focuser.fn.init();
    }
})(jQuery);