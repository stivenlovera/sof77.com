
<script type="text/javascript">
/***********************************************
* Local Time script- © Dynamic Drive (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var weekdaystxt=["Dom", "Lun", "Mar", "Mier", "Jue", "Vie", "Sab"]


function showLocalTime(container, servermode, offsetMinutes, displayversion){
if (!document.getElementById || !document.getElementById(container)) return
this.container=document.getElementById(container)
this.displayversion=displayversion
var servertimestring=(servermode=="server-php")? '<?php echo date("F d, Y H:i:s", time());?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<?php echo date("m/d/y") ?>'
this.localtime=this.serverdate=new Date(servertimestring)
this.localtime.setTime(this.serverdate.getTime()+offsetMinutes*60*1000) //add user offset to server time
this.updateTime()
this.updateContainer()
}

showLocalTime.prototype.updateTime=function(){
var thisobj=this
this.localtime.setSeconds(this.localtime.getSeconds()+1)
setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
}

showLocalTime.prototype.updateContainer=function(){
var thisobj=this
if (this.displayversion=="long")
this.container.innerHTML=this.localtime.toLocaleString()
else{
var hour=this.localtime.getHours()
var minutes=this.localtime.getMinutes()
var seconds=this.localtime.getSeconds()
var ampm=(hour>=12)? "PM" : "AM"
var dayofweek=weekdaystxt[this.localtime.getDay()]
this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes)+":"+formatField(seconds)+" "+ampm+" ("+dayofweek+")"
}
setTimeout(function(){thisobj.updateContainer()}, 1000) //update container every second
}

function formatField(num, isHour){
if (typeof isHour!="undefined"){ //if this is the hour field
var hour=(num>12)? num-12 : num
return (hour==0)? 12 : hour
}
return (num<=9)? "0"+num : num//if this is minute or sec field
}
</script>
<table width="100%" border="0" bgcolor="#E4E9F1" cellpadding="0" cellspacing="0">
  <tr>
  		<td><!--<img src="imagenes/logobnp1.gif" alt="Billing and Payment" >/-->
			<img src="../imagenes/logo_skype2phone_fondo.gif" alt="Billing and Payment" width="180" height="120" >
	  	</td>
<td valign="top" >&nbsp;



</td>
<td align="right" width="350">
<table width="100%" border="0"><tr><td width="50%" class="callfree_new">
<b>Bolivia:<span id="timecontainer"></span></b><br />
Espa&ntilde;a:<span id="timecontainer5"></span><br />
<b>Bogot&aacute;:<span id="timecontainer6"></span></b>
</td>
    <td width="50%" class="callfree_new">
California:<span id="timecontainer2"></span><br />
<b>Texas:<span id="timecontainer3"></span><br /></b>
Miami:<span id="timecontainer4"></span>
</td></tr></table>


<script type="text/javascript">
new showLocalTime("timecontainer", "server-asp", 0, "short")  //60'
new showLocalTime("timecontainer2", "server-asp", -180, "short")
new showLocalTime("timecontainer3", "server-asp", -60, "short")
new showLocalTime("timecontainer4", "server-asp", 0, "short")
new showLocalTime("timecontainer5", "server-asp", 240, "short") //360'
new showLocalTime("timecontainer6", "server-asp", -60, "short") //0'

//new showLocalTime("timecontainer", "server-asp", 60, "short")  //60'
//new showLocalTime("timecontainer2", "server-asp", -120, "short")
//new showLocalTime("timecontainer3", "server-asp", -00, "short")
//new showLocalTime("timecontainer4", "server-asp", 60, "short")
//new showLocalTime("timecontainer5", "server-asp", 360, "short") //360'
//new showLocalTime("timecontainer6", "server-asp", -0, "short") //0'

</script>





</td>
</td></tr>

<?php
if ($_SESSION["EntityID"] != "") 
{
?>
<tr height="25">
<td align="left" valign="bottom" class="callfree_new">

<?php
  	     
echo "&nbsp;&nbsp;&nbsp;Agente: <b>".$_SESSION["NameEntity"]."</b>&nbsp;&nbsp;&nbsp; Operador: <b>".$_SESSION["OperatorName"]."</b>";
  	 
?>   

</td>
<td colspan="3" align="right">
<?php 	if ($_SESSION["BnPHeader"]=="true") 
		{
?>
<a href="logout.php" class="enlaceboton">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
<?php 	} 
		else 
		{ ?>
<a href="../index_sistema.php" class="enlaceboton">Inicio</a>&nbsp;&nbsp;
<a href="../logout.php" class="enlaceboton">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
<?php 	} ?>
</td></tr>

<?php } ?>
<tr>
<td colspan="4" background="imagenes/tnbarra.jpg" height="7" ><img src="Imagenes/spacer.gif" border="0" height="5" /></td>
</tr>
</table>
