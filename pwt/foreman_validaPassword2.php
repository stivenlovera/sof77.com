<?php
	session_name("Administrador");
	session_start();
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	
	$Pro_ID=$_POST["Pro_ID"];
	$Reg_ID=$_POST["Reg_ID"];	

	if (   ($_POST['user']=="") ||  ($_POST['pass']=="") || (strlen($_POST['user'])>20 ) || ( strlen($_POST['pass'])>20)   )
	{
		echo "User or Password incorrect !!";
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
?>
			<span style="display:block; text-align:center" ><img src="images/indicator.gif" width="16" height="16" onload="foreman_registro_actividad_detalle(<?php echo $Reg_ID; ?>, <?php echo $Pro_ID; ?>);"  align="middle"/></span>			
<?php		
		}
		else
		{
			echo "User or Password incorrect !!";
		}

	}
	require('Library/Close_Conexion.php');	
?>


