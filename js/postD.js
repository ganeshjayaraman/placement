function postD(id)
{
  loadXMLDoc("id="+id+"&t=" + Math.random(),"postD.php",function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    	 foot=jQuery.parseJSON(xmlhttp.responseText);
      
}
	});

}