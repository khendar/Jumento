// JavaScript Document

			function confirm_entry(action, element, id)
			{
				input_box=confirm("Are you sure you want to " + action + " " + element + " " + id + " ?");
				if (input_box==true)
				 {
					// Output when OK is clicked
					return true;
				}
				else
				{
					// Output when Cancel is clicked
					return false;
				}
				return true;
			}	

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}


var key = Array();
key['['] = "MM_showHideLayers('admincontrols','','show');";
key[']'] = "MM_showHideLayers('admincontrols','','hide');";
key[','] = "MM_showHideLayers('login','','show');";
key['.'] = "MM_showHideLayers('login','','hide');";



var isNav = (navigator.appName.indexOf("Netscape") !=-1);
document.onkeypress = getKey;

function getKey(keyStroke) {
keyHit = (isNav) ? keyStroke.which : event.keyCode;
whichKey = String.fromCharCode(keyHit).toLowerCase();
for (var i in key) if (whichKey == i) eval(key[i]); 
}
	