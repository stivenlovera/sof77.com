<?php
	session_name("Administrador");
	session_start();

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	
	if ($_SESSION["EntityID"] == "")
	{
		header("Location: login_sistema.php?msg=Sesion expirada"); 			
		//echo  $_SESSION["EntityID"]."***".$_SESSION["username"]."***".$_SESSION["OperatorID"]."***".$_SESSION["OperatorName"];
	}

	$_SESSION["PageTitle"] = "MENU";
	//echo  $_SESSION["EntityID"]."***".$_SESSION["username"]."***".$_SESSION["OperatorID"]."***".$_SESSION["OperatorName"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252"/>
<title>IP - <?php echo $_SESSION["NameEntity"]; ?> - Menu </title>
<link rel="STYLESHEET" type="text/css" href="include/Stat.css"/>
<style type="text/css">
A.menulink
{
display: block;
width: 198px;
text-align: left;
text-decoration: none;
font-family:arial;
font-size:12px;
/*color: #000000;*/
BORDER: none;
/*border: solid 1px #FFFFFF;*/
}

A.menulink:hover 
{
/*border: solid 1px #6100C1;*/
border:none;
background-color:#CFD3E9;
}
</style>

</head>

<body link="#5865AF" vlink="#5865AF" alink="#5865AF" style="background: url(images/globolines.jpg)  center no-repeat" >
<?php  
	$_SESSION["BnPHeader"]="true"; 
	require('Header.php');

	$_SESSION["BnPHeader"] = "";

	if ($_SESSION["EntityID"] != "" )
	{
?>
<br>
<br>
<?php  
   //Set MenuPpal = server.CreateObject ("ADODB.recordset")
   //Set $SubMenuOptions = server.CreateObject ("ADODB.recordset")
   //Set SubMenu1 = server.CreateObject ("ADODB.recordset")

   //$str = "select * from bnp_menuitems where Mnu_ID in (select Mnu_ID from bnp_rolesmenuitems where Rol_ID in (select Rol_ID from bnp_operatorroles where OperatorID = ".$_SESSION["OperatorID"].")) and Mnu_parentID is null order by Mnu_Position"; 
   $sql="SELECT m.*  FROM menuitems m LEFT JOIN rolesmenuitems rm ON m.mnu_id = rm.mnu_id WHERE rm.Rol_ID =".$_SESSION["Rol_ID"]." AND m.Mnu_parentID IS NULL AND Mnu_IsMenu ORDER BY m.Mnu_Position ";   
   
   //echo $sql."<br>";
   $result1=$bd->ejecutar($sql); 		  
?>
<table border="0" cellpadding="0" style="border-collapse: collapse"  width="100%" id="AutoNumber1">   
	<tr>  
<?php
	  $i=1;
	  while ( $MenuPpal = mysqli_fetch_array($result1) )	
	  { 
			?>
					<td valign="top">    
						<table border="0" width=198 >
							<tr>
								<td width="200" bgcolor="#5865AF" height="19" colspan="2">
								  	<span lang="es">
									  	<b><font face="Arial" color="#FFFFFF"><?php echo $MenuPpal["Mnu_Description"]; ?></font></b>
									</span>
								</td>
							</tr>  
						 					  
			<?php
						   $sql = "SELECT m.*  FROM menuitems m LEFT JOIN rolesmenuitems rm ON m.mnu_id = rm.mnu_id WHERE rm.Rol_ID =".$_SESSION["Rol_ID"]." AND m.Mnu_parentID= ".$MenuPpal["Mnu_ID"]." AND Mnu_IsMenu ORDER BY m.Mnu_Position ";	
						   //echo $sql;			   
							$result3=$bd->ejecutar($sql); 		         	
							while ( $SubMenuOptions = mysqli_fetch_array($result3) )	
							{  
				?>
									 <tr>
										<td width="100%" height="17">
										<img border="0" src="images/arrow_right_sobre.gif" width="18" height="15"></td>
										<td width="100%" height="17"><a href="<?php echo $SubMenuOptions["Mnu_URL"]; ?>" class="menulink"><?php echo $SubMenuOptions["Mnu_Description"] ?></a></td>
									 </tr>  
				  <?php  							 
							
						  }//while
						  mysqli_free_result($result3);
					
		 ?>
				</table>
			</td>    
		<?php
			$i++;    
			if ($i == 6) 
			{
			?>
			</tr>     
			<tr>  
		<?php
    		}
  }//while
  mysqli_free_result($result1);
 ?>
	</tr> 
</table>
<?php	
}
else
{
?>
 <script>
  	alert("Su Sesion a Expirado Inicie sesion Nuevamente")
  	//window.open('login_sistema.php','_self');
 </script>
<?php
	header("Location: index.php"); 
}
require('Library/Close_Conexion.php');	
?>
</body>
</html>
