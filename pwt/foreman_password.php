<?php
	session_name("Administrador");
	session_start();	
	require('Library/Control_Cache.php');		
	
	$Pro_ID=$_GET["Pro_ID"];
	$Reg_ID=$_GET["Reg_ID"];
?>
</head>
<body>
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
						<div align="center">&nbsp;<img src="images/logo.gif" alt="PWT" width="300" height="150" ><br>
						  <br>
						  <br>
						</div>
					</td>
                  	<td width="50%" bgcolor="#efefef" ><br>
                    <table width="100%" border="0" cellspacing="0" cellpadding="5">
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
                          <input type="button" value="In" onClick="SendClick();//postAx('validaPassword.php','user='+document.ss.username.value+'&pass='+document.ss.password.value,'passWrong',16);"/>   
						  <input type="hidden" name="Pro_ID" id="Pro_ID"   value="<?php echo $Pro_ID; ?>"> 
						  <input type="hidden" name="Reg_ID" id="Reg_ID"   value="<?php echo $Reg_ID; ?>">                     
                        </div></td>
                      </tr>
                    </table>                  </td>
                </tr>
                <tr>
                  <td bgcolor="#efefef" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  align="center"><font color="red"><div id="passWrong" style="height:25px;"><?php echo "Input Username and Password"; ?></div></font></td>
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