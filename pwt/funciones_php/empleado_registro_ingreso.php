
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

	$Empleado_ID=$_SESSION["Empleado_ID"];	
	

	$strSQL = "INSERT INTO registro_diario (Empleado_ID, Hora_Ingreso, Fecha) ";	
	$strSQL = $strSQL . " values (".$Empleado_ID.",CURTIME(), CURDATE())";	
	$result2=$bd->ejecutar($strSQL); 
	//echo $strSQL;
	if ($result2)
		echo "Registro de Ingreso Satisfactorio.";
	else
		echo "Error en Registro";
?>

	

<?php
	require('Library/Close_Conexion.php');	

?>