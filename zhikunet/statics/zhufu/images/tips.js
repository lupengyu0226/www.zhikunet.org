
/*
 * created by hobo
 */

try
{
	document.domain = "05273.com";
}
catch (e)
{
}
var Tips = {
	curObject: null,
	maxZIndex: 100000000,
	scripWidth: 760,
	scripHeight: 500,
	scripX: 0,
	scripY: 0,

	setZIndex: function(o)
	{
		o.style.zIndex = Tips.maxZIndex++;
	},

	Mouse: {
		down: function(o, e)
		{
			Tips.setZIndex(o);
			Tips.curObject = o;

			if (!!document.all)
			{
				Tips.curObject.setCapture();
				Tips.curObject.style.top = Tips.curObject.style.pixelTop - 5 + "px";
				Tips.curObject.style.left = Tips.curObject.style.pixelLeft - 3 + "px";
				Tips.scripX = event.x - Tips.curObject.style.pixelLeft;
				Tips.scripY = event.y - Tips.curObject.style.pixelTop;
			}
			else if (window.captureEvents)
			{
				window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
				Tips.curObject.style.top = parseInt(Tips.curObject.style.top) - 5 + "px";
				Tips.curObject.style.left = parseInt(Tips.curObject.style.left)- 3 + "px";
				Tips.scripX = e.clientX - parseInt(Tips.curObject.style.left);
				Tips.scripY = e.clientY - parseInt(Tips.curObject.style.top);
			}
		},

		move: function(e)
		{
			if (!!Tips.curObject)
			{
				if (!!document.all)
				{
					Tips.curObject.style.left = event.x - Tips.scripX + "px";
					Tips.curObject.style.top = event.y - Tips.scripY + "px";
				}
				else if (window.captureEvents)
				{
					Tips.curObject.style.left = e.clientX - Tips.scripX + "px";
					Tips.curObject.style.top  = e.clientY - Tips.scripY + "px";
				}
			}
		},

		up: function(e)
		{
			if (!!Tips.curObject)
			{
				if (document.all)
				{
					Tips.curObject.releaseCapture();
					Tips.curObject.style.top = Tips.curObject.style.pixelTop + 5 + "px";
					Tips.curObject.style.left = Tips.curObject.style.pixelLeft + 3 + "px";
					Tips.curObject = null;
				}
				else if (window.captureEvents)
				{
					window.releaseEvents(Event.MOUSEMOVE|Event.MOUSEUP);
					Tips.curObject.style.top = parseInt(Tips.curObject.style.top) + 5 + "px";
					Tips.curObject.style.left = parseInt(Tips.curObject.style.left)+ 3 + "px";
					Tips.curObject = null;
				}
			}
		}
	},
};
function Close(n){
	var e='Layer'+n;											
	document.getElementById(e).style.display='none';
}	
document.onmouseup = Tips.Mouse.up;
document.onmousemove = Tips.Mouse.move;