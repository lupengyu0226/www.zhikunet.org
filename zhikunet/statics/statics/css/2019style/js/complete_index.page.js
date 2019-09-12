var serachObj 		= document.getElementById('keywords');
var searchThinkObj 	= document.getElementById('search_think');
var focus_ThinkObj	= false;
var keywordjsx="";

document.getElementById('search_box').onmouseover = function(e){	focus_ThinkObj = true;	};
document.getElementById('search_box').onmouseout = function(e){	    focus_ThinkObj = false;	};

serachObj.onfocus = function(e)
{
    if(this.value == keywordjsx)
    {
        this.value = '';
    }
    //setSearchItem();
};
serachObj.onblur= function(e)
{
    if(!focus_ThinkObj)
    {
        if(this.value == '')
        {
            this.value = keywordjsx;
        }
        searchThinkObj.style.display = 'none';
    }
};

var think_id_now = -1;
var think_num = 0;
var think_url = '';
var word = serachObj.value;

serachObj.onkeyup = function(e)
{
    if(!e)	var e=window.event;
    var num = e.which||window.event.keyCode;

    if(num == 13) //回车
    {
        if(serachObj.value==word)
        {
            try
            {
                tj('h0','');
            }
            catch(e)
            {

            }
            doBaiduSo();
        }
        else
        {
            setSearchItem();
        }
    }
    else if(num == 38) //向上
    {
        think_id_now = (think_id_now+think_num-1)%think_num;
        document.getElementById('think'+think_id_now).className = 'active';
        document.getElementById('think'+(think_id_now+1)%think_num).className = '';
        serachObj.value = document.getElementById('think'+think_id_now).innerHTML;
        think_url = document.getElementById('think'+think_id_now).href;
    }
    else if(num == 40) //向下
    {
        think_id_now = (think_id_now+1)%think_num;
        document.getElementById('think'+think_id_now).className = 'active';
        document.getElementById('think'+(think_id_now+think_num-1)%think_num).className = '';
        serachObj.value = document.getElementById('think'+think_id_now).innerHTML;
        think_url = document.getElementById('think'+think_id_now).href;
    }
    else
    {
        think_url = "";
        setSearchItem();
    }

    word = serachObj.value;
};

function setSearchItem()
{
    var url = encodeURI("/soft/autosoftlistindex/?term="+serachObj.value);
    $.ajax({
        type:"GET",
        url:url,
        dataType:"json",
        success:function(data){
            if(!data)
            {
                searchThinkObj.style.display = 'none';

                return;
            }
            try
            {
                var inner = '';
                think_num = data.length;
                for(var i=0;i<think_num;i++)
                {
                    inner += '<a id="think'+i+'" target="_blank" onclick="tj(\'h0\',\'\');thinkClick('+data[i].id+');" href="'+data[i].link_url+'" >'+data[i].soft_name+' '+data[i].soft_edition+'</a>';
                }

                document.getElementById('think_ret').innerHTML = inner;
                if(data[0])
                {
                    if(data[0].link_url)
                    {
                        searchThinkObj.style.display = 'block';
                    }
                }
                else
                {
                    searchThinkObj.style.display = 'none';
                }

            }
            catch(e)
            {
                searchThinkObj.style.display = 'none';
                console.log(e);
            }
        }
    });
}

function thinkClick(sfid)
{
    searchThinkObj.style.display = 'none';
}

function startSearch()
{
    if(think_url)
    {
        location.href = think_url;
    }
}