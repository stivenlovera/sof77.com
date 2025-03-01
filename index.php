<?php
	session_name("Administrador");
	session_start();	
	require('Library/Control_Cache.php');	
	$_SESSION["PageTitle"] = "";
	$_SESSION["EntityID"] = "";
	$_SESSION["username"] = "";
	$_SESSION["OperatorID"] = "";
	$_SESSION["OperatorName"] = "";
	$_SESSION["timestamp"]=time(); 
?>
<html>
<head>
<title>IP v.1</title>
<meta http-equiv="Content-Type" content="text/html; ">
<meta name="viewport" content="width=device-width, user-scalable=no">
<link rel="STYLESHEET" type="text/css" href="include/Stat.css">
<script type="text/javascript" src="include/jquery-1.3.2.js"></script>
<script type="text/javascript" src="include/getAjax.js"></script> 
<script type="text/javascript" src="include/datepickercontrol.js"></script>

<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"/> 

<script type="text/javascript">	
               
function SendEnter (event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {		
				postAx('foreman_validaPassword.php','user='+document.ss.username.value+'&pass='+document.ss.password.value+'&Date_Work='+document.ss.Date_Work.value,'passWrong',15);			
		} 
		else
		return true;
	}   

function SendClick () 
{	
	postAx('foreman_validaPassword.php','user='+document.ss.username.value+'&pass='+document.ss.password.value+'&Date_Work='+document.ss.Date_Work.value,'passWrong',15);			
}      

function postAxLog (url,valores, capa, alto) {
   var ajax=creaAjax();
   var capaContenedora = document.getElementById(capa);

/*Creamos y ejecutamos la instancia si el metodo elegido es POST*/

    ajax.open ('POST', url, true);
    ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
                 capaContenedora.innerHTML="<table width=\"100%\"><tr><td align=\"center\" valign=\"middle\" height=\""+alto+"\"><img src=\"images\\indicatortext.gif\" width=\"80\" height=\"16\" border=0></td></tr></table>";
         }
         else if (ajax.readyState==4){
            if(ajax.status==200)
            {
                 document.getElementById(capa).innerHTML=ajax.responseText; 
            }
            else if(ajax.status==404)
                 {

                     capaContenedora.innerHTML = "La direccion no existe";
                 }
             else
                 {
                     capaContenedora.innerHTML = "Error: " + ajax.status + " " + ajax.responseText;
                 }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(valores);
    return;
}
</script>
<style type="text/css">
<!--
.sinput {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
</head>
<body>
<img src="images/indicator.gif" width="1" height="1" >
<p>&nbsp;</p>


<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" height="100%">
  <tr>
    <td valign="middle"><table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td> 
		  <form name="ss">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" height="160">
               <tr>
                  	<td width="50%" rowspan="2" bgcolor="#E4E9F1" >
						<div align="center"><img src="images/loginforeman.jpg" alt="PWT" width="300" height="150" ><br>
						  <br>
						  <br>
						</div>
					</td>
                  	<td width="50%" bgcolor="#efefef" >__________STP-TIME CARDS____&nbsp;<br>
                    <table width="100%" border="0" cellspacing="0" cellpadding="5">                    
                    <tr>
                        <td>Date: </td>
                        <td><input type="text" id="Date_Work" name="Date_Work" class="sinput" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/></td>
                      </tr>
                      <tr>
                        <td>User: </td>
                        <td><input name="username" type="text" class="sinput" id="username" onKeyPress="return SendEnter(event)"></td>
                      </tr>
                      <tr>
                        <td>Password: </td>
                        <td><input name="password" type="password" class="sinput" id="password" onKeyPress="return SendEnter(event)"></td>
                      </tr>
                      <tr height="20">
                        <td></td>
                        <td><div align="center">
                          <input type="button" value="Enter" onClick="SendClick();//postAx('validaPassword.php','user='+document.ss.username.value+'&pass='+document.ss.password.value,'passWrong',16);"/>                          
                        </div></td>
                      </tr>
                    </table>                  </td>
                </tr>
                <tr>
                  <td bgcolor="#efefef" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  align="center"><font color="red"><div id="passWrong" style="height:25px;"><?php echo "Enter Username and Password"; ?></div></font></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
			  <div align="right">
          <font color="#666666">.......</font></div>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td ></td>
  </tr>
</table>

<br>
<br>
</body>
</html>
