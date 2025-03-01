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
				         					  
	$Tipo_ID=$_GET['Tipo_ID'];	
	
	$consulta = "SELECT codigo FROM tipo_proyecto WHERE Tipo_ID=".$Tipo_ID; 	 
	$result=$bd->ejecutar($consulta); 
	if (($row = mysqli_fetch_array($result) ))							
	{		
		$Codigo = $row["codigo"];	
	}
	mysqli_free_result($result);
	
	$consulta = "SELECT max(Pro_ID) as Pro_ID FROM proyectos"; 	 
	$result=$bd->ejecutar($consulta); 
	if (($row = mysqli_fetch_array($result) ))							
	{		
		$Pro_ID = $row["Pro_ID"]+1;	
	}
	mysqli_free_result($result);		
				
	$Codigo=$Pro_ID.".".date(y).".".$Codigo;	
	
	echo "<input type='text' id='Codigo' name='Codigo' value='$Codigo'  size='6' onblur=\"Empresas_Nuevo_Proyecto_Validar_Codigo(this.value, '');\"/>";
	echo "<span id='Div_Validar_Codigo'>OK</span>";
	require('Library/Close_Conexion.php');	
?>