<?php
	session_name("Administrador");
	session_start();
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	
	$Pro_ID=$_POST["Pro_ID"];
	$Reg_ID=$_POST["Reg_ID"];	
	$_SESSION["EntityID"] = "";

	if (   ($_POST['user']=="") ||  ($_POST['pass']=="") || (strlen($_POST['user'])>20 ) || ( strlen($_POST['pass'])>20)   )
	{
		echo "User or Password incorrect!";
	}
	else
	{		
		$sql = "select * from personal where Usuario = '".$_POST['user']."' and Password = '".$_POST['pass']."'";
		//echo $sql."<br>";			
		$result=$bd->ejecutar($sql); 		 
		if( ($row = mysqli_fetch_array($result) ) )							
		{	
			$_SESSION["Empleado_ID"] = $row["Empleado_ID"];	
					
			$sqlr = "select * from proyectos p where  p.Pro_ID=".$Pro_ID;
			//echo "Identica si es foreman".$sqlr."<br>";			
			$resultr=$bd->ejecutar($sqlr); 
					while (($rowr = mysqli_fetch_array($resultr) ))		 
					{	
						$Foreman_ID=$rowr["Foreman_ID"];
						$Lead_ID=$rowr["Lead_ID"];
						$PwtSuper=$rowr["Coordinador_ID"];
						echo "Foreman ID".$Foreman_ID." Emple id: ".$_SESSION["Empleado_ID"]."<br>";			
						if ($Foreman_ID==$_SESSION["Empleado_ID"] || $row["Nick_Name"]== "SuperUser" || $Lead_ID==$_SESSION["Empleado_ID"] || $PwtSuper==$_SESSION["Empleado_ID"] )
						{
							$_SESSION["EntityID"] = "Foreman";	
						}
					else
					{
							$_SESSION["EntityID"] = "";	
					}
			echo "datos:".$_SESSION["EntityID"]."<br>";
			
				//require('Library/Close_Conexion.php');	
			}
	
				$_SESSION["Nick_Name"] = $row["Nick_Name"];	
				$_SESSION["Cargo"] = $row["Cargo"];	
?>
			<span style="display:block; text-align:center" ><img src="images/indicator.gif" width="16" height="16" onload="foreman_registro_actividad_detalle(<?php echo $Reg_ID; ?>, <?php echo $Pro_ID; ?>);"  align="middle"/></span>			
<?php		
		}
		else
		{
			echo "User Name or Password Incorrect";
		}

	}
	require('Library/Close_Conexion.php');	
?>


