function swapAon(n){
	for(var i=1;i<=4;i++){
		var dd=document.getElementById("aa_"+i);
		var cc=document.getElementById("ab_"+i);
		if(i==n){
			dd.className="";
			cc.style.display="block";
		}else{
			dd.className="";
			cc.style.display="none";
		}
	}
}
