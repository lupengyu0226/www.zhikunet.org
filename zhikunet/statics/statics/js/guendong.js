function setDivNavigate11(num)
    { 
	    var obj = document.getElementById("u0_" + num)  ;
		var obj_m = document.getElementById("n01_" + num);
		document.getElementById('u0_0').style.display = "none";
 		document.getElementById('u0_1').style.display = "none";
		document.getElementById('u0_2').style.display = "none";
	    if(obj != null)
	    {
	        if(obj.style.display == "none")
	        {
	            obj.style.display = "block";
				obj_m.className='menuOn'; 
				for(var i=0;i<3; i++)
				{
					if ( num !=i )
					{
						document.getElementById("n01_" + i).className='menuOff'; 
					}
				}
				
 	        }
	    }
    }