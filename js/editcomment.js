function editcomment(cid,file)
{
	if (window.XMLHttpRequest)
	{
	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
	// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("comment"+cid).innerHTML=xmlhttp.responseText;
		}
		if (xmlhttp.readyState==4 && xmlhttp.status==404)
		{
			document.getElementById("comment"+cid).innerHTML='Connection Error';
		}
		if (xmlhttp.readyState!=4)
		{
			document.getElementById("comment"+cid).innerHTML='..Loading..';
		}  
	}
	xmlhttp.open("POST",file+"?fetch=comments",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cid="+cid);
}