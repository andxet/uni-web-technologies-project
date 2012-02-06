function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  		x=x.replace(/^\s+|\s+$/g,"");
  	if (x==c_name)
    {
   		return unescape(y);
    }
  }
}

function stampaVisite()
{
	var visite=getCookie("visite");
  	if (visite!=null && visite!="")
  	{
  			visite = Number(visite) + 1;
  			setCookie("visite", visite,365);
  			document.write("<p>Questa &egrave; la tua " + visite + "a visita a Fumezzi!</p>");

  	}
	else 
  	{
   		setCookie("visite", 0,365);
   		document.write("<p>Questa &egrave; la tua prima visita a Fumezzi!</p>");
  	}
}