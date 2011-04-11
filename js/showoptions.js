function showoptions(pid)
{
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("poptions").innerHTML=xmlhttp.responseText;
		}
		if (xmlhttp.readyState==4 && xmlhttp.status==404)
		{
			document.getElementById("poptions").innerHTML='Connection Error';
		}
		if (xmlhttp.readyState!=4)
		{
			document.getElementById("poptions").innerHTML='..Loading..';
		}  
	}
	xmlhttp.open("POST","view.php?fetch=options",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("pid="+pid);
}