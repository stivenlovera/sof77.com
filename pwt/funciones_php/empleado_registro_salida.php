<?php	 		

	session_name("Administrador");
	session_start();
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	
		
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');	
	
	$Reg_ID=$_GET["Reg_ID"];
	$Empleado_ID=$_SESSION["Empleado_ID"];	
	

	$strSQL = "UPDATE registro_diario SET Hora_Salida=CURTIME() WHERE Reg_ID=".$Reg_ID;	
	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)
	{
		echo "Registro Satisfactorio";
		//echo "<img src='images/spacer.gif' onload='empleado_registro_actividad(".$Reg_ID.");' />";

	}

?>
	
<?php
	require('Library/Close_Conexion.php');	

?>
