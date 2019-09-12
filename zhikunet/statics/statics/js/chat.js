function del(id,type){
	if(type==-1&& !confirm('您确定删除吗？')){
		return false;
	}
	
	$.get('del.php?id='+id,function(data){if(data==1){$('#id_'+id).remove();}});
}

//清除提示，显示统计数字内容
function show_msg(){
$(".countTxt").empty().append("还能输入<em class=\"counter\">140</em>字");
}
function recount(){       
   var maxlen=140;       
   var current = maxlen-$('#saytxt').val().length;       
   $('.counter').html(current);        
 
   if(current<1 || current>maxlen){           
       $('.counter').css('color','#D40D12');           
       $('input.sub_btn').attr('disabled','disabled');       
   }       
   else           
      $('input.sub_btn').removeAttr('disabled');        
   if(current<10)           
      $('.counter').css('color','#D40D12');        
   else if(current<20)           
      $('.counter').css('color','#5C0002');        
   else           
      $('.counter').css('color','#cccccc');    
} 

