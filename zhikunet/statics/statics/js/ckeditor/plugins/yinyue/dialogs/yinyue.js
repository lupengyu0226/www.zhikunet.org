CKEDITOR.dialog.add('yinyue',　function(a){
    var b = a.config;
    var　escape　=　function(value){
　　　　　　　　return　value;
　　　　};
　　　　return　{

　　　　　　　　title:　'插入MP3',
　　　　　　　　resizable:　CKEDITOR.DIALOG_RESIZE_BOTH,
　　　　　　　　minWidth: 350,
                minHeight: 300,
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

                            type:　'select',
　　　　　　　　　　　　　　label:　'自动播放',
　　　　　　　　　　　　　　id:　'myloop',
　　　　　　　　　　　　　　required:　0,
　　　　　　　　　　　　　　'default':　'1',
　　　　　　　　　　　　　　items:　[['是',　'1'],　['否',　'0']]
                        }]//children finish
                    }, {
                        id: 'Upload',
                        hidden: true,
                        filebrowser: 'uploadButton',
                        label: '上传',
                        elements: [{
                            type: 'file',
                            id: 'upload',
                            label: '上传',
                            size: 38
                        },
                        {
                            type: 'fileButton',
                            id: 'uploadButton',
                            label: '发送到服务器',
                            filebrowser: 'info:src',
                            'for': ['Upload', 'upload']//'page_id', 'element_id'
                        }]
　　　　　　　　}],
　　　　　　　　onOk:　function(){
　　　　　　　　　　　　myloop　=　this.getValueOf('info',　'myloop');
　　　　　　　　　　　　mysrc　=　this.getValueOf('info',　'src');
　　　　　　　　　　　　html　=　''　+　escape(mysrc)　+　'';
　　　　　　　　　　　　//editor.insertHtml("<pre　class=\"brush:"　+　lang　+　";\">"　+　html　+　"</pre>");
　　　　　　　　　　　　a.insertHtml("<embed height=\"320\" width=\"630\" flashvars=\"icon=false\&src="　+　html　+　"\&skin=" +b.flv_path + "player\/skin.zip\&auto_play="　+　myloop　+　"\&play_mode=1 allowfullscreen=\"true\" allowscriptaccess=\"always\" bgcolor=\"#ffffff\" src=\"" + b.flv_path +"player\/player.swf\"></embed>");
　　　　　　　},
　　　　　　　　onLoad:　function(){
　　　　　　　　}
　　　　};
});