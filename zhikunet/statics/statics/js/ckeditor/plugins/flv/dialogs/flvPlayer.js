CKEDITOR.dialog.add('flv',　function(a){
    var b = a.config;
    var　escape　=　function(value){
　　　　　　　　return　value;
　　　　};
　　　　return　{

　　　　　　　　title:　'插入Flv视频',
　　　　　　　　resizable:　CKEDITOR.DIALOG_RESIZE_BOTH,
　　　　　　　　minWidth: 350,
                minHeight: 100,
　　　　　　　　contents:　[{
　　　　　　　　　　id: 'info',
                    label: '常规',
                    accessKey: 'P',
                    elements:[
                        {
                        type: 'hbox',
                        widths : [ '80%', '20%' ],
                        children:[{
                                id: 'src',
                                type: 'text',
                                label: '源文件'
                            },{
                                type: 'button',
                                id: 'browse',
                                filebrowser: 'info:src',
                                hidden: true,
                                align: 'center',
                                label: '浏览服务器'
                            }]
                        },
                        {
                        type: 'hbox',
                        widths : [ '35%', '35%', '30%' ],
                        children:[{
                            type:　'text',
　　　　　　　　　　　　　　label:　'视频宽度',
　　　　　　　　　　　　　　id:　'mywidth',
　　　　　　　　　　　　　　'default':　'570px',
　　　　　　　　　　　　　　style:　'width:50px'
                        },{
                            type:　'text',
　　　　　　　　　　　　　　label:　'视频高度',
　　　　　　　　　　　　　　id:　'myheight',
　　　　　　　　　　　　　　'default':　'480px',
　　　　　　　　　　　　　　style:　'width:50px'
                        },{
                            type:　'select',
　　　　　　　　　　　　　　label:　'自动播放',
　　　　　　　　　　　　　　id:　'myloop',
　　　　　　　　　　　　　　required:　true,
　　　　　　　　　　　　　　'default':　'false',
　　　　　　　　　　　　　　items:　[['是',　'true'],　['否',　'false']]
                        }]//children finish
                        }]
                    }],
　　　　　　　　onOk:　function(){
　　　　　　　　　　　　mywidth　=　this.getValueOf('info',　'mywidth');
　　　　　　　　　　　　myheight　=　this.getValueOf('info',　'myheight');
　　　　　　　　　　　　myloop　=　this.getValueOf('info',　'myloop');
　　　　　　　　　　　　mysrc　=　this.getValueOf('info',　'src');
　　　　　　　　　　　　html　=　''+　Convert_url(mysrc)+'';
　　　　　　　　　　　　//editor.insertHtml("<pre　class=\"brush:"　+　lang　+　";\">"　+　html　+　"</pre>");
　　　　　　　　　　　　a.insertHtml("<p style=\"text-align:center\"><embed height="　+　myheight　+　" width="　+　mywidth　+　" autostart="　+　myloop　+　" flashvars=\""+html+"\" allowfullscreen=\"true\" allowscriptaccess=\"always\" bgcolor=\"#ffffff\" src=\"http://pic.05273.com/statics/js/ckplayer/ckplayer.swf\"></embed></a>");
　　　　　　　　},
　　　　　　　　onLoad:　function(){
　　　　　　　　}
　　　　};
});

　//


function Convert_url(s){
		//alert(s);
			s=s.replace(/http:\/\/www\.56\.com\/u\d+\/v_([\w\-]+)\.html/i, "$1_w")
			.replace(/http:\/\/v\.youku\.com\/v_show\/id_([\w\-=]+)\.html/i,"$1_y")
			.replace(/http:\/\/www.56.com\/w\d+\/play_album\-aid\-\d+_vid\-([^.]+)\.html/i, "$1_y")
			.replace(/http:\/\/v\.ku6\.com\/.+\/([^.]+)\.html/i, "$1_k")
			.replace(/http:\/\/www\.tudou\.com\/programs\/view\/([\w\-]+)\/?/i,"$1_t");
		
		return (s.indexOf("http://")==-1)?"f=http://www.05273.com/api/video.php?url=[$pat]&a="+s+"&s=2&k=&n=&b=1":"f="+s;
	
		
		/*
		return s.replace(/http:\/\/www\.tudou\.com\/programs\/view\/([\w\-]+)\/?/i,"http://www.tudou.com/v/$1")
            .replace(/http:\/\/www\.youtube\.com\/watch\?v=([\w\-]+)/i,"http://www.youtube.com/v/$1")
            .replace(/http:\/\/v\.youku\.com\/v_show\/id_([\w\-=]+)\.html/i,"http://player.youku.com/player.php/sid/$1/v.swf")
            .replace(/http:\/\/www\.56\.com\/u\d+\/v_([\w\-]+)\.html/i, "http://player.56.com/v_$1.swf")
            .replace(/http:\/\/www.56.com\/w\d+\/play_album\-aid\-\d+_vid\-([^.]+)\.html/i, "http://player.56.com/v_$1.swf")
            .replace(/http:\/\/v\.ku6\.com\/.+\/([^.]+)\.html/i, "http://player.ku6.com/refer/$1/v.swf");

		*/
}