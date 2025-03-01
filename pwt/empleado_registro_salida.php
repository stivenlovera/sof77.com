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
	

	$strSQL = "UPDATE registro_diario SET Hora_Salida=UTC_TIME() WHERE Reg_ID=".$Reg_ID;	
	$res1=$bd->ejecutar($strSQL);  		

	if ($res1)
	{
		echo "Registro Satisfactorio";
		echo "<img src='images/spacer.gif' width='16' height='16' onload=\"empleado_registro_actividad(".$Reg_ID.");\"  align='middle'/>";
	}

?>
	
<?php
	require('Library/Close_Conexion.php');	

?>
