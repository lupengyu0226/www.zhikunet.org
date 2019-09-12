/************************************************************************
*************************************************************************
@Name :       	huadong - jQuery Plugin
@Revison :    	2.5
@Date : 		26/01/2011
@Author:     	 Surrel Mickael (www.myjqueryplugins.com - www.msconcept.fr) 
@License :		 Open Source - MIT License : http://www.opensource.org/licenses/mit-license.php
 
**************************************************************************
*************************************************************************/
jQuery.huadong = {
	build : function(options)
	{
        var defaults = {
			txtLock : '发表评论前，请滑动滚动条解锁',
			txtUnlock : '已解锁，可以发表评论了'
        };   
		
		if(this.length>0)
		return jQuery(this).each(function(i) {
			/** Vars **/
			var 
				opts = $.extend(defaults, options),      
				$this = $(this),
				form = $('form').has($this),
				Clr = jQuery('<div>',{'class':'clr'}),
				bgSlider = jQuery('<div>',{id:'bgSlider'}),
				Slider = jQuery('<div>',{id:'Slider'}),
				Icons = jQuery('<div>',{id:'Icons'}),
				TxtStatus = jQuery('<div>',{id:'TxtStatus','class':'dropError',text:opts.txtLock}),
				inputhuadong = jQuery('<input>',{name:'ihuadong',value:generatePass(),type:'hidden'});
			
			/** Disabled submit button **/
			form.find('input[type=\'submit\']').attr('disabled','disabled');
			
			/** Construct DOM **/
			bgSlider.appendTo($this);
			Icons.insertAfter(bgSlider);
			TxtStatus.insertAfter(Icons);
			Clr.insertAfter(TxtStatus);
			inputhuadong.appendTo($this);
			Slider.appendTo(bgSlider);
			$this.show();
			
			Slider.draggable({ 
				containment: bgSlider,
				axis:'x',
				start: function(event,ui){
					$(this).addClass('on');
				},
				stop: function(event,ui){
					if(ui.position.left > 250)
					{
						// set the SESSION ihuadong in PHP file
						$.post("/index.php?app=api&controller=index&op=huadongjquery",{
							action : 'huadong'
						},
						function(data) {
							if(!data.error)
							{
								Slider.draggable('disable').css('cursor','default');
								inputhuadong.val("");
								TxtStatus.text(opts.txtUnlock).addClass('dropSuccess').removeClass('dropError');
								Icons.css('background-position', '-16px 0');
								form.find('input[type=\'submit\']').removeAttr('disabled');
							}
						},'json');
					}else{
						$(this).removeClass('on');
						$(this).css('left',0);
					}
				}
			});
			
			function generatePass() {
		        var chars = 'azertyupqsdfghjkmwxcvbn23456789AZERTYUPQSDFGHJKMWXCVBN';
		        var pass = '';
		        for(i=0;i<10;i++){
		            var wpos = Math.round(Math.random()*chars.length);
		            pass += chars.substring(wpos,wpos+1);
		        }
		        return pass;
		    }
			
		});
	}
}; jQuery.fn.huadong = jQuery.huadong.build;
