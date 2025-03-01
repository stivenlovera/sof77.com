<?php
	session_name("Administrador");
	session_start();
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	

	if (   ($_POST['user']=="") ||  ($_POST['pass']=="") || (strlen($_POST['user'])>20 ) || ( strlen($_POST['pass'])>20)   )
	{
		echo "User and/or Pass Incorrect -!";
	}
	else
	{		
		$sql = "select * from personal where Usuario = '".$_POST['user']."' and Password = '".$_POST['pass']."'";
		//echo $sql."<br>";			
		$result=$bd->ejecutar($sql); 		 
		if( ($row = mysqli_fetch_array($result) ) )							
		{	
			$_SESSION["Empleado_ID"] = $row["Empleado_ID"];	
			$_SESSION["EntityID"] = "Foreman";
			$_SESSION["Nick_Name"] = $row["Nick_Name"];
			
			$vfrom_date = $_POST['Date_Work'];
			
			$vdia=substr($vfrom_date,3,2);
			$vmes=substr($vfrom_date,0,2);
			$vano=substr($vfrom_date,8,2);
			$Date_Work="20".$vano."-".$vmes."-".$vdia;
			
			$_SESSION["Date_Work"] = $Date_Work;				
		
			/*$_SESSION["EntityID"] = $row["EntityID"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["OperatorID"] = $row["OperatorID"];
			$_SESSION["OperatorName"] = $row["name"]." ".$row["lastname"]; 

			$sql = "select Agent_id, Agent_description from agents where Agent_id = '".$_SESSION["EntityID"]."'";	
			//echo $sql."<br>";
	 		$result=$bd->ejecutar($sql); 
			if ( ($row = mysqli_fetch_array($result) ) )							
			{			
				 $_SESSION["NameEntity"] = $row["Agent_description"];
			}		
	
			$sql = "select Rol_ID from operatorroles where OperatorID = ".$_SESSION["OperatorID"];			
			//echo $sql."<br>";
	 		$result=$bd->ejecutar($sql); 
			if ( ($row = mysqli_fetch_array($result) ) )							
				$_SESSION["Rol_ID"] = $row["Rol_ID"];
			else
				$_SESSION["Rol_ID"] = "";
			//echo $_SESSION["EntityID"] ;*/
?>
			<span style="display:block; text-align:center" ><img src="images/indicator.gif" width="16" height="16" onload="window.open('foreman_registro.php','_self'); "  align="middle"/></span>
			
<?php		
		}
		else
		{
			echo "User and/or Pass Incorrect -!!";
		}

	}
	require('Library/Close_Conexion.php');	
?>


